/**
 * Created by Ákos on 2014.12.11..
 */

/*jshint loopfunc: true */
/*global BASE_URL:true,_:true */


(function () {
   "use strict";

   if (BASE_URL === undefined) {
      BASE_URL = '/';
   }

   angular.module('gate')
      .factory('dataService', dataService);

   function dataService($http, $q) {

      var _gateEvents = [];
      var _lastGateEvent = null;

      var _getGateEvents = function () {
         return _gateEvents;
      };


      var _addGateEvent = function (gate, barcode) {
         console.dir(barcode);
         var deferred = $q.defer();
         $http({
            url   : BASE_URL + '/gate/gate-event',
            method: "GET",
            params: {gate: gate, barcode: barcode}
         })
            .then(function (result) {
               _lastGateEvent = result.data;
               _gateEvents.unshift(_lastGateEvent);
               deferred.resolve();
            }, function (e) {
               var error=$('.alert',e.data).html().trim();
               _gateEvents.unshift({error:error});
               deferred.reject();
            });
         return deferred.promise;
      };


      return {
         getGateEvents: _getGateEvents,
         addGateEvent : _addGateEvent
      };
   }

})();