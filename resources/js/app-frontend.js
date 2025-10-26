import './bootstrap';
import 'flowbite';

/**
 * Frontend Theme Switcher
 * ------------------------------------------------------------------
 */

// On page load, set the theme
function setInitialTheme() {
    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

// Update the toggle icons
function updateThemeToggleIcons() {
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');
    if (!darkIcon || !lightIcon) return;

    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
    } else {
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
    }
}

// Initialize theme toggle
function initThemeToggle() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (!themeToggleBtn) return;
    
    // Remove any existing listeners to prevent duplicates
    const newBtn = themeToggleBtn.cloneNode(true);
    themeToggleBtn.parentNode.replaceChild(newBtn, themeToggleBtn);
    
    newBtn.addEventListener('click', function () {
        // Toggle theme
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
        updateThemeToggleIcons();
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    setInitialTheme();
    updateThemeToggleIcons();
    initThemeToggle();
});

// Re-initialize Flowbite components after Livewire navigation (SPA-like page transitions)
document.addEventListener('livewire:navigated', () => {
    initFlowbite();
    updateThemeToggleIcons();
    initThemeToggle();
});

// Re-initialize Flowbite components after Livewire updates the DOM (for dynamic content)
document.addEventListener('livewire:update', () => {
    initFlowbite();
});