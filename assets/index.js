$(function() {

    if ($('#tricks-list').data('tricks') > 0) {

        $('#tricks-list').empty()
        $('#load-more').show()

        $.get(paginate_tricks_url, { page: page }, (data) => loadTricks(data));
    }

    $("#load-more").on('click', function() {
        page++;

        $.get(paginate_tricks_url, { page: page }, (data) => loadTricks(data));
    });
});

function loadTricks(tricks){
    $('#tricks-list').append(tricks)

    var totalTricks = $('#tricks-list').data('tricks')

    if (totalTricks <= $('.trick').length) {
        $('#load-more').hide()
    }
}