var imp = angular.module('wise.import', ['ui.grid'])
    .directive('wiseImport', function () {
        var controller = ['$scope', '$http', function ($scope, $http) {
            $scope.uploaded = false;
            $scope.progress = 0;
            $scope.gridOptions = {
                enableSorting: false,
                maintainColumnRatios: false,
                enableColumnResize: true,
                i18n: 'ru',
                enableRowSelection: false,
                enableFullRowSelection: false,
                enableSelectAll: false,
                selectionRowHeaderWidth: 30,
                rowHeight: 30,
                columnWidth: 60
            };
            $scope.columnNames = [];
            $scope.letters = [];
            $scope.updateSelects = function () {
                // освобождаем незаюзанные буквы
                angular.forEach($scope.letters, function (letter) {
                    letter.taken = false;
                });
                // блокируем заюзанные
                angular.forEach($scope.columnNames, function (colName) {
                    angular.forEach($scope.letters, function (letter) {
                        if (colName.letter == letter.column) {
                            letter.taken = true;
                        }
                    });
                });
                //console.log($scope.columnNames);
                //console.log($scope.letters);
            }
            $scope.setFiles = function (element) {
                $scope.$apply(function ($scope) {
                    $scope.files = [];
                    for (var i = 0; i < element.files.length; i++) {
                        $scope.files.push(element.files[i])
                    }
                    $scope.progressVisible = false
                });
                $scope.uploadFile();
            };
            $scope.uploadFile = function () {
                var formData = new FormData();
                for (var i in $scope.files) {
                    formData.append("Files", $scope.files[i]);
                }
                var request = new XMLHttpRequest();
                request.upload.addEventListener("progress", uploadProgress, false);
                request.addEventListener("load", transferComplete, false);
                request.addEventListener("error", transferFailed, false);
                request.addEventListener("abort", transferCanceled, false);
                request.open("POST", $scope.url, true);
                $scope.progressVisible = true;
                request.send(formData);
            };
            function uploadProgress(evt) {
                $scope.$apply(function () {
                    if (evt.lengthComputable) {
                        $scope.progress = Math.round(evt.loaded * 100 / evt.total)
                    } else {
                        $scope.progress = 'unable to compute';
                    }
                });
            }
            function transferComplete(evt) {
                //console.log(evt.target.responseText);
                $scope.uploaded = true;
                $scope.gridOptions.data = JSON.parse(evt.target.responseText).data;
                $scope.gridOptions.columnDefs = JSON.parse(evt.target.responseText).defs;
                $scope.columnNames = JSON.parse(evt.target.responseText).names;
                console.log($scope.columnNames);
                angular.forEach($scope.gridOptions.columnDefs, function (def) {
                    $scope.letters.push({column: def.field, taken: false});
                });
            };
            function transferFailed(evt) {
                alert(" Error in attempting to upload the file.");
            };
            function transferCanceled(evt) {
                $scope.$apply(function () {
                    $scope.progressVisible = false
                });
                alert("The upload has been canceled by the user.")
            }
        }];
        return {
            restrict: 'EA',
            scope: {
                url: '@',
                proceedUrl: '@'
            },
            controller: controller,
            templateUrl: '/packages/exfriend/wise-import/wise-import.html'
        };
    });