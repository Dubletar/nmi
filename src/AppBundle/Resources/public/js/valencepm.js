var app = angular.module('valencepm', ['naturalSort', 'ngFileUpload'])

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
                self.alertError();
            });
    };

    this.alertError = function () {
        alert("Sorry, something has gone wrong.");
    };
});