import $ from 'jquery';

$(function() {

    $(".add_item_link").on('click', function(e) {
            // const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

            // const item = document.createElement('li');

            // item.innerHTML = collectionHolder
            //     .dataset
            //     .prototype
            //     .replace(
            //     /__name__/g,
            //     collectionHolder.dataset.index
            //     );

            // collectionHolder.appendChild(item);

            // collectionHolder.dataset.index++;
        const $list = $('.'+$(this).attr('data-collection-holder-class'))
        const $newElement = $list.data('prototype').replace(/__name__/g, $list.data('index'));
        
        $list.append('li').html($newElement);
    });
});