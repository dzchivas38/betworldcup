<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ActiontypeController extends Controller
{
    public function getAll()
    {
        try{
            $data = DB::select('select * from tbl_actiontype');
            return $data;
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
