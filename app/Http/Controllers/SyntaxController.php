<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class SyntaxController extends Controller
{
    public function getAll()
    {
        try {
            $results = DB::table('tbl_syntax')->get();
            return $results;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
