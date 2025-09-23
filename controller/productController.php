<?php
include "../config/db.php";

// create function
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $unit  = trim($_POST['unit'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $code = trim($_POST['code'] ?? '');

    if (empty($name) || empty($unit) || empty($code) || $price <= 0) {
        echo "<script>
            alert('Semua field harus diisi dengan benar!');
            window.location.href = '/index.php';
        </script>";
        exit;
    }

$image = "";
if (!empty($_FILES['image']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>
            alert('Tipe file tidak diizinkan! Hanya JPG, PNG, dan GIF yang diperbolehkan.');
            window.location.href = '/index.php';
        </script>";
        exit;
    }

    if ($fileSize > $maxSize) {
        echo "<script>
            alert('Ukuran file terlalu besar! Maksimal 5MB.');
            window.location.href = '/index.php';
        </script>";
        exit;
    }

    $uploadDir = __DIR__ . "/../public/uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    $uniqueName = hash('sha256', uniqid() . microtime()) . "." . $ext;

    $targetPath = $uploadDir . $uniqueName;

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
        echo "<script>
            alert('Gagal mengupload file!');
            window.location.href = '/index.php';
        </script>";
        exit;
    }

    $image = "../public/uploads/" . $uniqueName;
}

    $stmt = $conn->prepare("INSERT INTO products (code, name, unit, price, image) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "<script>
            alert('Gagal menyiapkan query: " . $conn->error . "');
            window.location.href = '/index.php';
        </script>";
        exit;
    }

    $stmt->bind_param("sssds", $code, $name, $unit, $price, $image);
    
    if ($stmt->execute()) {
        echo "<script>
            alert('Produk telah berhasil ditambahkan!');
            window.location.href = '/index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menambahkan produk: " . $stmt->error . "');
            window.location.href = '/index.php';
        </script>";
    }
    
    $stmt->close();
    $conn->close();
    exit;
}

// update function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $unit = trim($_POST['unit'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $code = trim($_POST['code'] ?? '');

    if ($id <= 0 || empty($name) || empty($unit) || empty($code) || $price <= 0) {
        echo "<script>
            alert('Semua field harus diisi dengan benar!');
            window.location.href = '/index.php';
        </script>";
        exit;
    }

    $image = "";
    $updateImage = false;

    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>
                alert('Tipe file tidak diizinkan! Hanya JPG, PNG, dan GIF yang diperbolehkan.');
                window.location.href = '/index.php';
            </script>";
            exit;
        }

        if ($fileSize > $maxSize) {
            echo "<script>
                alert('Ukuran file terlalu besar! Maksimal 5MB.');
                window.location.href = '/index.php';
            </script>";
            exit;
        }

        $uploadDir = __DIR__ . "../../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uniqueName = hash('sha256', uniqid() . microtime()) . "." . $ext;
        $targetPath = $uploadDir . $uniqueName;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
            echo "<script>
                alert('Gagal mengupload file!');
                window.location.href = '/index.php';
            </script>";
            exit;
        }

        $image = "backend/uploads/" . $uniqueName;
        $updateImage = true;
    }

    if ($updateImage) {
        $stmt = $conn->prepare("UPDATE products SET code=?, name=?, unit=?, price=?, image=? WHERE id=?");
        if (!$stmt) {
            echo "<script>
                alert('Gagal menyiapkan query: " . $conn->error . "');
                window.location.href = '/index.php';
            </script>";
            exit;
        }
        $stmt->bind_param("sssdsi", $code, $name, $unit, $price, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET code=?, name=?, unit=?, price=? WHERE id=?");
        if (!$stmt) {
            echo "<script>
                alert('Gagal menyiapkan query: " . $conn->error . "');
                window.location.href = '/index.php';
            </script>";
            exit;
        }
        $stmt->bind_param("sssdi", $code, $name, $unit, $price, $id);
    }

    if ($stmt->execute()) {
        echo "<script>
            alert('Produk telah berhasil diupdate!');
            window.location.href = '/index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal mengupdate produk: " . $stmt->error . "');
            window.location.href = '/index.php';
        </script>";
    }

    $stmt->close();
    exit;
}

// delete function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo "<script>
            alert('ID produk tidak valid!');
            window.location.href = '/index.php';
        </script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT image FROM products WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $imagePath = $row['image'];
            if (!empty($imagePath)) {
                $fullImagePath = __DIR__ . "../../uploads/" . basename($imagePath);
                if (file_exists($fullImagePath)) {
                    unlink($fullImagePath);
                }
            }
        }
        $stmt->close();
    }

    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    if (!$stmt) {
        echo "<script>
            alert('Gagal menyiapkan query: " . $conn->error . "');
            window.location.href = '/index.php';
        </script>";
        exit;
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Produk telah berhasil dihapus!');
            window.location.href = '/index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus produk: " . $stmt->error . "');
            window.location.href = '/index.php';
        </script>";
    }

    $stmt->close();
    exit;
}

$conn->close();
?>
