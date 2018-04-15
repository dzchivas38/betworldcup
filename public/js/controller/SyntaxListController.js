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

    SyntaxListController.$inject = ['$scope','SyntaxSvc'];

    function SyntaxListController($scope,$SyntaxSvc) {
        $scope.title = 'SyntaxListController';
        $scope.syntaxList = [];
        formLoad();
        function formLoad() {
            $SyntaxSvc.getAll().then(function (items) {
               console.log(items);
               _.set($scope,"syntaxList",items);
            });
        };
    }
})();
