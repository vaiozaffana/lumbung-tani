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