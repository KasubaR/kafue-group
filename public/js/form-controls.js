/* Custom form controls: a styled dropdown and a file drop zone.
 * Both sit on top of the real <select> / <input type="file">, so forms still submit normally,
 * and without JavaScript the browser's own controls are used. */
(function () {
    'use strict';

    /* ------------------------------ Dropdown ------------------------------ */
    var uid = 0;

    function enhanceSelect(sel) {
        if (sel.dataset.enhanced || sel.multiple) return;
        sel.dataset.enhanced = '1';

        var id = sel.id || 'select-' + (++uid);
        var wrap = document.createElement('div');
        wrap.className = 'select';
        sel.parentNode.insertBefore(wrap, sel);
        wrap.appendChild(sel);
        sel.tabIndex = -1;
        sel.setAttribute('aria-hidden', 'true');

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'select-btn';
        btn.id = id + '-btn';
        btn.setAttribute('role', 'combobox');
        btn.setAttribute('aria-haspopup', 'listbox');
        btn.setAttribute('aria-expanded', 'false');
        btn.setAttribute('aria-controls', id + '-list');

        var label = document.querySelector('label[for="' + id + '"]');
        if (label) {
            label.id = label.id || id + '-label';
            btn.setAttribute('aria-labelledby', label.id + ' ' + btn.id);
        }

        var list = document.createElement('ul');
        list.className = 'select-list';
        list.id = id + '-list';
        list.setAttribute('role', 'listbox');
        list.hidden = true;

        var items = [];
        Array.prototype.forEach.call(sel.options, function (opt, i) {
            var li = document.createElement('li');
            li.className = 'select-opt';
            li.id = id + '-opt-' + i;
            li.setAttribute('role', 'option');
            li.textContent = opt.text;
            li.addEventListener('mousedown', function (e) { e.preventDefault(); }); // keep focus on the button
            li.addEventListener('click', function () { choose(i); });
            li.addEventListener('mousemove', function () { setActive(i); });
            list.appendChild(li);
            items.push(li);
        });

        wrap.appendChild(btn);
        wrap.appendChild(list);

        var active = sel.selectedIndex;
        var typed = '';
        var typedTimer;

        function isOpen() { return !list.hidden; }

        function sync() {
            btn.textContent = sel.options[sel.selectedIndex] ? sel.options[sel.selectedIndex].text : '';
            items.forEach(function (li, i) {
                li.setAttribute('aria-selected', i === sel.selectedIndex ? 'true' : 'false');
            });
        }

        function setActive(i) {
            active = Math.max(0, Math.min(items.length - 1, i));
            items.forEach(function (li, n) { li.classList.toggle('active', n === active); });
            btn.setAttribute('aria-activedescendant', items[active].id);
            var el = items[active];
            if (el.offsetTop < list.scrollTop) list.scrollTop = el.offsetTop;
            else if (el.offsetTop + el.offsetHeight > list.scrollTop + list.clientHeight) list.scrollTop = el.offsetTop + el.offsetHeight - list.clientHeight;
        }

        function open() {
            if (isOpen()) return;
            var rect = btn.getBoundingClientRect();
            var below = window.innerHeight - rect.bottom;
            wrap.classList.toggle('up', below < 300 && rect.top > below);
            list.hidden = false;
            btn.setAttribute('aria-expanded', 'true');
            setActive(sel.selectedIndex);
        }

        function close() {
            if (!isOpen()) return;
            list.hidden = true;
            btn.setAttribute('aria-expanded', 'false');
            btn.removeAttribute('aria-activedescendant');
        }

        function choose(i) {
            if (sel.selectedIndex !== i) {
                sel.selectedIndex = i;
                sel.dispatchEvent(new Event('change', { bubbles: true }));
            }
            sync();
            close();
            btn.focus();
        }

        btn.addEventListener('click', function () { isOpen() ? close() : open(); });

        btn.addEventListener('keydown', function (e) {
            var k = e.key;
            if (k === 'ArrowDown' || k === 'ArrowUp') {
                e.preventDefault();
                if (!isOpen()) { open(); return; }
                setActive(active + (k === 'ArrowDown' ? 1 : -1));
            } else if (k === 'Home' || k === 'End') {
                if (isOpen()) { e.preventDefault(); setActive(k === 'Home' ? 0 : items.length - 1); }
            } else if (k === 'Enter' || k === ' ') {
                e.preventDefault();
                isOpen() ? choose(active) : open();
            } else if (k === 'Escape') {
                if (isOpen()) { e.preventDefault(); close(); }
            } else if (k === 'Tab') {
                close();
            } else if (k.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
                // type-ahead
                typed += k.toLowerCase();
                clearTimeout(typedTimer);
                typedTimer = setTimeout(function () { typed = ''; }, 600);
                var start = isOpen() ? active : sel.selectedIndex;
                for (var n = 1; n <= items.length; n++) {
                    var idx = (start + n) % items.length;
                    if (items[idx].textContent.toLowerCase().indexOf(typed) === 0) {
                        isOpen() ? setActive(idx) : choose(idx);
                        break;
                    }
                }
            }
        });

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) close();
        });

        // Clicking the <label> (or anything that focuses the hidden select) lands on the custom button.
        sel.addEventListener('focus', function () { btn.focus(); });
        sel.addEventListener('change', sync);
        if (sel.form) sel.form.addEventListener('reset', function () { setTimeout(sync, 0); });

        sync();
    }

    /* ----------------------------- File drop zone ----------------------------- */
    function formatSize(bytes) {
        if (bytes < 1024 * 1024) return Math.max(1, Math.round(bytes / 1024)) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function enhanceDropzone(zone) {
        var input = zone.querySelector('input[type="file"]');
        var fileEl = zone.querySelector('.dz-file');
        var clear = zone.querySelector('.dz-clear');
        if (!input || !fileEl || !clear) return;

        var maxKb = parseInt(input.getAttribute('data-max-kb'), 10) || 0;
        var allowed = (input.getAttribute('accept') || '').split(',')
            .map(function (s) { return s.trim().replace(/^\./, '').toLowerCase(); })
            .filter(Boolean);

        var error = document.createElement('div');
        error.className = 'error dz-error';
        error.setAttribute('role', 'alert');
        error.hidden = true;
        zone.parentNode.insertBefore(error, zone.nextSibling);

        function fail(message) {
            input.value = '';
            error.textContent = message;
            error.hidden = false;
        }

        function update() {
            error.hidden = true;
            var file = input.files && input.files[0];

            if (file) {
                var ext = (file.name.split('.').pop() || '').toLowerCase();
                if (allowed.length && allowed.indexOf(ext) === -1) {
                    fail('That file type is not supported. Use ' + allowed.join(', ').toUpperCase() + '.');
                    file = null;
                } else if (maxKb && file.size > maxKb * 1024) {
                    fail('That file is too large. Keep it under ' + Math.round(maxKb / 1024) + ' MB or email it to us.');
                    file = null;
                }
            }

            zone.classList.toggle('has-file', !!file);
            clear.hidden = !file;
            fileEl.hidden = !file;
            fileEl.textContent = '';
            if (file) {
                var name = document.createElement('span');
                name.className = 'dz-name';
                name.textContent = file.name;
                fileEl.appendChild(name);
                var size = document.createElement('small');
                size.textContent = formatSize(file.size);
                fileEl.appendChild(size);
            }
        }

        input.addEventListener('change', update);
        clear.addEventListener('click', function () {
            input.value = '';
            update();
            input.focus();
        });

        ['dragenter', 'dragover'].forEach(function (t) {
            zone.addEventListener(t, function () { zone.classList.add('is-dragover'); });
        });
        ['dragleave', 'drop', 'dragend'].forEach(function (t) {
            zone.addEventListener(t, function () { zone.classList.remove('is-dragover'); });
        });

        update();
    }

    document.querySelectorAll('.field select').forEach(enhanceSelect);
    document.querySelectorAll('[data-dropzone]').forEach(enhanceDropzone);
})();
