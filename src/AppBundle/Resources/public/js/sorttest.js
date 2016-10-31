app.controller('testController', ['$scope', 'BaseService', '$filter', '$rootScope', function($scope, $BaseService, $filter, $rootScope) {

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
