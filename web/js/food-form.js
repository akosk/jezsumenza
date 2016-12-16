/**
 * Created by Ákos on 2015.05.04..
 */


(function () {
   "use strict";

   var validation = function (event, attribute, messages) {
      $('[id^=panel]').each(
         function (index, item) {
            var $item = $(item);
            var hasError = $item.find('.has-error').length > 0;
            var $a = $('[data-tab="' + $item.attr('id') + '"]');
            if (hasError) {
               $a.css('color', 'red');
            } else {
               $a.css('color', '');
            }

         }
      );

      var $this = $(this);
      var hasError = $this.find('.has-error');
      if (hasError && hasError.length>0) {
         var huValid = $('#foodtranslation-hu-hu-name').val().length > 0 &&
            $('#food-category').val().length > 0;

         if (huValid) {
            swal({
               title             : "Az idegen nyelveken is elmentsem magyarul?",
               text              : "Nem töltötte ki az étel nevét és leírását minden nyelven!",
               type              : "warning",
               showCancelButton  : true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText : "Igen",
               cancelButtonText  : "Nem",
               closeOnConfirm    : true
            }, function () {
               // 1. Összes idegen nyelv nevébe sé leírásába -ami nincs kitöltve!!!!- írjuk bele a magyar nyelven megadottat


               var $firstItem = null;
               $('#w5').find('input').not(':input[type=file]').each(function (index, item) {
                  if (index == 0) {
                     $firstItem = $(item);
                  } else {
                     $(item).val($firstItem.val());
                  }
               });

               var $firstItem = null;
               $('#w5').find('textarea').each(function (index, item) {
                  if (index == 0) {
                     $firstItem = $(item);
                  } else {
                     $(item).val($firstItem.val());
                  }
               });

               // 2. Klikkeljünk a Submitra
               $('form').off('afterValidate', validation);
               $('#w5').submit();
            });
         }
      }

   };
   $('form').on('afterValidate', validation);

})();