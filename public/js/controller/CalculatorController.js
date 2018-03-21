/**
 * Created by DungNV44 on 7/26/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .controller('CalculatorController', CalculatorCtrl);

    CalculatorCtrl.$inject = ['$scope','CalculatorSvc','PlayerSvc','SyntaxSvc','toastr','blockUI'];

    function CalculatorCtrl($scope,$CalculatorSvc,$playerSvc,$syntaxSvc,toastr,blockUI) {
        $scope.title = 'CalculatorController';
        $scope.playerList = [];
        $scope.syntaxList = [];
        var htmlCodeHeader = "<span style='color: red'>";
        var htmlCodeEnd = "</span>";
        formLoad();
        function formLoad() {
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
                        console.log(dp);
                        console.log($input);
                    }
                });
                $scope.ngaytinh = moment().format('DD/MM/YYYY');
                $playerSvc.getAll().then(function (items) {
                    _.set($scope,"playerList",items);
                    vm.msCaPlayer = $('#ms-ca-player').magicSuggest({
                        data: $scope.playerList,
                        resultAsString: true,
                        expandOnFocus: true,
                        maxDropHeight: 145,
                        placeholder: 'Chọn khách hàng',
                        valueField: 'Id',
                        editable: false,
                        displayField: 'Name',
                        maxSelection: 1,
                        required: true
                    });
                    $(vm.msCaPlayer).on('selectionchange', function () {
                        var selection = JSON.stringify(this.getSelection());
                        var temp = this.getSelection();
                        console.log(selection);
                        console.log(temp);
                    });
                });
            });
            $syntaxSvc.getAll().then(function (items) {
               _.set($scope,"syntaxList",items);
            });
        };
        var vm={};
        // truyền vào: msg,pubdate,customer
        $scope.process = function () {
            $scope.htmlcontent = deCodeHtmlContent($scope.htmlcontent);
            var checked = validateMsg();
            if (checked){
                $CalculatorSvc.process({msg:$scope.htmlcontent})
                    .then(function (item) {
                        console.log(item);
                        if(_.get(item,"status") === false){
                            toastr.error('Tin nhắn chưa đúng cú pháp!', 'Cảnh báo');
                            $scope.htmlcontent = endCodeHtmlContent(_.clone($scope.htmlcontent),_.get(item,"issueHightlightIndex"));
                        }else {
                            console.log("Tin nhắn đúng");
                        }
                    });
            }
        };
        function validateMsg() {
            var htmlcontentClone = ($scope.htmlcontent) ? _.clone($scope.htmlcontent) :"";
            if (htmlcontentClone.length >0){
                htmlcontentClone = removeFirstChar(htmlcontentClone,$scope.syntaxList);
                htmlcontentClone = htmlcontentClone.replaceAll("×","x",true);
                htmlcontentClone = htmlcontentClone.replaceAll("X","x",true);
                htmlcontentClone = htmlcontentClone.replaceAll("xxx","x",true);
                htmlcontentClone = htmlcontentClone.replaceAll("xx","x",true);
                //2 dấu X liền nhau => 1 dấu x
                //Chỉ còn 1 dấu X trong 1 đoạn
                _.set($scope,"htmlcontent",htmlcontentClone);
                return true;
            }else{
                toastr.warning("Vui lòng nhập tin nhắn cần tính","Cảnh báo!");
                return false;
            }
        }
        function removeFirstChar(str,syntaxList) {
            str = (str) ? str : "";
            var charList = str.split(" ");
            var temp = [];
            for (var i=0;i<charList.length;i++){
                var checked = _.some(syntaxList,function (item) {
                                    return _.toLower(_.get(item,"Name")) == _.toLower(charList[i]);
                                });
                if (!checked){
                    temp.push(i);
                }else {
                    break;
                }
            }
            if (temp.length > 0){
                _.pullAt(charList,temp);
                toastr.warning("Những kí tự đầu tin nhắn sai cú pháp đã được remove!","Cảnh báo");
            }
            return _.map(charList).join(" ");
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
            str = (str) ? str :"";
            if ((str===null) || (str===''))
                return false;
            else
                str = str.toString();
            return str.replace(/<[^>]*>/g, '');
        }
    }
})();