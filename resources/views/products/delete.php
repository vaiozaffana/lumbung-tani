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