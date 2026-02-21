<form id="userEditForm" action="/admin/users/{{ $user->id }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="fas fa-user me-1"></i>Name <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1"></i>Email <span class="text-danger">*</span>
                </label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="phone" class="form-label">
                    <i class="fas fa-phone me-1"></i>Phone
                </label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="organization" class="form-label">
                    <i class="fas fa-building me-1"></i>Organization
                </label>
                <input type="text" class="form-control" id="organization" name="organization" value="{{ $user->organization }}">
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="role_id" class="form-label">
            <i class="fas fa-user-tag me-1"></i>Role <span class="text-danger">*</span>
        </label>
        <select class="form-select" id="role_id" name="role_id" required>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>
    
    <hr class="my-4">
    
    <h6 class="mb-3">
        <i class="fas fa-lock me-1"></i>Change Password (Optional)
    </h6>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" 
                       placeholder="Leave blank to keep current password">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                       placeholder="Confirm new password">
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Update User
        </button>
    </div>
</form>

<script>
document.getElementById('userEditForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Updating...';
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal and refresh page
            const modal = bootstrap.Modal.getInstance(document.getElementById('userEditModal'));
            modal.hide();
            
            // Show success message
            showAlert('success', data.message);
            
            // Refresh the page to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showAlert('danger', data.message || 'An error occurred while updating the user.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'An error occurred while updating the user.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Try to find an existing alert container or create one
    let alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) {
        alertContainer = document.createElement('div');
        alertContainer.className = 'alert-container position-fixed top-0 start-50 translate-middle-x';
        alertContainer.style.zIndex = '9999';
        alertContainer.style.marginTop = '20px';
        document.body.appendChild(alertContainer);
    }
    
    alertContainer.innerHTML = alertHtml;
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}
</script> 