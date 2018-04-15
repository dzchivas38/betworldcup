(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CreateCashOutCtrl', mk);

    mk.$inject = ['$scope', '$uibModalInstance','$player','$PlayerSvc','$actionTypeSvc','toastr'];

    function mk($scope, $uibModalInstance,$player,$playerSvc,$actionTypeSvc,toastr) {
        $scope.Title = "Tỉ lệ triết khấu khách hàng " + _.get($player,"Name");
        $scope.cashOutList = [];
        $scope.actionTypeList = [];
        $scope.actionTypePick = {};
        $scope.cashOut = {};
        var vm = {};
        var formLoad = function () {
            $scope.actionTypePick = {};
            $actionTypeSvc.getAll().then(function (items) {
                _.set($scope,"actionTypeList",items);
                $(function () {
                    vm.msCaPlayer = $('#ms-ca-action').magicSuggest({
                        data: $scope.actionTypeList,
                        expandOnFocus: true,
                        maxDropHeight: 145,
                        placeholder: 'Chọn loại chơi',
                        valueField: 'Id',
                        editable: false,
                        displayField: 'Name',
                        maxSelection: 1
                    });
                    $(vm.msCaPlayer).on('selectionchange', function () {
                        var temp = this.getSelection();
                        $scope.$apply(function () {
                            _.set($scope,"actionTypePick",_.clone(temp[0]));
                            console.log($scope.actionTypePick);
                        });
                    });
                });
            });
            var param = {PlayerId : $player.Id};
            $playerSvc.modalGetCashOutPostId(param).then(function (items) {
               if (_.get(items,"success")){
                    _.set($scope,"cashOutList",_.get(items,"data"));
               }
            });
        };
        formLoad();
        $scope.close = function () {
            $uibModalInstance.dismiss("close");
        }
        $scope.save = function () {
            $uibModalInstance.close();
        }
        $scope.createCashOut = function () {
            if (!_.get($scope,"actionTypePick.Id") || !_.get($scope,"cashOut.InCoin") || !_.get($scope,"cashOut.OutCoin")){
                toastr.warning("Chưa nhập đủ thông tin","Cảnh báo");
                return;
            }
            var cashOut = {
                ActionTypeId : _.get($scope,"actionTypePick.Id"),
                PlayerId:_.get($player,"Id"),
                InCoin : _.get($scope,"cashOut.InCoin"),
                OutCoin : _.get($scope,"cashOut.OutCoin")
            }
            $playerSvc.createCashOutApi(cashOut).then(function (items) {
                if(_.get(items,"success")){
                    toastr.success("Tỉ lệ đã được thêm mới thành công","Success");
                    formLoad();
                }
            });
        }
        function validateForm() {
            
        }
    }
})();
