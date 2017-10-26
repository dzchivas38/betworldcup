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
    public function getItem($id)
    {
        $results = DB::select('select * from tbl_result_number where Id = :id', ['id' => $id]);
        return $results;
    }
}
