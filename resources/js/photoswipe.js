import PhotoSwipeLightbox from 'photoswipe/lightbox';
import 'photoswipe/style.css';

export function initPhotoSwipe() {
    document.querySelectorAll('.pswp-gallery').forEach(gallery => {
        const lightbox = new PhotoSwipeLightbox({
            gallery,
            children: 'a',
            pswpModule: () => import('photoswipe'),
        });

        // Resolve dimensions at open time when not provided as data attributes
        lightbox.on('contentLoad', e => {
            const { content } = e;
            if (content.type !== 'image' || content.data.w) return;

            e.preventDefault();
            const img = new Image();
            img.onload = () => {
                content.data.w = img.naturalWidth;
                content.data.h = img.naturalHeight;
                content.displayImage();
            };
            img.src = content.data.src;
        });

        lightbox.init();
    });
}
