document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.querySelector('.js-avatar-input');
    const fileNameDisplay = document.querySelector('.js-file-name');
    const avatarImage = document.querySelector('.avatar-image');

    if (!avatarInput || !avatarImage) return;

    avatarInput.addEventListener('change', function () {
        const file = avatarInput.files[0];
        if (!file) return;

        fileNameDisplay.textContent = file.name;

        // 画像プレビュー
        const reader = new FileReader();
        reader.onload = function (e) {
            avatarImage.src = e.target.result;
            avatarImage.classList.remove('avatar-default');
        };

        reader.readAsDataURL(file);
    });
});