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
})();