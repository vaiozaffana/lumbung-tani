 <?php require_once __DIR__ . '/../../config/db.php' ?>

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
                         <th data-sort="code">Kode</th>
                         <th data-sort="name">Nama Produk</th>
                         <th data-sort="unit">Unit</th>
                         <th data-sort="price">Harga</th>
                         <th>Gambar</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
                        while ($row = $result->fetch_assoc()):
                        ?>
                         <tr>
                             <td><?= $row['code'] ?></td>
                             <td><?= $row['name'] ?></td>
                             <td><?= $row['unit'] ?></td>
                             <td>Rp <?= number_format($row['price'], 0, ",", ".") ?></td>
                             <td>
                                 <?php if ($row['image']): ?>
                                     <img src="<?= $row['image'] ?>" width="50" height="50">
                                 <?php else: ?>
                                     <img src="https://via.placeholder.com/50x50?text=No+Img">
                                 <?php endif; ?>
                             </td>
                             <td>
                                 <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                     data-bs-target="#editProductModal<?= $row['id'] ?>">
                                     <i class="bi bi-pencil"></i>
                                 </button>

                                 <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                     data-bs-target="#deleteConfirmModal<?= $row['id'] ?>">
                                     <i class="bi bi-trash"></i>
                                 </button>
                             </td>
                         </tr>

                         <div class="modal fade" id="editProductModal<?= $row['id'] ?>" tabindex="-1">
                             <div class="modal-dialog">
                                 <form class="modal-content" method="POST" action="../backend/actions/update.php" enctype="multipart/form-data">
                                     <div class="modal-header">
                                         <h5 class="modal-title">Edit Produk</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                     </div>
                                     <div class="modal-body">
                                         <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                         <div class="mb-3">
                                             <label>Kode Produk</label>
                                             <input type="text" name="code" class="form-control" value="<?= $row['code'] ?>" required>
                                             <div class="mb-3">
                                                 <label>Nama Produk</label>
                                                 <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
                                             </div>
                                             <div class="mb-3">
                                                 <label>Unit</label>
                                                 <select name="unit" class="form-select" required>
                                                     <option value="kg" <?= $row['unit'] == "kg" ? "selected" : "" ?>>Kilogram</option>
                                                     <option value="g" <?= $row['unit'] == "g" ? "selected" : "" ?>>Gram</option>
                                                     <option value="oz" <?= $row['unit'] == "oz" ? "selected" : "" ?>>Ons</option>
                                                     <option value="pcs" <?= $row['unit'] == "pcs" ? "selected" : "" ?>>Piece</option>
                                                 </select>
                                             </div>
                                             <div class="mb-3">
                                                 <label>Harga</label>
                                                 <input type="number" name="price" class="form-control" value="<?= $row['price'] ?>" required>
                                             </div>
                                             <div class="mb-3">
                                                 <label>Gambar (opsional)</label>
                                                 <input type="file" name="image" class="form-control">
                                             </div>
                                         </div>
                                         <div class="modal-footer">
                                             <button type="submit" name="update" class="btn btn-primary">Perbarui</button>
                                         </div>
                                 </form>
                             </div>
                         </div>

                         <div class="modal fade" id="deleteConfirmModal<?= $row['id'] ?>" tabindex="-1">
                             <div class="modal-dialog">
                                 <form class="modal-content" method="POST" action="../backend/actions/delete.php">
                                     <div class="modal-header">
                                         <h5 class="modal-title">Konfirmasi Hapus</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                     </div>
                                     <div class="modal-body">
                                         Apakah yakin ingin menghapus <b><?= $row['name'] ?></b>?
                                     </div>
                                     <div class="modal-footer">
                                         <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                         <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                                     </div>
                                 </form>
                             </div>
                         </div>

                     <?php endwhile; ?>
                 </tbody>
             </table>
         </div>
         <div class="pagination-container">
             <div class="pagination-info">
                 Menampilkan 1-3 dari 10 produk
             </div>
             <nav>
                 <ul class="pagination">
                     <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                     <li class="page-item active"><a class="page-link" href="#">1</a></li>
                     <li class="page-item"><a class="page-link" href="#">2</a></li>
                     <li class="page-item"><a class="page-link" href="#">3</a></li>
                     <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                 </ul>
             </nav>
         </div>
     </div>
 </div>

 <!-- Other pages would be implemented similarly -->
<div class="page-content d-none" id="stock-page">
    <div class="page-header">
        <h1 class="page-title">Kelola Stok</h1>
    </div>
    <p>Halaman kelola stok dalam pengembangan...</p>
</div>

<div class="page-content d-none" id="transactions-page">
    <div class="page-header">
        <h1 class="page-title">Transaksi</h1>
    </div>
    <p>Halaman transaksi dalam pengembangan...</p>
</div>

<div class="page-content d-none" id="reports-page">
    <div class="page-header">
        <h1 class="page-title">Laporan</h1>
    </div>
    <p>Halaman laporan dalam pengembangan...</p>
</div>

<div class="page-content d-none" id="users-page">
    <div class="page-header">
        <h1 class="page-title">Pengguna</h1>
    </div>
    <p>Halaman pengguna dalam pengembangan...</p>
</div>

<div class="page-content d-none" id="settings-page">
    <div class="page-header">
        <h1 class="page-title">Pengaturan</h1>
    </div>
    <p>Halaman pengaturan dalam pengembangan...</p>
</div>

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

 <!-- Edit Product Modal -->
 <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form id="editProductForm">
                     <div class="image-upload-container">
                         <div class="image-preview" id="editImagePreview">
                             <img src="https://via.placeholder.com/150x150?text=Beras" alt="Preview" id="editPreviewImage">
                         </div>
                         <input type="file" id="editProductImage" accept="image/*" class="d-none">
                         <button type="button" class="btn btn-outline-primary" id="editUploadTrigger">Ubah Gambar</button>
                     </div>
                     <div class="mb-3">
                         <label for="editProductCode" class="form-label">Kode Produk</label>
                         <input type="text" class="form-control" id="editProductCode" readonly>
                     </div>
                     <div class="mb-3">
                         <label for="editProductName" class="form-label">Nama Produk</label>
                         <input type="text" class="form-control" id="editProductName" required>
                     </div>
                     <div class="mb-3">
                         <label for="editProductUnit" class="form-label">Unit</label>
                         <select class="form-select" id="editProductUnit" required>
                             <option value="">Pilih Unit</option>
                             <option value="kg">Kilogram (kg)</option>
                             <option value="g">Gram (g)</option>
                             <option value="oz">Ons (oz)</option>
                             <option value="pcs">Piece (pcs)</option>
                         </select>
                     </div>
                     <div class="mb-3">
                         <label for="editProductPrice" class="form-label">Harga</label>
                         <input type="number" class="form-control" id="editProductPrice" required min="0">
                     </div>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                 <button type="button" class="btn btn-primary" id="updateProduct">Perbarui</button>
             </div>
         </div>
     </div>
 </div>

 <!-- Delete Confirmation Modal -->
 <div class="modal fade" id="deleteConfirmModal<?= $row = ['id'] ?>" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
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
                 <input type="hidden" name="id" value="<?= $row['id'] ?>">
                 <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                 <button type="button" name="delete" class="btn btn-danger" id="confirmDelete">Hapus</button>
             </div>
         </div>
     </div>
 </div>
 </div>