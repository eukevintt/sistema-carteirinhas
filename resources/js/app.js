import './bootstrap';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import Alpine from 'alpinejs'
Alpine.start();
window.Alpine = Alpine;

import "/node_modules/select2/dist/css/select2.css";
import 'select2-tailwindcss-v4-theme/dist/select2-tailwindcss-theme.min.css';

$(document).ready(function () {
    console.log('Select2 ready?', typeof $.fn.select2); // debug
    $('.select2').select2({
        theme: 'tailwindcss-4',
        placeholder: 'Selecione um associado',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function () {
                return 'Nenhum resultado encontrado.';
            }
        }
    });
});

