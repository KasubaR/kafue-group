/* Mobile navigation toggle. Closes on Escape or when a link is chosen. */
(function () {
    'use strict';

    var toggle = document.querySelector('.nav-toggle');
    var nav = document.getElementById('site-nav');
    if (!toggle || !nav) return;

    function set(open) {
        nav.classList.toggle('open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    toggle.addEventListener('click', function () {
        set(!nav.classList.contains('open'));
    });
    nav.addEventListener('click', function (e) {
        if (e.target.closest('a')) set(false);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') set(false);
    });
})();
