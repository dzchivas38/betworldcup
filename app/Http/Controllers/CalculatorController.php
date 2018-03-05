<?php

namespace App\Http\Controllers;

use App\Models\ActionType;
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
    public function index($strMsg, $pubDate, $customer)
    {
        $syntax = new Syntax();
        $result = new ResultCaculate();
        $syntaxList = $syntax->getAll();
        $syntaxIssueList = $this->validateSyntax($strMsg,$syntaxList);
        $syntaxCollection = collect($syntaxIssueList);
        if ($syntaxCollection->count() > 0){
            //Tồn tại chuỗi kí tự trong đoạn tin nhắn không có trong danh sách cú pháp
            $result->setIssueHightlightIndex($syntaxIssueList);
            $result->setStatus(false);
            $result->setMsg("Cú pháp tin nhắn chưa đúng !");
            $result->setData(null);
        }else{
            //Tin nhắn sử dụng để tính toán đúng cú pháp

        }
        return $result;
    }
    /**
     * @param $strMsg: đoạn tin nhắn cần kiểm tra cú pháp
     * @param $syntaxList: mảng cú pháp sử dụng để tính toán
    */
    public function validateSyntax($strMsg, $syntaxList){

    }

}
