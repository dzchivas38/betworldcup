<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DOMDocument;
use DateTime;
use DB;


class HomeController extends Controller
{
    public function getNumberResultEveryDay()
    {

    }
    public function getItem($pubDate)
    {
        try {
            $results = DB::table('tbl_result_number')->whereDate('PubDate', '=',$pubDate)->get();
            return $results;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
