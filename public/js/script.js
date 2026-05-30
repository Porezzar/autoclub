(function () {
    var THEME_KEY = 'ac-theme';

    window.acGetTheme = function () {
        return document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    };

    function updateThemeToggleButtons(theme) {
        document.querySelectorAll('.ac-theme-toggle').forEach(function (btn) {
            var icon = btn.querySelector('i');
            if (!icon) {
                return;
            }

            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
                btn.title = 'Светлая тема';
            } else {
                icon.className = 'fas fa-moon';
                btn.title = 'Тёмная тема';
            }
        });
    }

    window.acSetTheme = function (theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem(THEME_KEY, theme);
        updateThemeToggleButtons(theme);
    };

    updateThemeToggleButtons(window.acGetTheme());
})();

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ac-theme-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            window.acSetTheme(window.acGetTheme() === 'dark' ? 'light' : 'dark');
        });
    });

    document.querySelectorAll('.ac-alert').forEach(function (alertEl) {
        var closeBtn = alertEl.querySelector('.ac-alert__close');
        if (!closeBtn) {
            return;
        }

        closeBtn.addEventListener('click', function () {
            if (alertEl.classList.contains('is-hiding')) {
                return;
            }

            alertEl.classList.add('is-hiding');

            var removed = false;
            var removeAlert = function () {
                if (removed) {
                    return;
                }
                removed = true;
                alertEl.remove();
            };

            alertEl.addEventListener('transitionend', function (event) {
                if (event.target === alertEl && event.propertyName === 'max-height') {
                    removeAlert();
                }
            });

            window.setTimeout(removeAlert, 450);
        });
    });

    document.querySelectorAll('form[action*="cart/add"]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (form.dataset.submitting === '1') {
                event.preventDefault();
                return;
            }

            form.dataset.submitting = '1';

            form.querySelectorAll('button[type="submit"]').forEach(function (button) {
                button.disabled = true;
            });
        });
    });

    document.querySelectorAll('.minus-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = this.parentElement.querySelector('.quantity-input');
            var val = parseInt(input.value, 10) || 1;
            if (val > 1) input.value = val - 1;
        });
    });

    document.querySelectorAll('.plus-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = this.parentElement.querySelector('.quantity-input');
            var val = parseInt(input.value, 10) || 1;
            var max = parseInt(input.getAttribute('max'), 10) || 100;
            if (val < max) input.value = val + 1;
        });
    });
});
