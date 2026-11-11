/* Scroll reveal: fades elements in as they enter the viewport.
 * Add data-reveal to any element on a new page to opt in. */
(function () {
    'use strict';

    var SELECTOR = [
        '[data-reveal]',
        '.section-head', '.section h2', '.card', '.stage', '.step',
        '.info-card', '.spec-table-wrap', '.chips', '.callout', '.pullquote', '.detail-list', '.panel', '.split .prose',
        '.why-card', '.cta', '.form-card',
        '.contact .container > div'
    ].join(', ');

    var targets = document.querySelectorAll(SELECTOR);
    targets.forEach(function (el, i) {
        el.classList.add('reveal');
        el.style.setProperty('--d', (i % 4) * 80 + 'ms');
    });

    if (!('IntersectionObserver' in window)) {
        targets.forEach(function (el) { el.classList.add('in'); });
        return;
    }

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('in');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    targets.forEach(function (el) { io.observe(el); });
})();
