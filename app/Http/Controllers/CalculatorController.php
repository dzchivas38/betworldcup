<?php

namespace App\Http\Controllers;

use App\Models\ActionType;
use App\Models\Messenger;
use App\Models\ResultCaculate;
use App\Models\Syntax;
use Illuminate\Http\Request;
use Illuminate\Support\collection;

use App\Http\Requests;
use DateTime;
use DB;

class CalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param $strMsg: đoạn tin nhắn cần tính toán
     * @param $pubDate: ngày thực hiện tính toán
     * @param $customer: Với mỗi khách hàng có 1 tỉ lệ tính toán khác nhau
     * @return \Illuminate\Http\Response
     */
    //public function index($strMsg, $pubDate, $customer)
    public function index()
    {
        $strMsg= "De 01.10.17.71x100n. 56.65x200n. 02.20.26.62.00x100n. de 67.76x400n. 09.90x200n. 25.52x300n. 08.80x100n. 37.73x200n. 58.85x900n. Lo 33x200n. 57.75x100n.tin 5 55.77x100n.";
        $syntax = new Syntax();
        $result = new ResultCaculate();
        $syntaxList = $syntax->getAll();
        $listName = array_map(function($item) {
            return $item->Name;
        }, $syntaxList);
        $syntaxIssueList = $this->validateSyntax($strMsg,$listName);
        $syntaxCollection = collect($syntaxIssueList);
        if ($syntaxCollection->count() > 0){
            //Tồn tại chuỗi kí tự trong đoạn tin nhắn không có trong danh sách cú pháp
            $result->setIssueHightlightIndex($syntaxIssueList);
            $result->setStatus(false);
            $result->setMsg("Cú pháp tin nhắn chưa đúng !");
            $result->setData(null);
        }else{
            //Tin nhắn sử dụng để tính toán đúng cú pháp
            echo "tin nhan dung";
        }
        return $result;
    }
    /**
     * @param $strMsg: đoạn tin nhắn cần kiểm tra cú pháp
     * @param $syntaxList: mảng cú pháp sử dụng để tính toán
    */
    public function validateSyntax($strMsg, $syntaxList){
        $strMsg = (is_string($strMsg)) ? $strMsg : "";
        $msg = new Messenger($strMsg);
        $msgWithSyntax = $msg->getArrayTobeConvertFromMsg($syntaxList);
        dd($msgWithSyntax);
    }

}
