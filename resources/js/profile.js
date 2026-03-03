document.addEventListener('DOMContentLoaded', function () {
    console.log('Profile JS loaded');

    // Select Modal elements
    const profileModal = document.getElementById('profileModal');
    const profileViewSection = document.getElementById('profileViewSection');
    const profileEditSection = document.getElementById('profileEditSection');

    // Select buttons
    const btnToEdit = document.getElementById('switchToEditProfile');
    const btnToView = document.getElementById('switchToViewProfile');
    const closeBtns = [
        document.getElementById('closeProfileModal'),
        document.getElementById('closeProfileModalEdit')
    ];

    // Profile Trigger from Header
    const profileTriggers = document.querySelectorAll('.open-profile-modal');

    // Open Modal
    profileTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            if (profileModal) {
                profileModal.classList.remove('hidden');
                profileModal.classList.add('flex');
                // Reset to view mode whenever opened
                if (profileViewSection && profileEditSection) {
                    profileViewSection.classList.remove('hidden');
                    profileViewSection.classList.add('block');
                    profileEditSection.classList.add('hidden');
                    profileEditSection.classList.remove('block');
                }
            }
        });
    });

    // Close Modal
    closeBtns.forEach(btn => {
        if (btn) {
            btn.addEventListener('click', () => {
                if (profileModal) {
                    profileModal.classList.add('hidden');
                    profileModal.classList.remove('flex');
                }
            });
        }
    });

    // Close on click outside
    window.addEventListener('click', (event) => {
        if (profileModal && event.target === profileModal) {
            profileModal.classList.add('hidden');
            profileModal.classList.remove('flex');
        }
    });

    // Switch between view/edit modes
    if (btnToEdit && btnToView && profileViewSection && profileEditSection) {
        btnToEdit.addEventListener('click', () => {
            profileViewSection.classList.add('hidden');
            profileViewSection.classList.remove('block');
            profileEditSection.classList.remove('hidden');
            profileEditSection.classList.add('block');
        });

        btnToView.addEventListener('click', () => {
            profileEditSection.classList.add('hidden');
            profileEditSection.classList.remove('block');
            profileViewSection.classList.remove('hidden');
            profileViewSection.classList.add('block');
        });
    }

    // Avatar Image Preview for Modal
    const modalAvatarInput = document.getElementById('modalAvatarInput');
    const modalAvatarPreview = document.getElementById('modalAvatarPreview');

    if (modalAvatarInput && modalAvatarPreview) {
        modalAvatarInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    modalAvatarPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
