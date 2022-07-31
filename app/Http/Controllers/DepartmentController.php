<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function index(){
        return view('mis.admin.department');
    }

    public function get_all(){
        $data = Department::all();
        return response()->json($data, 200);
    }

    public function set_department(Request $request){
        switch($request->input('action')){
            case 'insert': 
                try{
                    $result = Department::insert(['it_dept_name' => $request->input('dept_name')]);
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
            case 'update': 
                try{
                    $result = Department::where('it_dept_id', $request->input('dept_id'))
                        ->update(['it_dept_name' => $request->input('dept_name')]);
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
            case 'delete': 
                try{
                    $result = Department::where('it_dept_id', $request->input('dept_id'))
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
