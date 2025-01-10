$(document).ready(function () {

    $('li.dd-item').each(function (list) {
        if ($(this).parents('ol').length == 1) {
            $(this).find('#mega-menu-area').show(500);
        } else {
            $(this).find('#mega-menu-area').hide(500);
        }

    });


    $('.expend-icon').on('click', function () {
        var abc = $(this).parent().find('.expended-menu-item').html();
        $(".expended-menu-item").each(function () {
            if (abc === $(this).html()) {
                if ($(this).css('display') == 'none') {
                    $(this).show(500);
                } else {
                    $(this).hide(500);
                }
            } else {
                $(this).hide(500);
            }
        });
    });


    $('#nestable3').nestable().on('change', function (e) {

        $('li.dd-item').each(function (list) {
            if ($(this).parents('ol').length == 1) {
                $(this).find('#mega-menu-area').show();
            } else {
                $(this).find('#mega-menu-area').hide();
            }

            if ($(this).parents('ol').length == 1) {

                $(this).find('#menu_lenght').val(1);

            } else if ($(this).parents('ol').length == 2) {

                $(this).find('#menu_lenght').val(2);

            } else if ($(this).parents('ol').length == 3) {

                $(this).find('#menu_lenght').val(3);

            }

        });

    });

});
