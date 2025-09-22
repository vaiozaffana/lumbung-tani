<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumbung Padi - Admin Panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="/resources/style/style.css">
</head>

<body>
    <?php
    require_once 'sidebar.php'
    ?>
    <!-- Main Content -->
    <main class="main-content" id="main-content">
        <!-- Dashboard Page -->
        <div class="page-content" id="dashboard-page">
            <div class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <div class="date-display">
                    <span id="current-date"></span>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card fade-in">
                    <i class="bi bi-box-seam stat-icon"></i>
                    <h3 class="stat-value">245</h3>
                    <p class="stat-label">Total Produk</p>
                </div>
                <div class="stat-card fade-in" style="animation-delay: 0.1s;">
                    <i class="bi bi-exclamation-triangle stat-icon"></i>
                    <h3 class="stat-value">12</h3>
                    <p class="stat-label">Stok Rendah</p>
                </div>
                <div class="stat-card fade-in" style="animation-delay: 0.2s;">
                    <i class="bi bi-cash-coin stat-icon"></i>
                    <h3 class="stat-value">48</h3>
                    <p class="stat-label">Transaksi Hari Ini</p>
                </div>
            </div>

            <div class="data-table-container">
                <div class="table-header">
                    <h3 class="table-title">Produk dengan Stok Rendah</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Stok Tersisa</th>
                                <th>Unit</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PRD-001</td>
                                <td>Beras Premium</td>
                                <td>5</td>
                                <td>kg</td>
                                <td><span class="badge bg-warning">Rendah</span></td>
                            </tr>
                            <tr>
                                <td>PRD-007</td>
                                <td>Beras Merah</td>
                                <td>3</td>
                                <td>kg</td>
                                <td><span class="badge bg-danger">Sangat Rendah</span></td>
                            </tr>
                            <tr>
                                <td>PRD-012</td>
                                <td>Beras Hitam</td>
                                <td>7</td>
                                <td>kg</td>
                                <td><span class="badge bg-warning">Rendah</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php
        require_once 'products-page.php'
        ?>
    </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/resources/js/script.js"></script>
</body>

</html>