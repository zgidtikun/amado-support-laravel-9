<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DepartmentController;
use App\Models\Employee;
use App\Models\User;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(){
        return view('mis.admin.employee');
    }

    public function get_all()
    {
        $data = DB::table('it_employee as ie')
            ->select('ie.it_emp_id','ie.it_emp_nickname','ie.it_emp_tel','ie.it_emp_email',
            'ie.it_emp_active','id.it_dept_name',
            DB::raw("CONCAT(ie.it_emp_name,' ',ie.it_emp_surname) it_emp_fullname"),
            DB::raw("0 no"))
            ->join('it_department as id','ie.it_dept_id','id.it_dept_id')
            ->orderBy('ie.it_emp_id')
            ->get();

        return response()->json($data, 200);
    }

    public function detail_employee($action,$id = null)
    {

        $obj_dept = new DepartmentController();

        $data = [
            'mode' => $action,
            'navigate' => $action == 'create' ? 'เพิ่มข้อมูลพนักงาน' : 'รายละเอียดข้อมูลพนักงาน',
            'department' => $obj_dept->get_all('get')
        ];

        if($action == 'update')
        {
            $person = Employee::where('it_emp_id',$id)->first();
            $users = User::where('it_emp_id',$id)->get();

            $data['person'] = $person;
            $data['users'] = $users;
        }

        return view('mis.admin.employee-detail',$data);
    }

    public function set_employee(Request $request)
    {

        $request->validate([
            'emp_id' => 'required',
            'dept_id' => 'required',
            'emp_active' => 'required',
            'emp_name' => 'required',
            'emp_surname' => 'required',
        ]);

        $result = null;

        switch($request->input('action')){
            case 'create': 
                try{
                    $result = Employee::create([
                        'it_emp_id' => $request->input('emp_id'),
                        'it_emp_name' => $request->input('emp_name'),
                        'it_emp_surname' => $request->input('emp_surname'),
                        'it_emp_nickname' => $request->input('emp_nickname'),
                        'it_emp_tel' => $request->input('emp_tel'),
                        'it_emp_email' => $request->input('emp_email'),
                        'it_emp_active' => $request->input('emp_active'),
                        'it_dept_id' => $request->input('dept_id'),
                    ]);

                    if($result){
                        User::create([
                            'username' => $request->input('emp_id'),
                            'password' => Hash::make('Amado.1234'),
                            'rule' => 'user',
                            'name' => $request->input('emp_name').' '.$request->input('emp_surname'),
                            'it_emp_id' => $request->input('emp_id')
                        ]);
                    }

                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
            case 'update': 
                try{
                    $result = Employee::where('it_emp_id', $request->input('emp_id'))
                        ->update([
                            'it_emp_name' => $request->input('emp_name'),
                            'it_emp_surname' => $request->input('emp_surname'),
                            'it_emp_nickname' => $request->input('emp_nickname'),
                            'it_emp_tel' => $request->input('emp_tel'),
                            'it_emp_email' => $request->input('emp_email'),
                            'it_emp_active' => $request->input('emp_active'),
                            'it_dept_id' => $request->input('dept_id'),
                        ]);
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
                break;
        }

        if($result)
            return redirect('admin/employee/action/update/'.$request->input('emp_id'));
        else
            return redirect()->back()->with('executeFail', $errormsg);
        
    }
}
