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