/* Quote form: show the extra fields that apply to the chosen category and adapt the item list hint.
 * Without JavaScript every field stays visible and the server accepts them all. */
(function () {
    'use strict';

    var form = document.querySelector('[data-quote-form]');
    if (!form) return;

    var category = form.querySelector('#category');
    var details = form.querySelector('#details');
    var conditional = form.querySelectorAll('[data-show-for]');
    var steel = 'Steel and plate';
    var toolsCategories = [];

    conditional.forEach(function (field) {
        try {
            JSON.parse(field.getAttribute('data-show-for')).forEach(function (c) {
                if (c !== steel) toolsCategories.push(c);
            });
        } catch (e) { /* ignore malformed config */ }
    });

    function update() {
        var value = category.value;

        conditional.forEach(function (field) {
            var wanted = [];
            try { wanted = JSON.parse(field.getAttribute('data-show-for')); } catch (e) {}
            var show = wanted.indexOf(value) !== -1;
            field.hidden = !show;
            // Hidden fields must not be submitted with stale values.
            field.querySelectorAll('input, select, textarea').forEach(function (el) { el.disabled = !show; });
        });

        var key = value === steel ? 'steel' : (toolsCategories.indexOf(value) !== -1 ? 'tools' : 'default');
        details.placeholder = details.getAttribute('data-placeholder-' + key) || '';

        var attachLabel = form.querySelector('label[for="attachment"]');
        var text = attachLabel && (attachLabel.getAttribute('data-label-' + key) || attachLabel.getAttribute('data-label-default'));
        if (text) attachLabel.textContent = text;
    }

    category.addEventListener('change', update);
    update();
})();
