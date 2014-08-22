'use strict';

/* Directives */


angular.module('ccdiTv.directives', []).
  directive('appVersion', ['version', function(version) {
    return function(scope, elm, attrs) {
      elm.text(version);
    };
  }]).
  directive("pageContainer", [null, function(){

    }])


;
