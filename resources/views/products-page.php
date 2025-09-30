<?php require_once __DIR__ . '/../../config/db.php' ?>

<?php
// Ambil data sekali, simpan ke array
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<div class="page-content d-none" id="products-page">
  <div class="page-header">
    <h1 class="page-title">Kelola Produk</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
      <i class="bi bi-plus-circle"></i> Tambah Produk
    </button>
  </div>

  <div class="data-table-container">
    <div class="table-header">
      <h3 class="table-title">Daftar Produk</h3>
      <div class="search-box">
        <i class="bi bi-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Cari produk..." id="productSearch">
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover" id="productsTable">
        <thead>
          <tr>
            <th>Gambar</th>
            <th data-sort="code">Kode</th>
            <th data-sort="name">Nama Produk</th>
            <th data-sort="unit">Satuan</th>
            <th data-sort="price">Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $row): ?>
            <tr>
              <td>
                <?php if (!empty($row['image'])): ?>
                  <img src="<?= htmlspecialchars($row['image']) ?>" width="50" height="50" alt="<?= htmlspecialchars($row['name']) ?>">
                <?php else: ?>
                  <img src="https://via.placeholder.com/50x50?text=No+Img" alt="No image">
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($row['code']) ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['unit']) ?></td>
              <td>Rp <?= number_format((int)$row['price'], 0, ",", ".") ?></td>
              <td>
                <button class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editProductModal<?= (int)$row['id'] ?>">
                  <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteConfirmModal<?= (int)$row['id'] ?>">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php foreach ($products as $row): $id = (int)$row['id']; ?>
  <!-- Edit Modal (di luar tabel) -->
  <div class="modal fade" id="editProductModal<?= $id ?>" tabindex="-1"
       aria-labelledby="editProductModalLabel<?= $id ?>" aria-hidden="true"
       data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="../../controller/productController.php" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="editProductModalLabel<?= $id ?>">Edit Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="id" value="<?= $id ?>">

          <div class="image-upload-container">
            <div class="image-preview" id="editImagePreview-<?= $id ?>">
              <div class="upload-placeholder" <?= !empty($row['image']) ? 'style="display:none"' : '' ?>>
                <i class="bi bi-cloud-upload upload-icon"></i>
                <p>Unggah Gambar</p>
              </div>
              <img id="editPreviewImage-<?= $id ?>"
                   src="<?= htmlspecialchars($row['image'] ?? '') ?>"
                   data-original-src="<?= htmlspecialchars($row['image'] ?? '') ?>"
                   alt="Preview"
                   <?= !empty($row['image']) ? 'style="display:block"' : '' ?>>
            </div>
            <input type="file"
                   name="image"
                   id="editProductImage-<?= $id ?>"
                   accept="image/*"
                   class="d-none"
                   data-preview-target="editImagePreview-<?= $id ?>"
                   data-image-target="editPreviewImage-<?= $id ?>">
            <button type="button" class="btn btn-outline-primary upload-trigger"
                    data-target="editProductImage-<?= $id ?>">Pilih Gambar</button>
          </div>

          <div class="mb-3">
            <label for="editProductCode-<?= $id ?>" class="form-label">Kode Produk</label>
            <input type="text" name="code" class="form-control" id="editProductCode-<?= $id ?>"
                   required value="<?= htmlspecialchars($row['code']) ?>">
          </div>

          <div class="mb-3">
            <label for="editProductName-<?= $id ?>" class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" id="editProductName-<?= $id ?>"
                   required value="<?= htmlspecialchars($row['name']) ?>">
          </div>

          <div class="mb-3">
            <label for="editProductUnit-<?= $id ?>" class="form-label">Unit</label>
            <select name="unit" class="form-select" id="editProductUnit-<?= $id ?>" required>
              <option value="">Pilih Unit</option>
              <option value="kg"  <?= $row['unit'] === 'kg'  ? 'selected' : '' ?>>Kilogram (kg)</option>
              <option value="g"   <?= $row['unit'] === 'g'   ? 'selected' : '' ?>>Gram (g)</option>
              <option value="oz"  <?= $row['unit'] === 'oz'  ? 'selected' : '' ?>>Ons (oz)</option>
              <option value="pcs" <?= $row['unit'] === 'pcs' ? 'selected' : '' ?>>Piece (pcs)</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="editProductPrice-<?= $id ?>" class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" id="editProductPrice-<?= $id ?>"
                   required min="0" value="<?= (int)$row['price'] ?>">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="update" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Modal (di luar tabel) -->
  <div class="modal fade" id="deleteConfirmModal<?= $id ?>" tabindex="-1"
       aria-labelledby="deleteConfirmModalLabel<?= $id ?>" aria-hidden="true"
       data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel<?= $id ?>">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="confirmation-icon">
            <i class="bi bi-exclamation-triangle"></i>
          </div>
          <div class="confirmation-message">
            Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.
          </div>
        </div>
        <div class="modal-footer">
          <form method="POST" action="../../controller/productController.php">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="../../controller/productController.php" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Tambah Produk Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="image-upload-container">
          <div class="image-preview" id="imagePreview">
            <div class="upload-placeholder">
              <i class="bi bi-cloud-upload upload-icon"></i>
              <p>Unggah Gambar</p>
            </div>
            <img src="" alt="Preview" id="previewImage">
          </div>
          <input type="file" name="image" id="productImage" accept="image/*" class="d-none">
          <button type="button" class="btn btn-outline-primary" id="uploadTrigger">Pilih Gambar</button>
        </div>
        <div class="mb-3">
          <label for="productCode" class="form-label">Kode Produk</label>
          <input type="text" name="code" class="form-control" id="productCode" required>
        </div>
        <div class="mb-3">
          <label for="productName" class="form-label">Nama Produk</label>
          <input type="text" name="name" class="form-control" id="productName" required>
        </div>
        <div class="mb-3">
          <label for="productUnit" class="form-label">Unit</label>
          <select name="unit" class="form-select" id="productUnit" required>
            <option value="">Pilih Unit</option>
            <option value="kg">Kilogram (kg)</option>
            <option value="g">Gram (g)</option>
            <option value="oz">Ons (oz)</option>
            <option value="pcs">Piece (pcs)</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="productPrice" class="form-label">Harga</label>
          <input type="number" name="price" class="form-control" id="productPrice" required min="0">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" name="create" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>