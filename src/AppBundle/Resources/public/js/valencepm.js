var app = angular.module('valencepm', ['naturalSort'])

/* Identify angular code within Twig template. */
.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    }
)

/* Setup the service to send/receive data. */
.service('BaseService', function($http) {
    var self = this;
    /* For all server request */
    this.sendRequest = function (scope, request, route, postData, variable, callbackFunction) {
        postData = typeof postData !== "undefined" ? postData : '';
        callbackFunction = typeof callbackFunction !== "undefined" ? callbackFunction : false;
        variable = typeof variable !== "undefined" ? variable : false;

        var parameters = [route];
        if (request === "post") {
            parameters[1] = postData;
        }

        $http[request].apply(this, parameters)
            .success(function(data) {
                if (data !== false) {
                    var thisData = data.data ? data.data : data;

                    if (typeof callbackFunction === "function") {
                        callbackFunction(thisData);
                    } else {
                        scope[variable] = thisData;
                    }
                } else {
                    self.alertError();
                }
            })
            .error(function(data) {
                this.alertError();
            });
    };

    this.alertError = function () {
        alert("Sorry, something has gone wrong.");
    };
})

/* Setup the controller to control the data on the page. */
.controller('testController', ['$scope', 'BaseService', '$filter', '$rootScope', function($scope, $BaseService, $filter, $rootScope) {

    $scope.testRoute = "valencepm_data";
    $scope.data = [];
    $scope.originalData = [];
    $scope.baseService = $BaseService;
    $scope.sortClass = "unit";

    $scope.init = function () {
        $scope.grabData();
    };

    $scope.grabData = function () {
        var route = Routing.generate($scope.testRoute);
        $scope.baseService.sendRequest($scope, 'get', route, false, false, $scope.applyData);
    };

    $scope.applyData = function (data) {
        $scope.data = data.data;
        $scope.originalData = data.originalData;
    };

    $scope.sortData = function (sortOption) {
        $scope.sortClass = sortOption;
        var data = $scope.data;
        $scope.data = $filter('orderBy')(data, $rootScope.natural(sortOption));
    };

    $scope.init();

}]);