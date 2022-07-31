<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Location;

class LocationController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function index(){
        return view('mis.admin.location');
    }

    public function get_all(){
        $result = Location::all();
        $counter = 1;
        $data = array();
        foreach($result as $val)
            array_push($data,array(
                'no' => $counter++,
                'id' => $val->it_locat_id,
                'name' => $val->it_locat_name
            ));
        return response()->json($data, 200);
    }

    public function set_location(Request $request){
        switch($request->input('action')){
            case 'create': 
                try{
                    $result = Location::insert([
                        'it_locat_id' => $request->input('locat_id'),
                        'it_locat_name' => $request->input('locat_name') 
                    ]);
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
            case 'edit': 
                try{
                    $result = Location::where('it_locat_id',$request->input('locat_id'))
                        ->update(['it_locat_name' => $request->input('locat_name')]);
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
            case 'delete': 
                try{
                    $result = Location::where('it_locat_id',$request->input('locat_id'))
                        ->delete();
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
        }

        return response()->json(array(
            'status' => !empty($result) ? $result : false, 
            'errorMsg' => !empty($errormsg) ? $errormsg : ''
        ), 200);
    }
}
