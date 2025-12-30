import './bootstrap';

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
