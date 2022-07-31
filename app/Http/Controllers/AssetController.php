<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\AssetType;

class AssetController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function index_asset_type(){
        return view('mis.admin.asset-type');
    }

    public function get_asstty_all(){
        $data = AssetType::all();
        return response()->json($data, 200);
    }

    public function set_assetty(Request $request){
        switch($request->input('action')){
            case 'insert': 
                try{
                    $result = AssetType::insert(['it_asstty_name' => $request->input('asstty_name')]);
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
            case 'update': 
                try{
                    $result = AssetType::where('it_asstty_id', $request->input('asstty_id'))
                        ->update(['it_asstty_name' => $request->input('asstty_name')]);
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
            case 'delete': 
                try{
                    $result = AssetType::where('it_asstty_id', $request->input('asstty_id'))
                        ->delete();
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
        }

        return response()->json(array(
            'status' => !empty($result) ? $result : false,
            'message' => !empty($errormsg) ? $errormsg : ''
        ), 200);
    }
}
