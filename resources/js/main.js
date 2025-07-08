// resources/js/main.js

import 'bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../scss/styles.scss';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', () => {
    const scrollBtn = document.querySelector('.scrollup');
    if (!scrollBtn) return;

    window.addEventListener('scroll', () => {
        scrollBtn.style.display = (window.scrollY > 100) ? 'block' : 'none';
    });
});

document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => {
    new bootstrap.Tooltip(el); // bootstrap должен быть глобальным
});

// сюда можешь писать свой JS
console.log('Bootstrap + Vite подключен!');