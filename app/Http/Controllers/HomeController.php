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
