/**
 * Created by Ákos on 2015.05.04..
 */

(function () {
    "use strict";
    $('#menu-week button').click(function (event) {
        var $this = $(this);
        var id = $this.attr('data-menu-id');
        var jqxhr = $.get(selectUrl, {lunch_menu_id: id}, function () {
            })
            .done(function () {
                document.location.reload(true);
            })
            .fail(function () {
                alert("error");
            })
            .always(function () {
            });
    });

    $('li.food').click(function (event) {
        var $this = $(this);
        var context = {
            id: $this.attr('data-food-id'),
            name: $this.attr('data-food-name'),
            desc: $this.attr('data-food-desc'),
            image: $this.attr('data-food-image')
        };

        $('#modal-body').html('<h3>'+context.name+'</h3>' +
            '<h4>'+context.desc+'</h4>' +
            '<img class="img-responsive img-thumbnail" src="/images/foods/'+context.image+'"' +
            'onerror="if (this.src != \'error.jpg\') this.src = \'/images/noimage.jpg\';"' +
            '/>' +
        ''
        )
        ;
        $('#myModal').modal({});
    });
})();