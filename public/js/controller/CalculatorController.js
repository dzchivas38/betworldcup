/**
 * Created by DungNV44 on 7/26/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CalculatorController', CalculatorCtrl);

    CalculatorCtrl.$inject = ['$scope','CalculatorSvc','toastr','blockUI'];

    function CalculatorCtrl($scope,$CalculatorSvc,toastr,blockUI) {
        $scope.title = 'CalculatorController';
        var htmlCodeHeader = "<span style='color: red'>";
        var htmlCodeEnd = "</span>";
        formLoad();
        function formLoad() {
            // $scope.htmlcontent = "<span style='color: red'>aaaa</span>"
        };
        var vm={};
        // truyền vào: msg,pubdate,customer
        $scope.process = function () {
            $scope.htmlcontent = deCodeHtmlContent($scope.htmlcontent);
            $CalculatorSvc.process({msg:$scope.htmlcontent})
                .then(function (item) {
                    console.log(item);
                    return 0;
                if(_.get(item,"status") === false){
                    toastr.error('Tin nhắn chưa đúng cú pháp!', 'Cảnh báo');
                    $scope.htmlcontent = endCodeHtmlContent(_.clone($scope.htmlcontent),_.get(item,"issueHightlightIndex"));
                }else {
                    toastr.success('Tin nhắn chính xác', 'Thành công');
                }
            })
        }
        function validateMsg() {
            var htmlcontentClone = _.clone($scope.htmlcontent);
            //2 dấu X liền nhau => 1 dấu x
            //Chỉ còn 1 dấu X trong 1 đoạn
        }
        function endCodeHtmlContent(htmlcontent,items) {
            var htmlcontentClone = _.clone(htmlcontent);
            if (items.length > 0){
                if (htmlcontentClone.length > 0){
                    _.forEach(items,function (item) {
                        item = (item.length == 1 || item.length == 2) ?  " " + item + " " : item;
                        var newChar = htmlCodeHeader + item + htmlCodeEnd;
                        htmlcontentClone = htmlcontentClone.split(item).join(newChar);
                    });
                    return htmlcontentClone;
                }else {
                    return "";
                }
            }else {
                return htmlcontent;
            }
        }
        function deCodeHtmlContent(str)
        {
            if ((str===null) || (str===''))
                return false;
            else
                str = str.toString();
            return str.replace(/<[^>]*>/g, '');
        }
        $(function () {
            $('.txtDateTime').datetimepicker({
                dayOfWeekStart: 1,
                lang: 'vi',
                startDate: '2014/10/10',
                format: 'd/m/Y',
                dateonly: false,
                showHour: false,
                closeOnDateSelect: true,
                showMinute: false,
                timepicker: false,
                onChangeDateTime: function(dp, $input) {
                }
            });
            var data = [{Id:1,Name:'Dũng'},{Id:2,Name:'Khánh'}]
            vm.msCaPlayer = $('#ms-ca-player').magicSuggest({
                resultAsString: true,
                maxDropHeight: 145,
                placeholder: 'Chọn khách hàng',
                valueField: 'Id',
                editable: false,
                displayField: 'Name',
                expandOnFocus: true,
                data: data
            });
            $(vm.msCaPlayer).on('selectionchange', function () {
                var selection = JSON.stringify(this.getSelection());
                var temp = this.getSelection();
                console.log(selection);
                console.log(temp);
            });
        });
    }
})();