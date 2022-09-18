@extends('layouts.app')
@section('title','จัดการข้อมูลทรัพย์สิน')
@section('content')
<ol class="breadcrumb bg-white">    
    <li class="breadcrumb-item">ทรัพย์สิน</li>
    <li class="breadcrumb-item">@yield('title')</li>
    <li class="breadcrumb-item">รายละเอียดข้อมูลทรัพย์สิน</li>
</ol>
<div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-file-alt"></i><span class="ml-2">รายละเอียดข้อมูลทรัพย์สิน</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 py-3">
                    <h4>รหัสทรัพย์สิน : <span class="text-amado">{{$detail->it_asst_name}}</span></h4>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"><h5>รายละเอียดทรัพย์สิน</h5></div>
                        <div class="col-6">
                            <button type="button" class="btn btn-sm btn-warning float-right"
                            id="btnAssetSetDataUpdate" onclick="aAsset.defaultPageDetail('update')">
                                <i class="fas fa-pen"></i> <span class="ml-2">แก้ไขข้อมูลทรัพย์สิน</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger float-right mr-2"
                            id="btnAssetSetCancel" onclick="aAsset.defaultPageDetail('cancle')">
                                <i class="fas fa-ban"></i> <span class="ml-2">ยกเลิก</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-success float-right mr-2"
                            id="btnAssetSetUpdate" onclick="aAsset.setDetailUpdate()">
                                <i class="fas fa-save"></i> <span class="ml-2">บันทึก</span>
                            </button>
                        </div>
                    </div>
                    <div class="row mb-3 mx-3">
                        <div class="col-12">
                            <p class="mb-1 form-inline">
                                <span id="showAssetName" class="mr-2">ชื่อทรัพย์สิน :</span>
                                <span>{{$detail->it_asst_name}}</span>
                                <input type="text" class="form-control form-control-sm w-50" value=""
                                id="assetName">
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="mb-1 form-inline">
                                <span class="mr-2">สถานะ :</span>
                                <span id="showAssetStatus" >
                                    <i class="fas fa-circle mr-2 text-success"></i>{{$detail->it_asst_status}}
                                </span>
                                <select class="form-control form-control-sm" id="assetStatus">
                                    <option value="" disabled selected>กรุณาเลือก...</option>
                                    <option @if($detail->it_asst_status == 'ใช้งาน') selected @endif value="ใช้งาน">ใช้งาน</option>
                                    <option @if($detail->it_asst_status == 'สำรอง') selected @endif value="สำรอง">สำรอง</option>
                                    <option @if($detail->it_asst_status == 'ส่งซ่อม') selected @endif value="ส่งซ่อม">ส่งซ่อม</option>
                                    <option @if($detail->it_asst_status == 'ออกจำหน่าย') selected @endif value="ออกจำหน่าย">ออกจำหน่าย</option>
                                    <option @if($detail->it_asst_status == 'ยืมใช้งาน') selected @endif value="ยืมใช้งาน">ยืมใช้งาน</option>
                                    <option @if($detail->it_asst_status == 'ไม่ใช้งาน') selected @endif value="ไม่ใช้งาน">ไม่ใช้งาน</option>
                                </select>
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="mb-1 form-inline">
                                <span class="mr-2">ประเภททรัพย์สิน :</span>
                                <span id="showAssetType" >{{$detail->it_asstty_name}}</span>
                                <select class="form-control form-control-sm" id="assetType" >
                                    <option value="" disabled select>กรุณาเลือก...</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->it_asstty_id}}"
                                    @if($detail->it_asstty_id == $type->it_asstty_id) selected @endif>
                                        {{$type->it_asstty_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="mb-1 form-inline">
                                <span class="mr-2">ประเภทถือครอง :</span>
                                <span id="showAssetGroup" >{{$detail->it_asst_group}}</span>
                                <select class="form-control form-control-sm" id="assetGroup" >
                                    <option value="" disabled>กรุณาเลือก...</option>
                                    <option @if($detail->it_asst_group == 'ทรัพย์สินบุคคลถือครอง') selected @endif value="ทรัพย์สินบุคคลถือครอง" selected>ทรัพย์สินบุคคลถือครอง</option>
                                    <option @if($detail->it_asst_group == 'ทรัพย์สินส่วนกลางฝ่าย') selected @endif value="ทรัพย์สินส่วนกลางฝ่าย">ทรัพย์สินส่วนกลางฝ่าย</option>
                                </select>
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="mb-1 form-inline">
                                <span class="mr-2">Serial Number :</span>
                                <span id="showAssetSerial" >{{$detail->it_asst_serial}}</span>
                                <input type="text" class="form-control form-control-sm" value="{{$detail->it_asst_serial}}" id="assetSerial" >
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="mb-1 form-inline">
                                <span class="mr-2">ราคา :</span>
                                <span id="showAssetPrice" >{{$detail->it_asst_price}}</span>
                                <input type="number" class="form-control form-control-sm" value="{{$detail->it_asst_price}}"
                                id="assetPrice" >
                                <span class="ml-1">บาท</span>
                            </p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <p class="mb-1 form-inline">
                                <span class="mr-2">Expired Date :</span>
                                <span id="showAssetExpire" >{{$detail->it_asst_expired}}</span>
                                <input type="text" class="form-control form-control-sm"
                                id="assetExpire" value="{{$detail->it_asst_expired}}">
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="mb-1 form-inline">
                                <span class="mr-2">Warrantry :</span>
                                <span id="showAssetWarrantry" >{{$detail->it_asst_warrantry}}</span>
                                <input type="text" class="form-control form-control-sm"
                                id="assetWarrantry" value="{{$detail->it_asst_warrantry}}">
                            </p>
                        </div>
                        <div class="col-12">
                            <p class="mb-1">
                                <span class="mr-2">หมายเหตุ :</span>
                                <span id="showAssetRemark" >{{$detail->it_asst_remark}}</span>
                                <textarea class="form-control form-control-sm" rows="5" placeholder="กรอกหมายเหตุ..."
                                id="assetRemark" value="{{$detail->it_asst_remark}}">
                                </textarea>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        aAsset.setDataAssetDetail({
            asset_id: {{$asst_id}},
            asset_name: '{{$detail->it_asst_id}}',
            asset_type: '{{$detail->it_asstty_id}}',
            asset_status: '{{$detail->it_asst_status}}',
            asset_group: '{{$detail->it_asst_group}}',
            asset_serial: '{{$detail->it_asst_serial}}',
            asset_price: '{{$detail->it_asst_price}}',
            asset_expired: '{{$detail->it_asst_expired}}',
            asset_warrantry: '{{$detail->it_asst_warrantry}}',
            asset_remark: '{{$detail->it_asst_remark}}',
        });
        aAsset.defaultPageDetail('defalut');
    });
</script>
@extends('layouts.progress')
@endsection