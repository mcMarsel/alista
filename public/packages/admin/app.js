var myApp = angular.module('myApp', ['bm.bsTour', 'blockUI', 'ui.grid', 'ui.grid.selection', 'ngSanitize', 'ui.select', 'ui.tree', 'wise.import', 'ui.bootstrap']);

angular.module('myApp')
    .directive("popoverHtmlUnsafePopup", function () {
        return {
            restrict: "EA",
            replace: true,
            scope: {title: "@", content: "@", placement: "@", animation: "&", isOpen: "&"},
            template: '<div class="popover {{placement}}" ng-class="{ in: isOpen(), fade: animation() }"><div class="arrow"></div> <div class="popover-inner"> <h3 class="popover-title" ng-bind="title" ng-show="title"></h3> <div class="popover-content" bind-html-unsafe="content"></div> </div></div>'
        };
    })

    .directive("popoverHtmlUnsafe", ["$tooltip", function ($tooltip) {
        return $tooltip("popoverHtmlUnsafe", "popover", "click");
    }]);
