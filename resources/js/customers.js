window.openEditModal = function (id, nama, kelas, departemen) {
    // Set form action URL
    document.getElementById('editForm').action = `/customers/${id}`;

    // Fill form with customer data
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_kelas').value = kelas;
    document.getElementById('edit_departemen').value = departemen;
    document.getElementById('edit_password').value = '';

    // Show modal
    document.getElementById('editModal').style.display = 'block';
}

window.closeEditModal = function () {
    document.getElementById('editModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function (event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditModal();
    }
}

// Close modal with ESC key
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeEditModal();
    }
});

window.openAddModal = function() {
    document.getElementById('addModal').style.display = 'block';
}

window.closeAddModal = function() {
    document.getElementById('addModal').style.display = 'none';
}

// Update fungsi window.onclick agar bisa menutup kedua modal
window.onclick = function(event) {
    const editModal = document.getElementById('editModal');
    const addModal = document.getElementById('addModal');
    
    if (event.target == editModal) {
        closeEditModal();
    }
    if (event.target == addModal) {
        closeAddModal();
    }
}