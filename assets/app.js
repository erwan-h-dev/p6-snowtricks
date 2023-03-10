/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import 'select2/dist/css/select2.css';
import '@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.css';

// start the Stimulus application
import './bootstrap';
import $ from 'jquery';
import 'select2';
import Swal from 'sweetalert2';
// import tinymce from 'tinymce';

$(function() {

    tinymce.init({
        selector: '#trick_content',
        menubar: false,
        add_form_submit_trigger : true
    });

    $('.select2').select2({
        theme: 'bootstrap4'
    });

    $('.delete').on('click', function(e) {
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Vous ne pourrez pas revenir en arrière !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'Oui, Supprimez-le!'
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Supprimé !',
                    text: 'Vous allez être rediriger vers la liste des tricks.',
                    icon: 'success',
                    confirmButtonText: 'Confirmer'
                }).then((result) => {
                    $(".delete-form").submit();
                });
                
            }
        })
    });
});