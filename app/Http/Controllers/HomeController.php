<?php

namespace App\Http\Controllers;

use App\Models\HashMap;
use App\Models\Messenger;
use App\Models\ResultViewModel;
use App\Models\String;
use App\Models\Syntax;
use Illuminate\Http\Request;
use App\Http\Requests;
use DOMDocument;
use DateTime;
use DB;
use Psy\Util\Str;


class HomeController extends Controller
{

    public function test3(){
        var_dump(ctype_digit("00"));
    }
    public function test()
    {
        $str = "De 01.45.91.17.71x100n. 56.65x200n. 02.20.26.62.00x100n. de 67.76x400n. 09.90x200n. 25.52x300n. 08.80x100n. 37.73x200n. 58.85x900n. Lo 33x200n. 57.75x100n";
        $msg = new Messenger($str);
        $syntax = new Syntax();
        $syntaxList = $syntax->getAll();
        $listName = array_map(function($item) {
            return $item->Name;
        }, $syntaxList);
        $msgWithSyntax = $msg->getArrayTobeConvertFromMsg($listName);
        try {
            $results = DB::table('tbl_result_number')->whereDate('PubDate', '=', '2018-03-31')->first();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        //$temp là mảng kết quả xổ số
        $temp = preg_split('/\r\n|\r|\n/', $results->Description);
        array_shift($temp);
        //$player_join_cash_out mảng các cú pháp cùng tỉ lệ theo khách hàng
        $player_join_cash_out = DB::table('tbl_player')
            ->join('tbl_cashout', 'tbl_player.Id', '=', 'tbl_cashout.PlayerId')
            ->join('tbl_actiontype', 'tbl_cashout.ActionTypeId', '=', 'tbl_actiontype.Id')
            ->select('tbl_player.Id', 'tbl_player.Name', 'tbl_cashout.InCoin','tbl_cashout.OutCoin','tbl_actiontype.Name','tbl_actiontype.ActionTypeLevel','tbl_actiontype.Code','tbl_actiontype.Unit')
            ->where('tbl_player.Id', '=', 7)
            ->get();
        //dd($player_join_cash_out);
        $this->checkLive($msgWithSyntax,$player_join_cash_out,$temp);

    }
    public function checkLive($tin_nhan,$cash_out,$ket_qua_so_xo){
        $syn = New Syntax();
        $hm = new HashMap($cash_out);
        $vm_result_list = array();
        $kq_list = array_map(function($key,$value) {
            $value = trim($value);
            $i = strpos($value, " ",0);
            $v = substr($value,$i,strlen($value) - $i);
            $v = trim($v);
            if ($key == 0){
                return $v;
            }else{
                $v = explode(" - ",$v);
                return $v;
            }
        }, array_keys($ket_qua_so_xo),array_values($ket_qua_so_xo));
        foreach ($tin_nhan as $key=>$value){
            $criteria = $syn->getConstSyn($key);
            $syntaxForm = $criteria->SyntaxForm;
            $x = $hm->findByKey($syntaxForm,'Code');
            $cus_cash_out = array_pop($x);
            $vm_result = $this->parserMsg($value,$cus_cash_out,$kq_list);
            $vm_result_list = array_merge($vm_result_list,$vm_result);
        }
        return $vm_result_list;
    }
    //hàm tính đoạn tin nhắn con trả mảng kết quả.
    public function parserMsg($tin_nhan,$cash_out,$ket_qua_so_xo){
        $return_list = array();
        $tin_nhan =  new String($tin_nhan);
        $tin_nhan->trimS();
        $point_group = $tin_nhan->explode(" ");
        if(count($point_group) > 0){
            foreach ($point_group as $key=>$value){
                $str = new String($value);
                $obj_result_vm = new ResultViewModel($value);
                $index = $str->firstIndexOf("x");
                $point_vali = $str->subString($index);
                $num_list = explode(".",$point_vali);

                //chuyển chuỗi string thành mảng
                $char_list_money = str_split($str->get());
                $n = $this->getFirstIndexOfNumber($char_list_money);
                $c = $this->getFirstIndexOfChar($char_list_money,$n);
                $vali = substr($str->get(),$n,$c-$n);//giá trị của các số dánh
                $sum = count($num_list); //đếm số đánh qua dấu . nên + 1 do ko có dấu . cuối
                $sum = $sum*$vali*($cash_out->InCoin);
                // Đoạn so kết quả với từng loại chơi check ở đây
                if ($cash_out->Code =="de"){
                    $bingo_list = $this->getResultFormRList($num_list,$ket_qua_so_xo,2,false,0);
                }else{
                    $bingo_list = $this->getResultFormRList($num_list,$ket_qua_so_xo,2,true,0);
                }

                $bingo_count = count($bingo_list);
                if ($bingo_count >0){
                    $bingo_val = $bingo_count*$vali*($cash_out->OutCoin);
                }else{
                    $bingo_val = 0;
                }
                $kq_cc = $bingo_val - $sum;
                $obj_result_vm->setSum($sum);
                $obj_result_vm->setSoTrung($bingo_list);
                $obj_result_vm->setBingo($bingo_val);
                $obj_result_vm->setKqCc($kq_cc);
                $obj_result_vm->setActionType($cash_out->Code);
                $obj_result_vm->setSoDanh($num_list);
                $return_list[] = $obj_result_vm;
            }
        }
        return $return_list;
    }
    //Hàm tính giá trị trúng từ kết quả xổ số
    public function getReturnValue(){

    }
    //hàm tìm số trong mảng kết quả dạng arr(arr) trả về mảng những số có trong danh sách
    //r_list là mảng kết quả xổ số đã gia công
    private function getResultFormRList($num_list,$r_list,$offset,$check_all,$vi_tri_check){
        $re_list = array();
        if ($check_all){
            foreach ($num_list as $num){
                foreach ($r_list as $result){
                    if (is_array($result)){
                        foreach ($result as $r){
                            $d = substr($r,strlen($r) - $offset,$offset);
                            if ($num == $d){
                                $re_list[] = $num;
                            }
                        }
                    }else{
                        $d = substr($result,strlen($result) - $offset,$offset);
                        if ($num == $d){
                            $re_list[] = $num;
                        }
                    }
                }
            }
        }else{
            $item = "";
            if (!is_array($r_list[$vi_tri_check])){
                $res = $r_list[$vi_tri_check];
                $item = substr($res,strlen($res) - $offset,$offset);
            }
            foreach ($num_list as $num){
                if (is_array($r_list[$vi_tri_check])){
                    $res = $r_list[$vi_tri_check];
                    foreach ($res as $r){
                        $d = substr($r,strlen($r) - $offset,$offset);
                        if ($num == $d){
                            $re_list[] = $num;
                        }
                    }
                }else{
                    if ($num == $item){
                        $re_list[] = $num;
                    }
                }
            }
        }
        return $re_list;
    }

    //hàm lấy vị trị giá trị đầu tiên là số
    private function getFirstIndexOfNumber($arr){
        if (is_array($arr)){
            foreach ($arr as $key=>$value){
                if (ctype_digit($value)){
                    return $key;
                }
            }
        }else{
            return -1;
        }
    }
    //hàm lấy vị trị giá trị đầu tiên là chữ
    private function getFirstIndexOfChar($arr,$index_num){
        if (is_array($arr)){
            foreach ($arr as $key=>$value){
                if (!ctype_digit($value) && $key > $index_num){
                    return $key;
                }
            }
        }else{
            return -1;
        }
    }

    public function getItem($pubDate)
    {
        try {
            $results = DB::table('tbl_result_number')->whereDate('PubDate', '=', $pubDate)->get();
            return $results;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
