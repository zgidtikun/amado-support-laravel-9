<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\AssetType;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function index(){
        return view('mis.admin.asset');
    }

    public function index_asset_create(){
        return view('mis.admin.asset-create',[
            'asset_type' => AssetType::all()
        ]);
    }

    public function get_asset_all(){
        $data = DB::table('it_asset as ia')
            ->select(
                'ia.it_asst_id','ia.it_asst_number','ia.it_asst_name','iat.it_asstty_name',
                'ia.it_asst_serial','ia.it_asst_status','ia.it_asst_group',
                DB::raw('0 no')
            )
            ->join('it_asset_type as iat','ia.it_asstty_id','iat.it_asstty_id')
            ->orderBy('ia.created_at','DESC')
            ->get();

        return response()->json($data, 200);
    }

    public function index_asset_detail($id){

        $detail = DB::table('it_asset as ia')
            ->select('ia.it_asst_name','ia.it_asst_status','ia.it_asstty_id',
            'ia.it_asst_group','ia.it_asst_serial','ia.it_asst_price','ia.it_asst_expired',
            'ia.it_asst_warrantry','ia.it_asst_remark','iat.it_asstty_name')
            ->join('it_asset_type as iat','ia.it_asstty_id','iat.it_asstty_id')
            ->where('ia.it_asst_id',$id)
            ->first();
        
        $type = AssetType::all();
       
        $data = array(
            'asst_id' => $id,
            'detail' => $detail,
            'types' => $type,
        );
        
        return view('mis.admin.asset-detail',$data);

    }

    public function setup_asset(Request $request){

        if($request->input('action') == 'create'){
            $request->validate([
                'action' => 'required',
                'asset_number' => 'required|regex:/^[0-9a-zA-Z]+$/u',
                'asset_type' => 'required',
                'asset_group' => 'required',
                'asset_name' => 'required|regex:/^[0-9a-zA-Zก-เ -.\/]+$/u',
                'asset_price' => 'required|numeric|min:1',
                'asset_status' => 'required',
            ]);
        }
        elseif($request->input('action') == 'create'){

        }

        switch($request->input('action')){
            case 'create':
                try{
                    $data = array(
                        'it_asst_number' => $request->input('asset_number'),
                        'it_asst_name' => $request->input('asset_name'),
                        'it_asstty_id' => $request->input('asset_type'),
                        'it_asst_status' => $request->input('asset_status'),
                        'it_asst_group' => $request->input('asset_group'),                        
                        'it_asst_price' => $request->input('asset_price')
                    );

                    if(!empty($request->input('asset_serial')))
                        $data['it_asst_serial'] = $request->input('asset_serial');
                    
                    if(!empty($request->input('asset_remark')))
                        $data['it_asst_remark'] = $request->input('asset_remark');

                    if(!empty($request->input('asset_expire')))
                        $data['it_asst_expired'] = $request->input('asset_expire');

                    if(!empty($request->input('asset_warrantry')))
                        $data['it_asst_warrantry'] = $request->input('asset_warrantry');

                    $result = Asset::create($data);
                    $asst_id = $result->id;
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
            break;
            case 'create':
                try{

                    $asst_id = $request->input('asst_id');

                    $data = array(
                        'it_asst_number' => $request->input('asset_number'),
                        'it_asst_name' => $request->input('asset_name'),
                        'it_asstty_id' => $request->input('asset_type'),
                        'it_asst_status' => $request->input('asset_status'),
                        'it_asst_group' => $request->input('asset_group'),                        
                        'it_asst_price' => $request->input('asset_price')
                    );

                    if(!empty($request->input('asset_serial')))
                        $data['it_asst_serial'] = $request->input('asset_serial');
                    
                    if(!empty($request->input('asset_remark')))
                        $data['it_asst_remark'] = $request->input('asset_remark');

                    if(!empty($request->input('asset_expire')))
                        $data['it_asst_expired'] = $request->input('asset_expire');

                    if(!empty($request->input('asset_warrantry')))
                        $data['it_asst_warrantry'] = $request->input('asset_warrantry');

                    $result = Asset::where('it_asst_id',$asst_id)
                        ->update($data);
                }
                catch(QueryException $e){ $errormsg = $e->getMessage(); }
            break;
        }

        if(!empty($result))
            return redirect('admin/asset/detail/'.$asst_id);
        else
            return redirect()->back()->with('executeFail', $errormsg);

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
                    $result = AssetType::create(['it_asstty_name' => $request->input('asstty_name')]);
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
