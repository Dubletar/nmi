app.controller('barcodeController', ['$scope', 'BaseService', 'Upload', '$timeout', function($scope, $BaseService, Upload, $timeout) {

        $scope.urls = {
            barCodeData: "bar_code_data",
            fileUpload: "upload_barcode_pdfs"
        };
        $scope.baseService = $BaseService;
        $scope.data = [];
        $scope.loading = false;
        $scope.invalids = [];

        $scope.init = function () {
            $scope.grabData();
        };

        $scope.grabData = function () {
            var route = Routing.generate($scope.urls.barCodeData);
            $scope.baseService.sendRequest($scope, 'get', route, false, false, function (data) {
                $scope.data = data;
            });
        };

        $scope.uploadFiles = function(files) {
            $scope.files = files;
            $scope.invalids = [];
            var thisData;

            angular.forEach(files, function(file) {
                if (file.type !== "application/pdf") {
                    thisData = {
                        fileName: file.name,
                        message: "Only pdf files are allowed. " + file.type + " detected."
                    };
                    $scope.invalids.push(thisData);
                } else {
                    file.upload = Upload.upload({
                        url: Routing.generate($scope.urls.fileUpload),
                        data: {file: file}
                    });

                    file.upload.then(function (response) {
                        $timeout(function () {
                            if (response.data) {
                                if (response.data.data[0].error) {
                                    thisData = {
                                        fileName: response.data.data[0].name,
                                        message: response.data.data[0].error
                                    };
                                } else {
                                    $scope.data.push(response.data.data[0]);
                                }
                            }
                        });
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                    }, function (evt) {
                        file.progress = Math.min(100, parseInt(100.0 *
                            evt.loaded / evt.total));
                    });
                }
            });
        };

        $scope.init();

    }]);