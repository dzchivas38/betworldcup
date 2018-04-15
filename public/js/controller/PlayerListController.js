(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('PlayerListController', PlayerListController);

    PlayerListController.$inject = ['$scope','PlayerSvc','ActionTypeSvc','$uibModal','toastr'];

    function PlayerListController($scope,$playerSvc,$actionTypeSvc,$uibModal,toastr) {
        $scope.title = 'PlayerListController';
        $scope.players = [];
        var formLoad = function ()
        {
            $playerSvc.getAll().then(function (items) {
                _.set($scope,"players",items)
            });
        }
        formLoad();
        $scope.createPlayerUi = function () {
            return $uibModal
                .open({
                    templateUrl: "template/Modal/playerForm.html",
                    controller: "CreatePlayerCtrl",
                    size: "lg",
                    resolve: {
                        $player: { Id: 0 }
                    }
                })
                .result.then(function (result) {
                    $playerSvc.createPlayer(result).then(function (item) {
                        if (_.get(item, "success")) {
                            toastr.success("OK", 'Thành công');
                            formLoad();
                        } else {
                            toastr.error("Fail".ERROR, 'Lỗi');
                        }
                    });
                })
                .catch(function (e) {
                    console.log(e);
                });
        }
        $scope.cashOutInfo = function (playerId) {
            return $uibModal
                .open({
                    templateUrl: "template/Modal/cashOutForm.html",
                    controller: "CreateCashOutCtrl",
                    size: "lg",
                    resolve: {
                        $player: playerId,
                        $PlayerSvc : $playerSvc,
                        $actionTypeSvc:$actionTypeSvc
                    }
                })
                .result.then(function (result) {

                })
                .catch(function (e) {
                    console.log(e);
                });
        }
    }
})();
