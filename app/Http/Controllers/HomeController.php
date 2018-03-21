<?php

namespace App\Http\Controllers;

use App\Models\HashMap;
use App\Models\Messenger;
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


    public function test()
    {
        $str = "De 01.10.17.71x100n. 56.65200n. 02.20.26.62.00x100n. de 67.76400n. 09.90x200n. 25.52x300n. 08.80x100n. 37.73x200n. 58.85x900n. Lo 33x200n. ";
        $t = new Messenger($str);
        $syntax = new Syntax();
        $list = $syntax->getAll();
        $listName = array_map(function($item) {
            return $item->Name;
        }, $list);
        $e = $t->getArrayTobeConvertFromMsg($listName);
        dd($e);
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
