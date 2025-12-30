import './bootstrap';

// === HERO PARALLAX Y SCROLL EFFECTS ===
document.addEventListener('DOMContentLoaded', () => {
    const heroParallax = document.querySelector('[data-parallax="hero"]');
    const heroContent = document.querySelector('[data-fade-scroll="hero"]');

    // Verificar preferencia de movimiento reducido
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!prefersReducedMotion && (heroParallax || heroContent)) {
        let ticking = false;

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const scrollY = window.scrollY;

                    // Parallax: mover fondo más lento que el scroll
                    if (heroParallax) {
                        const parallaxSpeed = 0.4;
                        heroParallax.style.transform = `translateY(${scrollY * parallaxSpeed}px)`;
                    }

                    // Fade del contenido en scroll
                    if (heroContent) {
                        const fadeStart = 100;
                        const fadeEnd = 400;

                        if (scrollY > fadeStart) {
                            const opacity = Math.max(0.3, 1 - (scrollY - fadeStart) / (fadeEnd - fadeStart));
                            heroContent.style.opacity = opacity;
                            heroContent.style.transform = `translateY(${-scrollY * 0.15}px)`;
                        } else {
                            heroContent.style.opacity = 1;
                            heroContent.style.transform = 'translateY(0)';
                        }
                    }

                    ticking = false;
                });

                ticking = true;
            }
        });
    }

    // Parallax para sección Adoración (basado en viewport)
    const adoracionParallax = document.querySelector('[data-parallax="adoracion"]');

    if (!prefersReducedMotion && adoracionParallax) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    adoracionParallax.classList.add('in-view');

                    // Efecto parallax suave basado en posición en viewport
                    const updateParallax = () => {
                        const rect = entry.target.getBoundingClientRect();
                        const viewportHeight = window.innerHeight;
                        const elementCenter = rect.top + rect.height / 2;
                        const viewportCenter = viewportHeight / 2;
                        const offset = (elementCenter - viewportCenter) * 0.1;
                        adoracionParallax.style.transform = `translateY(${offset}px)`;
                    };

                    window.addEventListener('scroll', updateParallax);
                }
            });
        }, { threshold: 0.1 });

        if (adoracionParallax.parentElement) {
            observer.observe(adoracionParallax.parentElement);
        }
    }
});

// Event listeners para conversiones de Livewire
document.addEventListener('livewire:init', () => {
    // Conversión: Registro de fiel
    Livewire.on('conversion-registro', () => {
        if (typeof window.trackConversion !== 'undefined') {
            window.trackConversion.registro();
        }
    });

    // Conversión: Suscripción newsletter
    Livewire.on('conversion-newsletter', () => {
        if (typeof window.trackConversion !== 'undefined') {
            window.trackConversion.newsletter();
        }
    });

    // Conversión: Formulario de contacto
    Livewire.on('conversion-contacto', () => {
        if (typeof window.trackConversion !== 'undefined') {
            window.trackConversion.contacto();
        }
    });
});
