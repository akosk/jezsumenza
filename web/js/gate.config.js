/**
 * Created by Ákos on 2014.12.11..
 */

(function () {
   "use strict";

   angular.module('gate')
      .config(gateConfig);

   function gateConfig($routeProvider) {

      $routeProvider.when("/gateone", {
         controller : "GateoneController",
         templateUrl: TEMPLATE_URL + 'gateone.html'
      });
      $routeProvider.when("/gatetwo", {
         controller : "GateoneController",
         templateUrl: TEMPLATE_URL + 'gatetwo.html'
      });

      switch (GATE_ID) {
         case 1:
            $routeProvider.otherwise("/gateone");
            break;
         case 2:
            $routeProvider.otherwise("/gatetwo");
            break;
      }
   }

})();