(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('PlayerListController', PlayerListController);

    PlayerListController.$inject = ['$scope','PlayerSvc'];

    function PlayerListController($scope,$playerSvc) {
        $scope.title = 'PlayerListController';

        var formLoad = function ()
        {
            $playerSvc.getAll().then(function (item) {
                console.log(item);
            });
        }
        formLoad();
    }
})();
