<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form untuk mengganti password -->
          <form action="{{ route('updatePassword', $data->uuid) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="Enter current password" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="Enter new password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" placeholder="Confirm new password" required>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updatePasswordBtn">Save Changes</button>
            </div>
        </form>
        
        <script>
            // Validasi form sebelum disubmit
            document.getElementById("updatePasswordBtn").addEventListener("click", function () {
                var newPassword = document.getElementById("newPassword").value;
                var confirmPassword = document.getElementById("confirmPassword").value;
        
                if (newPassword !== confirmPassword) {
                    alert("Kata sandi baru dan kata sandi konfirmasi tidak cocok.");
                    event.preventDefault(); // Mencegah form disubmit jika password tidak sesuai
                }
            });
        </script>
        
        </div>
      </div>
    </div>
  </div>