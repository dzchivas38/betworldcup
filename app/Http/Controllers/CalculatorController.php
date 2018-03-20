<?php

namespace App\Http\Controllers;

use App\Models\ActionType;
use App\Models\Messenger;
use App\Models\ResultCaculate;
use App\Models\String;
use App\Models\Syntax;
use Illuminate\Http\Request;
use Illuminate\Support\collection;

use App\Http\Requests;
use DateTime;
use DB;
use Psy\Util\Str;
class CalculatorController extends Controller
{
    private $msg_syntax_list = array();
    /**
     * Display a listing of the resource.
     * @param $strMsg: đoạn tin nhắn cần tính toán
     * @param $pubDate: ngày thực hiện tính toán
     * @param $customer: Với mỗi khách hàng có 1 tỉ lệ tính toán khác nhau
     * @return \Illuminate\Http\Response
     */
    //public function index($strMsg, $pubDate, $customer)
    public function index(Request $rq)
    {
        $strMsg = $rq->input('msg');

        //-------------------------------
        //$strMsg= "De 01.10.17.71x100n. 56.65200n. 02.20.26.62.00x100n. de 67.76400n. 09.90x200n. 25.52x300n. 08.80x100n. 37.73x200n. 58.85x900n. Lo 33x200n. 57.75x100n.tin 5 55.77x100n.";
        $syntax = new Syntax();
        $result = new ResultCaculate();
        $syntaxList = $syntax->getAll();
        $listName = array_map(function($item) {
            return $item->Name;
        }, $syntaxList);
        $syntaxIssueList = $this->validateSyntax($strMsg,$listName);
        if (count($syntaxIssueList) > 0){
            //Tồn tại chuỗi kí tự trong đoạn tin nhắn không có trong danh sách cú pháp
            $result->setIssueHightlightIndex($syntaxIssueList);
            $result->setStatus(false);
            $result->setMsg("Cú pháp tin nhắn chưa đúng !");
            $result->setData(null);
            $result->setMsgSyntaxList($this->msg_syntax_list);
        }else{
            //Tin nhắn sử dụng để tính toán đúng cú pháp
            $result->setIssueHightlightIndex($syntaxIssueList);
            $result->setStatus(true);
            $result->setMsg("Cú pháp tin nhắn chính xác !");
            $result->setData(null);
            $result->setMsgSyntaxList($this->msg_syntax_list);
        }
        return $result->jsonSerialize();
    }
    /**
     * Hàm kiểm tra tính hợp lệ củ tin nhập vào
     * @param $strMsg: đoạn tin nhắn cần kiểm tra cú pháp
     * @param $syntaxList: mảng cú pháp sử dụng để tính toán
     * @return array
    */
    public function validateSyntax($strMsg, $syntaxList){
        $errorList = array();
        $strMsg = (is_string($strMsg)) ? $strMsg : "";
        $msg = new Messenger($strMsg);
        $msgWithSyntax = $msg->getArrayTobeConvertFromMsg($syntaxList);
        $this->msg_syntax_list = $msgWithSyntax;
        foreach ($msgWithSyntax as $item) {
            $value = $this->syntaxChildValidate($item);
            if (count($value) > 0){
                $errorList = array_merge($errorList,$value);
            }
        }
        return $errorList;
    }
    /**
     * Hàm tính toán khi chuỗi nhập vào là đúng cú pháp
     * trả về mảng string có cú pháp ko có kí tự X hoặc x
     */
    public function process(){

    }

    /**
     * Hàm kiểm tra lỗi sai trong toạn tin nhắn đã nhóm theo cú pháp
     * Ví dụ "De" => " 01.10.17.71x100n. 56.65x200n. 02.20.26.62.00x100n. "
     * @param $syntaxChild là đoạn tin nhắn trong nhóm 1 cú pháp kiểu chơi ví dụ như đề
     * @return array
     */
    public function syntaxChildValidate($syntaxChild){
        $errorList = array();
        $syntaxChild = is_string($syntaxChild) ? trim($syntaxChild) : "";
        $syntaxChild = new String($syntaxChild);
        if ($syntaxChild->length() > 0){
            $syntaxChildList = explode(" ",$syntaxChild->get());
            foreach ($syntaxChildList as $item) {
                $d = (strpos($item, 'x'));
                if(substr_count($item,"x") >=2){
                    $errorList[] = $item;
                }else{
                    if (!$d){
                        $errorList[] = $item;
                    }else{
                        $item_clone = new String($item);
                        $x_index = $item_clone->firstIndexOf("x");
                        $x_sub = $item_clone->subString($x_index);
                        $number_only = preg_replace("/[^0-9]/", "", $item_clone->get());
                        if (strlen($number_only) >5){
                            $errorList[] = $item;
                        }
                    }
                }
            }
        }else{

        }
        return $errorList;
    }
}
