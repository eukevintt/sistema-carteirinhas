import './bootstrap';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import Alpine from 'alpinejs'
Alpine.start();
window.Alpine = Alpine;

import "/node_modules/select2/dist/css/select2.css";
import 'select2-tailwindcss-v4-theme/dist/select2-tailwindcss-theme.min.css';

$(document).ready(function () {
    $('.select2').select2({
        theme: 'tailwindcss-4',
        placeholder: 'Selecione uma opção.',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function () {
                return 'Nenhum resultado encontrado.';
            }
        }
    });
});

import { DataTable } from "simple-datatables";


new DataTable("#table", {
    perPage: 10,
    perPageSelect: [5, 10, 25, 50],
    labels: {
        placeholder: "Buscar...",
        perPage: "registros por página",
        noRows: "Nenhum resultado encontrado",
        info: "Mostrando {start} a {end} de {rows} registros"
    },
    firstLast: false,
});



   

