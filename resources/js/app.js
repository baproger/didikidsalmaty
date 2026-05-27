import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import focus from '@alpinejs/focus';

Alpine.plugin(intersect);
Alpine.plugin(focus);

// Navbar component
Alpine.data('navbar', () => ({
    open: false,
    scrolled: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 40;
        });
    },
}));

// Contact form component
Alpine.data('contactForm', () => ({
    loading: false,
}));

// Lightbox
Alpine.data('lightbox', () => ({
    open: false,
    current: null,
    images: [],
    openImage(src, list) {
        this.images = list;
        this.current = src;
        this.open = true;
    },
    close() { this.open = false; },
    prev() {
        const idx = this.images.indexOf(this.current);
        this.current = this.images[(idx - 1 + this.images.length) % this.images.length];
    },
    next() {
        const idx = this.images.indexOf(this.current);
        this.current = this.images[(idx + 1) % this.images.length];
    },
}));

window.Alpine = Alpine;
Alpine.start();
