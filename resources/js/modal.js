document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('loginModal');

    if (!modal) return;

    window.showLoginModal = function () {
        modal.style.display = 'block';
    };

    window.closeLoginModal = function () {
        modal.style.display = 'none';
    };

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    const loginTriggers = document.querySelectorAll('.js-login-trigger');
    loginTriggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            showLoginModal();
        });
    });
});