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

    SyntaxListController.$inject = ['$scope'];

    function SyntaxListController($scope) {
        $scope.title = 'SyntaxListController';
        formLoad();
        function formLoad() {

        };
    }
})();
