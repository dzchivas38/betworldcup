(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('PlayerListController', PlayerListController);

    PlayerListController.$inject = ['$scope']; 

    function PlayerListController($scope) {
        $scope.title = 'PlayerListController';

        activate();

        function activate() { }
    }
})();
