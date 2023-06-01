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
import 'owl.carousel/dist/assets/owl.carousel.css';

// start the Stimulus application
// import './bootstrap';
import $ from 'jquery';
import 'select2';
import Swal from 'sweetalert2';
import 'owl.carousel';

$(function() {

    $('.select2').select2({
        theme: 'bootstrap4'
    });

    $(document).on('click', '.delete', function(e) {
        console.log('test');
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
                   $.post($(this).attr('data-href'))
                   $(this).closest('.trick').remove();
                });
            }
        })
    });

    window.owl = $('.owl-carousel').owlCarousel({
        loop: false,
        margin:10,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            800: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: false
            },
            1400: {
                items: 5,
                nav: true
            }
        }
    });

    // initialisation des vidéos au chargement de la page
    $('.item_link').each(function () {
        if ($(this).data('type') == 'video') {
            var path = $(this).closest('.item_link').find('.media-path').val()
            var youtubeUrl = youtube_parser(path);
            $(this).closest('.item_link').find('.video iframe').attr('src', 'https://www.youtube.com/embed/' + youtubeUrl);
        }
    })

    function youtube_parser(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }
});