import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* Custom scrollbar (outside Tailwind scope) */
.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background-color: #b8b8b8;
    border-radius: 6px;
}
.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}
