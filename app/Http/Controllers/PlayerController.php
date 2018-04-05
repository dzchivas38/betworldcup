<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class PlayerController extends Controller
{
    public function getAll()
    {
        $users = DB::select('select * from tbl_player');
        return $users;
    }
    public function getCashOutByPlayerId($playerId){
        try{
            $player_join_cash_out = DB::table('tbl_player')
                ->join('tbl_cashout', 'tbl_player.Id', '=', 'tbl_cashout.PlayerId')
                ->join('tbl_actiontype', 'tbl_cashout.ActionTypeId', '=', 'tbl_actiontype.Id')
                ->select('tbl_player.Id', 'tbl_player.Name',
                    'tbl_cashout.InCoin','tbl_cashout.OutCoin','tbl_actiontype.Name',
                    'tbl_actiontype.ActionTypeLevel','tbl_actiontype.Code','tbl_actiontype.Unit',
                    'tbl_actiontype.IsFirstChirld')
                ->where('tbl_player.Id', '=', $playerId)
                ->get();
            return $player_join_cash_out;
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
