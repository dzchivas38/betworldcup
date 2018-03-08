<?php

namespace App\Http\Controllers;

use App\Models\HashMap;
use App\Models\String;
use App\Models\Syntax;
use Illuminate\Http\Request;
use App\Http\Requests;
use DOMDocument;
use DateTime;
use DB;


class HomeController extends Controller
{
    private $temp = array();

    /**
     * @return mixed
     */
    public function getTemp()
    {
        return $this->temp;
    }

    public function test()
    {
        $str = "De 01.10.17.71x100n. 56.65x200n. 02.20.26.62.00x100n. de 67.76x400n. 09.90x200n. 25.52x300n. 08.80x100n. 37.73x200n. 58.85x900n. 33x200n. 57.75x100n. 55.77x100n.tin 5";
        $str2 = "01.10.17.71x100n.";
        $arr1 = array("de", "lo");
        $syntax = new Syntax();
        $syntaxList = $syntax->getAll();
        $col = collect($syntaxList);
        $this->dequy($str);
    }

    private function dequy($str)
    {
        $str = (is_string($str)) ? $str : "";
        $str = trim($str);

        $arr1 = array("a", "lo", "De");// mảng cú pháp
        $map = new HashMap($arr1);
        if (strlen($str) == 0) {
            return 0;
        } else {
            echo "---------------str>0---------------------";
            $str1 = new String($str);
            $first = $str1->firstIndexOf(' ');
            $strCheck = $str1->subString($first);
            $checked = $map->hasLike($strCheck);
            //Nếu đoạn string sau space đầu tiên có trong mảng cú pháp
            if ($checked) {
                if (count($this->temp) == 0) {
                    $this->temp = array($strCheck => $str1->get());
                    $this->dequy($str1->get());
                } else {

                }

            } else {
                if ($str1->get() !== str_replace(' ', '', $str1->get())) {
                    //Have whitespace
                    $this->dequy($str1->get());
                } else {
                    //dont have whitespace
                    return 0;
                }

            }
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
