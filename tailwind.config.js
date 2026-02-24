import forms from '@tailwindcss/forms';
import defaultTheme from 'tailwindcss/defaultTheme'; // 👈 esto faltaba

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    primary: '#fbbf24',    // Amber 400 - Dorado vibrante (nuevo color principal)
                    secondary: '#a855f7',  // Purple 500 - Mantiene contraste con el dorado
                    accent: '#f43f5e',     // Rose 500 - Acentos de énfasis
                    success: '#10b981',    // Emerald 500 - Mensajes de éxito
                    warning: '#fb923c',    // Orange 400 - Advertencias (cambiado de amarillo a naranja)
                    danger: '#ef4444',     // Red 500 - Errores y acciones destructivas
                    info: '#3b82f6',       // Blue 500 - Información
                },
                surface: {
                    main: '#020617',       // Slate 950 - Fondo principal
                    card: '#0f172a',       // Slate 900 - Tarjetas y paneles
                    border: '#1e293b',     // Slate 800 - Bordes
                    muted: '#64748b',      // Slate 500 - Texto secundario
                }
            }
        },
    },

    plugins: [forms],
};
