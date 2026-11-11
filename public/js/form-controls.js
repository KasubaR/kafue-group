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

    /* ------------------------------ Calendar ------------------------------ */
    var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var DAYS = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    function pad(n) { return (n < 10 ? '0' : '') + n; }
    function toISO(d) { return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()); }
    function fromISO(s) {
        var m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(s || '');
        return m ? new Date(+m[1], +m[2] - 1, +m[3]) : null;
    }
    function addDays(d, n) { return new Date(d.getFullYear(), d.getMonth(), d.getDate() + n); }
    function sameDay(a, b) { return !!a && !!b && toISO(a) === toISO(b); }
    function human(d) { return d.getDate() + ' ' + MONTHS[d.getMonth()] + ' ' + d.getFullYear(); }

    function enhanceDate(input) {
        if (input.dataset.enhanced) return;
        input.dataset.enhanced = '1';

        var id = input.id || 'date-' + (++uid);
        var today = fromISO(toISO(new Date()));
        var min = fromISO(input.getAttribute('min')) || today;
        if (!input.getAttribute('min')) input.setAttribute('min', toISO(min));

        var wrap = document.createElement('div');
        wrap.className = 'datepicker';
        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);
        input.tabIndex = -1;
        input.setAttribute('aria-hidden', 'true');

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'date-btn';
        btn.setAttribute('aria-haspopup', 'dialog');
        btn.setAttribute('aria-expanded', 'false');
        var label = document.querySelector('label[for="' + id + '"]');
        if (label) {
            label.id = label.id || id + '-label';
            btn.id = id + '-btn';
            btn.setAttribute('aria-labelledby', label.id + ' ' + btn.id);
        }

        var pop = document.createElement('div');
        pop.className = 'cal';
        pop.setAttribute('role', 'dialog');
        pop.setAttribute('aria-label', 'Choose a date');
        pop.hidden = true;

        var head = document.createElement('div');
        head.className = 'cal-head';
        var prev = document.createElement('button');
        prev.type = 'button'; prev.className = 'cal-nav'; prev.setAttribute('aria-label', 'Previous month');
        prev.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m14.5 6-6 6 6 6"/></svg>';
        var next = document.createElement('button');
        next.type = 'button'; next.className = 'cal-nav'; next.setAttribute('aria-label', 'Next month');
        next.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9.5 6 6 6-6 6"/></svg>';
        var title = document.createElement('div');
        title.className = 'cal-title';
        title.setAttribute('aria-live', 'polite');
        head.appendChild(prev); head.appendChild(title); head.appendChild(next);

        var grid = document.createElement('div');
        grid.className = 'cal-grid';
        grid.setAttribute('role', 'grid');

        var foot = document.createElement('div');
        foot.className = 'cal-foot';
        var clearBtn = document.createElement('button');
        clearBtn.type = 'button'; clearBtn.textContent = 'Clear';
        var todayBtn = document.createElement('button');
        todayBtn.type = 'button'; todayBtn.textContent = 'Today';
        foot.appendChild(clearBtn); foot.appendChild(todayBtn);

        pop.appendChild(head); pop.appendChild(grid); pop.appendChild(foot);
        wrap.appendChild(btn);
        wrap.appendChild(pop);

        var focusDate = null;

        function selected() { return fromISO(input.value); }
        function isOpen() { return !pop.hidden; }
        function clamp(d) { return d < min ? min : d; }

        function sync() {
            var d = selected();
            btn.textContent = d ? human(d) : 'Select a date';
            btn.classList.toggle('empty', !d);
        }

        function render(moveFocus) {
            var sel = selected();
            var first = new Date(focusDate.getFullYear(), focusDate.getMonth(), 1);
            title.textContent = MONTHS[first.getMonth()] + ' ' + first.getFullYear();
            prev.disabled = addDays(first, -1) < min;

            grid.textContent = '';
            DAYS.forEach(function (n) {
                var h = document.createElement('div');
                h.className = 'cal-dow'; h.textContent = n; h.setAttribute('role', 'columnheader');
                grid.appendChild(h);
            });

            var lead = (first.getDay() + 6) % 7; // Monday first
            for (var i = 0; i < lead; i++) grid.appendChild(document.createElement('span'));

            var count = new Date(first.getFullYear(), first.getMonth() + 1, 0).getDate();
            for (var day = 1; day <= count; day++) {
                var d = new Date(first.getFullYear(), first.getMonth(), day);
                var b = document.createElement('button');
                b.type = 'button';
                b.className = 'cal-day';
                b.textContent = day;
                b.dataset.date = toISO(d);
                b.setAttribute('role', 'gridcell');
                b.setAttribute('aria-label', human(d));
                b.tabIndex = sameDay(d, focusDate) ? 0 : -1;
                if (d < min) b.disabled = true;
                if (sameDay(d, today)) b.classList.add('today');
                if (sameDay(d, sel)) { b.classList.add('selected'); b.setAttribute('aria-selected', 'true'); }
                grid.appendChild(b);
            }
            todayBtn.disabled = today < min;
            if (moveFocus) {
                var el = grid.querySelector('[tabindex="0"]');
                if (el) el.focus();
            }
        }

        function open() {
            if (isOpen()) return;
            focusDate = clamp(selected() || min);
            var rect = btn.getBoundingClientRect();
            var below = window.innerHeight - rect.bottom;
            wrap.classList.toggle('up', below < 380 && rect.top > below);
            pop.hidden = false;
            btn.setAttribute('aria-expanded', 'true');
            render(true);
        }

        function close(refocus) {
            if (!isOpen()) return;
            pop.hidden = true;
            btn.setAttribute('aria-expanded', 'false');
            if (refocus) btn.focus();
        }

        function choose(d) {
            input.value = d ? toISO(d) : '';
            input.dispatchEvent(new Event('change', { bubbles: true }));
            sync();
            close(true);
        }

        function move(d) {
            focusDate = clamp(d);
            render(true);
        }

        btn.addEventListener('click', function () { isOpen() ? close(false) : open(); });
        btn.addEventListener('keydown', function (e) {
            if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && !isOpen()) { e.preventDefault(); open(); }
        });

        prev.addEventListener('click', function () {
            move(new Date(focusDate.getFullYear(), focusDate.getMonth() - 1, 1));
        });
        next.addEventListener('click', function () {
            move(new Date(focusDate.getFullYear(), focusDate.getMonth() + 1, 1));
        });
        todayBtn.addEventListener('click', function () { choose(today); });
        clearBtn.addEventListener('click', function () { choose(null); });

        grid.addEventListener('click', function (e) {
            var b = e.target.closest('.cal-day');
            if (b && !b.disabled) choose(fromISO(b.dataset.date));
        });

        pop.addEventListener('keydown', function (e) {
            var k = e.key;
            if (k === 'Escape') { e.preventDefault(); close(true); return; }
            if (k === 'Tab') { close(false); return; }
            if (!e.target.classList.contains('cal-day')) return;
            var d = fromISO(e.target.dataset.date), n = null;
            if (k === 'ArrowLeft') n = addDays(d, -1);
            else if (k === 'ArrowRight') n = addDays(d, 1);
            else if (k === 'ArrowUp') n = addDays(d, -7);
            else if (k === 'ArrowDown') n = addDays(d, 7);
            else if (k === 'Home') n = addDays(d, -((d.getDay() + 6) % 7));
            else if (k === 'End') n = addDays(d, 6 - ((d.getDay() + 6) % 7));
            else if (k === 'PageUp') n = new Date(d.getFullYear(), d.getMonth() - 1, d.getDate());
            else if (k === 'PageDown') n = new Date(d.getFullYear(), d.getMonth() + 1, d.getDate());
            if (n) { e.preventDefault(); move(n); }
        });

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) close(false);
        });

        // Clicking the <label> lands on the custom button.
        input.addEventListener('focus', function () { btn.focus(); });
        input.addEventListener('change', sync);
        if (input.form) input.form.addEventListener('reset', function () { setTimeout(sync, 0); });

        sync();
    }

    document.querySelectorAll('.field select').forEach(enhanceSelect);
    document.querySelectorAll('.field input[type="date"]').forEach(enhanceDate);
    document.querySelectorAll('[data-dropzone]').forEach(enhanceDropzone);
})();
