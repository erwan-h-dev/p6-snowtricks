import $ from 'jquery';

$(function() {

    $.get(paginate_tricks_url, {page: page}, function(json) {
        console.log(json)
        var data = JSON.parse(json)
        console.log(data.total)
        // $('#tricks-list').append(data)

    });

    $("#load-more").on('click', function() {
        page++;
        $.get(paginate_tricks_url, { page: page }, function (data) {
            $('#tricks-list').append(data)
            console.log(data.total)

        });
    });
});