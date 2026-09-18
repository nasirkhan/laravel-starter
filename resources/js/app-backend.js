import 'flowbite';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

window.TomSelect = TomSelect;

// ─── Dark mode (Flowbite class-based) ───────────────────────────────────────

const THEME_KEY = 'color-theme';

function setInitialTheme() {
    if (
        localStorage.getItem(THEME_KEY) === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

function updateThemeToggleIcons() {
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');
    if (!darkIcon || !lightIcon) return;

    if (
        localStorage.getItem(THEME_KEY) === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
    } else {
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
    }
}

function initThemeToggle() {
    const btn = document.getElementById('theme-toggle');
    if (!btn) return;
    const newBtn = btn.cloneNode(true);
    btn.parentNode.replaceChild(newBtn, btn);
    newBtn.addEventListener('click', () => {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem(THEME_KEY, 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem(THEME_KEY, 'dark');
        }
        updateThemeToggleIcons();
    });
}

setInitialTheme();

// ─── Tom Select auto-init ────────────────────────────────────────────────────

function initTomSelects() {
    document.querySelectorAll('[data-tom-select]').forEach(el => {
        if (!el.tomselect) {
            new TomSelect(el, { plugins: ['remove_button'] });
        }
    });
}

// ─── data-method link handler (replaces laravel.js jQuery version) ───────────

function initMethodLinks() {
    document.querySelectorAll('a[data-method]').forEach(link => {
        link.addEventListener('click', e => {
            const method = (link.dataset.method || '').toUpperCase();
            if (!['PUT', 'DELETE', 'PATCH'].includes(method)) return;

            if (link.dataset.confirm && !confirm(link.dataset.confirm)) {
                e.preventDefault();
                return;
            }

            e.preventDefault();
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = link.getAttribute('href');

            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = link.dataset.token || document.querySelector('meta[name="csrf-token"]')?.content || '';

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = method;

            form.append(token, methodInput);
            document.body.append(form);
            form.submit();
        });
    });
}

// ─── Live clock ──────────────────────────────────────────────────────────────

function showTime() {
    const el = document.getElementById('liveClock');
    if (!el) return;

    const date = new Date();
    const locale = document.documentElement.lang || undefined;
    let hours = date.getHours();
    const session = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12 || 12;
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    el.textContent = `${hours.toLocaleString(locale)}:${minutes}:${seconds} ${session}`;
    setTimeout(showTime, 1000);
}

// ─── Name → slug converter ────────────────────────────────────────────────────

function initSlugConverter() {
    const nameEl = document.getElementById('name');
    const slugEl = document.getElementById('slug');
    if (!nameEl || !slugEl) return;

    nameEl.addEventListener('keyup', () => {
        slugEl.value = nameEl.value
            .toLowerCase()
            .replace(/[~`{}.'"!@#$%^&*()_=+/?><,[\]:;|\\]/g, '')
            .replace(/\s+/g, '-');
    });
}

// ─── Boot ────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
    setInitialTheme();
    updateThemeToggleIcons();
    initThemeToggle();
    initTomSelects();
    initMethodLinks();
    showTime();
    initSlugConverter();
});

document.addEventListener('livewire:navigated', () => {
    setInitialTheme();
    initFlowbite();
    updateThemeToggleIcons();
    initThemeToggle();
    initTomSelects();
    initMethodLinks();
});

document.addEventListener('livewire:update', () => {
    initFlowbite();
});
