import $ from 'jquery';

$(function () {

    if ($('#commentaires-list').data('commentaires') > 0) {

        $('#commentaires-list').empty()
        $('#load-more').show()

        $.get(paginate_commentaires_url, { page: page }, (data) => loadComment(data));
    }

    $(document).on('click', ".page-link", function () {
        $.get($(this).attr('data-href'), (data) => loadComment(data));
    });
})

function loadComment(commentaires) {
    $('#commentaires-list').html(commentaires)

    $(".page-link").each(function(){
        $(this)
            .attr('data-href', $(this).attr('href'))
            .removeAttr('href')
    })
}
