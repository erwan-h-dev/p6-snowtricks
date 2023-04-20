import $ from 'jquery';
import Swal from 'sweetalert2';

$(function() {

    // ajout d'un média
    $(document).on('click', ".add_item_link", function(e) {
        const $list = $('.'+$(this).attr('data-collection-holder-class'))

        const $newElement = $list.data('prototype').replace(/__name__/g, $list.data('index'));

        window.owl.trigger('add.owl.carousel', [$newElement]).owlCarousel('update');

        $list.data('index', $list.data('index')+1)
    });

    // gestion du type de média
    $(document).on('change', ".type-select", function(e) {
        if($(this).val() == 'image') {
            $(this).closest('.item_link').find('.image-field').show();
            $(this).closest('.item_link').find('.image').show();

            $(this).closest('.item_link').find('.video-field').hide();
            $(this).closest('.item_link').find('.video').hide();
        }else if($(this).val() == 'video') {
            $(this).closest('.item_link').find('.image-field').hide();
            $(this).closest('.item_link').find('.image').hide();

            $(this).closest('.item_link').find('.video-field').show();
            $(this).closest('.item_link').find('.video').show();
            $(this).closest('.item_link').find('.video-field').trigger('change');
        }
    })

    // au changement de l'image 
    $(document).on('change', ".image-field", function(e) {
        // envoie de l'image en ajax
        var file_data = $(this).prop('files')[0];
        var $img = $(this).closest('.item_link').find('.image');
        var fileReader = new FileReader();

        fileReader.onload = function(){
            $img.attr('src', fileReader.result);
        }
        
        fileReader.readAsDataURL(file_data);
    })

    // au changement de l'url de la vidéo
    $(document).on('change', ".video-field", function(e) {
        var youtubeUrl = youtube_parser($(this).val());
        console.log(youtubeUrl)
        $(this).closest('.item_link').find('.video iframe').attr('src', 'https://www.youtube.com/embed/'+youtubeUrl);
    })

    // sauvegarde d'un média
    $(document).on('click', ".item_link .save", function(e) {
        $(this).closest('.item_link').find('.media-form').hide();
        $(this).closest('.item_link').find('.media-view.footer').show();
    })

    // modifier un média
    $(document).on('click',".item_link .edit", function(e) {
        $(this).closest('.item_link').find('.media-form').show();
        $(this).closest('.item_link').find('.media-view.footer').hide();

        if($(this).closest('.item_link').find('.type-select').val() == 'image') {
            $(this).closest('.item_link').find('.image-field').show();
            $(this).closest('.item_link').find('.video-field').hide();
        }else {
            $(this).closest('.item_link').find('.image-field').hide();
            $(this).closest('.item_link').find('.video-field').show();
        }
    })

    // suppression d'un média
    $(document).on('click', ".item_link .remove", function(e) {
        const $item = $(this).closest('.item_link');

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
                window.owl
                    .trigger('remove.owl.carousel', [$item.data('index')])
                    .trigger('update.owl.carousel');

                Swal.fire({
                    title: 'Supprimé !',
                    text: 'Vous allez être rediriger vers la liste des tricks.',
                    icon: 'success',
                    confirmButtonText: 'Confirmer'
                });
            }
        });
    })
});