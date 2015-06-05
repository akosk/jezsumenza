/**
 * Created by Ákos on 2014.12.11..
 */

/*jshint loopfunc: true */
/*global    BASE_URL:true, isAdmin: true, isPayrollManager: true, isInstructor:true, isDepLeader:true, isDepAdmin:true,
 userId: true, editDisabled: true */


(function () {
   "use strict";
   angular.module('gate')
      .controller('GateoneController', GateoneController);


   function GateoneController($scope, dataService) {
      $scope.isBusy = false;
      $scope.items = [];
      $scope.puffer = '';
      $scope.dataService = dataService;

      $scope.isFocused = $(window).focus();
      console.log('Init gateone controller.');


      $scope.gateEvent = function (barcode) {
         $scope.isBusy = true;
         dataService.addGateEvent(1, barcode)
            .then(
            function () {
            },
            function () {
               console.log("Cannot send gate event!");
            }
         ).then(function () {
               $scope.isBusy = false;
            });

      };

      $scope.getFoodName = function (gateEvent) {
         var foods = gateEvent.lunch_menu_food;
         if (foods===undefined) return '';
         foods.sort(
            function (a, b) {
               if (a.category < b.category) {
                  return 1;
               }
               if (a.category > b.category) {
                  return -1;
               }
               return 0;
            });

         var res=foods.map(function (a) {
            return a.name;
         });

         return res.join();
      };

      $(window).blur(function (event) {
         $scope.$apply(function () {
            $scope.isFocused = false;
         });
      });

      $(window).focus(function (event) {
         $scope.$apply(function () {
            $scope.isFocused = true;
         });
      });


      $('html').keypress(function (event) {
         //$scope.puffer.match(/^[0-9]{5}$/)
         $scope.$apply(function () {
            if (event.keyCode !== 13) {
               $scope.puffer += String.fromCharCode(event.keyCode);
            } else {
               $scope.items.push($scope.puffer);
               $scope.gateEvent($scope.puffer);
               $scope.puffer = '';

            }
         });
      });


      $scope.getTemplate = function (template) {
         return TEMPLATE_URL + template;
      };

   }

})();