@extends('layouts.app')
@section('title','จัดการข้อมูลประเภททรัพย์สิน')
@section('content')
<ol class="breadcrumb bg-white">    
    <li class="breadcrumb-item">ข้อมูลหลัก</li>
    <li class="breadcrumb-item">@yield('title')</li>
</ol>
<div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-list-ul"></i><span class="ml-2">รายการข้อมูลประเภททรัพย์สิน</span>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-success float-right" 
                    onclick="aAssetType.action('insert')">
                        <i class="fas fa-plus"></i>
                        <span class="ml-2">เพิ่มประเภททรัพย์สิน</span>
                    </button>
                </div>
            </div>
            <hr>
            <table class="table table-sm table-bordered table-hover w-100" id="tblAsstty">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" width="10%">#</th>
                        <th scope="col" class="text-center">ประเภททรัพย์สิน</th>
                        <th scope="col" class="text-center" width="10%"><i class="fas fa-ellipsis-h"></i></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-assettype">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-header-title">
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="">
                    @csrf
                    <div class="row justify-content-md-center m-3 pb-3">
                        <div class="form-group col-md-6">
                            <label for="uname">ชื่อประเภททรัพย์สิน : </label>
                            <input type="text" class="form-control" placeholder="กรอกชื่อประเภททรัพย์สิน..."
                            name="asstty_name" id="asstty_name">
                            <div class="invalid-feedback">กรุณากรอกชื่อประเภททรัพย์สิน..!</div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center m-3">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-success w-100" 
                            onclick="aAssetType.actuate()">
                                <i class="fas fa-save"></i> บันทึก
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger w-100" data-dismiss="modal">
                                <i class="fas fa-ban"></i> ยกเลิก
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@extends('layouts.progress')
@endsection