'use strict';

/* Directives */


angular.module('ccdiTv.directives', []).
  directive('appVersion', ['version', function(version) {
    return function(scope, elm, attrs) {
      elm.text(version);
    };
  }]).
  directive("pageContainer", function(){
    return {
        restrict: "E",
        controller: function(){
            this.pages = [];
            this.currentPage = 0;
            this.minDelay = 5000;

            this.registerPage = function(page){
                this.pages.push(page);
            }
        }
    }
    }).
    directive("page", function(){
        return {
            restrict: "E",
            require: "^page-container",
            link: function (scope, element, attrs, pageContainerCtrl) {
                //pageContainerCtrl.registerPage();
                console.log("page registered");
            }

        }
    })


;
