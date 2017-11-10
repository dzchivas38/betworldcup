/**
 * Created by Dev-1 on 21/07/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('HomeController', HomeController);

    HomeController.$inject = ['$scope','HomeSvc','$uibModal','toastr'];

    function HomeController($scope,$homeSvc,$uibModal,toastr) {
        $scope.title = 'HomeController';
        $scope.data={};
        $scope.search = function () {
            $scope.searchDate = $('#searchDate').val();
            formLoad($scope.searchDate);

        };
        formLoad();
        function formLoad(keySearch) {
            var now = moment().format('YYYY-MM-DD');
            var result = [];
            keySearch = (keySearch) ? keySearch : now;
            $homeSvc.getResultScheduce(keySearch).then(function (item) {
                if(_.get(item,"length") > 0){
                    _.set($scope,"data",item[0]);
                    result = $scope.data.Description.split('\n');
                    _.pullAt(result, [0]);
                    var count = 0;
                    var temp = _.map(result,function (num) {
                        var value = num.substring(num.indexOf(':') + 2);
                        var key = "";
                        var colspan=0;
                        var style = {};
                        switch (count) {
                            case 0:
                                key = "Giải đặc biệt";
                                colspan = 6;
                                style = {"color": "red","font-weight": "bold"};
                                break;
                            case 1:
                                key = "Giải nhất";
                                colspan = 6;
                                style = '';
                                break;
                            case 2:
                                key = "Giải nhì";
                                colspan = 3;
                                style = '';
                                break;
                            case 3:
                                key = "Giải ba";
                                colspan = 1;
                                style = '';
                                break;
                            case 4:
                                key = "Giải tư";
                                colspan = 1;
                                style = '';
                                break;
                            case 5:
                                key = "Giải năm";
                                colspan = 1;
                                style = '';
                                break;
                            case 6:
                                key = "Giải sáu";
                                colspan = 2;
                                style = '';
                                break;
                            case 7:
                                key = "Giải bảy";
                                colspan = 1;
                                style = '';
                                break;
                        }
                        count++;
                        return {key : key, value :_.split(value, ' - '), colspan : colspan, style : style}
                    });
                    _.set($scope,"data.Description",temp);
                }else {
                    //to do
                }
            });
        };


    }
})();
