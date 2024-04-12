import * as coreui from '@coreui/coreui';
import "/node_modules/simplebar/dist/simplebar.min.js";
import "/resources/js/laravel.js";
import "/resources/js/backend-custom.js";

window.coreui = coreui;

// Enable tooltips everywhere
const tooltipTriggerList = document.querySelectorAll('[data-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new coreui.Tooltip(tooltipTriggerEl))

const header = document.querySelector('header.header');

document.addEventListener('scroll', () => {
    if (header) {
        header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
    }
});

// live clock 
$(function () {
    showTime();
});

function showTime() {
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();

    var session = hours >= 12 ? 'pm' : 'am';

    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    var locale = document.getElementsByTagName("html")[0].getAttribute("lang");
    var time = hours.toLocaleString(locale) + ":" + minutes.toLocaleString(locale) + ":" + seconds.toLocaleString(locale) + " " + session.toLocaleString(locale);
    document.getElementById("liveClock").innerText = time;
    document.getElementById("liveClock").textContent = time;

    setTimeout(showTime, 1000);
}

/**
 * Convert name string to slug
 */
$(function () {
    $("#name").on("keyup", function () {
        convertToSlug('#name', '#slug');
    });
});

function convertToSlug(source, destination) {
    var text = $(source).val();
    $(destination).val(text.toLowerCase().replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "").replace(/ /g, '-'));
}

/*!
 * Color mode toggler for CoreUI's docs (https://coreui.io/)
 * Copyright (c) 2024 creativeLabs Łukasz Holeczek
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */

(() => {
    'use strict'

    const THEME = 'color-theme'

    const getStoredTheme = () => localStorage.getItem(THEME)
    const setStoredTheme = theme => localStorage.setItem(THEME, theme)

    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme()
        if (storedTheme) {
            return storedTheme
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    }

    const setTheme = theme => {
        if (theme === 'auto') {
            document.documentElement.setAttribute('data-coreui-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
            document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
        } else {
            document.documentElement.setAttribute('data-coreui-theme', theme)
            document.documentElement.setAttribute('data-bs-theme', theme)
        }
    }

    setTheme(getPreferredTheme())

    const showActiveTheme = theme => {
        const activeThemeIcon = document.querySelector('.theme-icon-active')
        const btnToActive = document.querySelector(`[data-coreui-theme-value="${theme}"]`)
        const svgOfActiveBtn = btnToActive.querySelector('svg.theme-icon')

        document.querySelectorAll('[data-coreui-theme-value]').forEach(element => {
            element.classList.remove('active')
        })

        btnToActive.classList.add('active')
        activeThemeIcon.innerHTML = svgOfActiveBtn.innerHTML
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const storedTheme = getStoredTheme()
        if (storedTheme !== 'light' && storedTheme !== 'dark') {
            setTheme(getPreferredTheme())
        }
    })

    window.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme())

        document.querySelectorAll('[data-coreui-theme-value]')
            .forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const theme = toggle.getAttribute('data-coreui-theme-value')
                    setStoredTheme(theme)
                    setTheme(theme)
                    showActiveTheme(theme)
                })
            })
    })
})()