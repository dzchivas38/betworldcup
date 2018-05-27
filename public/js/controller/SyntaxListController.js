/**
 * Created by Dev-1 on 21/07/2017.
 */
/**
 * Created by Dev-1 on 21/07/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('SyntaxListController', SyntaxListController);

    SyntaxListController.$inject = ['$scope','SyntaxSvc','$uibModal','toastr'];

    function SyntaxListController($scope,$SyntaxSvc,$uibModal,toastr) {
        $scope.title = 'SyntaxListController';
        $scope.syntaxList = [];
        formLoad();
        function formLoad() {
            $SyntaxSvc.getAll().then(function (items) {
               console.log(items);
               _.set($scope,"syntaxList",items);
            });
        };
        $scope.createSyntaxUi = function () {
            return $uibModal
                .open({
                    templateUrl: "template/Modal/syntaxForm.html",
                    controller: "CreateSyntaxCtrl",
                    size: "lg",
                    resolve: {
                        $syntax: { Id: 0 },
                    }
                })
                .result.then(function (result) {
                    formLoad();
                })
                .catch(function (e) {
                    console.log(e);
                });
        };
    }
})();
