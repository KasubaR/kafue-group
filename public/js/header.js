/* Sticky header: adds a shadow once the page is scrolled. */
(function () {
    'use strict';

    var header = document.querySelector('.site-header');
    if (!header) return;

    function onScroll() {
        header.classList.toggle('scrolled', window.scrollY > 10);
    }
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
})();
