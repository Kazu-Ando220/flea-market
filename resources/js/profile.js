document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.querySelector('.js-avatar-input');
    const fileNameDisplay = document.querySelector('.js-file-name');

    if (!avatarInput) {
        return;
    }

    avatarInput.addEventListener('change', function () {
        const file = avatarInput.files[0];

        if (!file) {
            return;
        }

        fileNameDisplay.textContent = file.name;
    });
});