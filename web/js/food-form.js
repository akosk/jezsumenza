/**
 * Created by Ákos on 2015.05.04..
 */


(function () {
   "use strict";

   $('form').on('afterValidate', function(event, attribute, messages) {
      $('[id^=panel]').each(
         function (index,item) {
            var $item=$(item);
            var hasError=$item.find('.has-error').length>0;
            var $a=$('[data-tab="'+$item.attr('id')+'"]');
            if (hasError) {
               $a.css('color','red');
            } else {
               $a.css('color','');
            }

         }
      );

   });

})();