@extends('layouts.app')
@section('title','จัดการข้อมูล Location')
@section('content')
<ol class="breadcrumb bg-white">    
    <li class="breadcrumb-item">ข้อมูลหลัก</li>
    <li class="breadcrumb-item">@yield('title')</li>
</ol>
<div>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list-ul"></i><span class="ml-2">รายการข้อมูล Location</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-success float-right"
                        onclick="alocation.actionLocation('create','','')"
                    >
                        <i class="fas fa-plus"></i>
                        <span class="ml-2">เพิ่ม Location</span>
                    </button>
                </div>  
            </div>   
            <hr>           
            <table class="table table-sm table-bordered table-hover w-100" id="tblLocat">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">รหัส Location</th>
                        <th scope="col" class="text-center">คำอธิบาย Location</th>
                        <th scope="col" class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>        
</div>
<div class="modal fade" id="modal-location">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-header-title">
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row m-3 pb-3">
                        <div class="form-group col-md-4">
                            <label for="uname">รหัส Location : </label>
                            <input type="text" class="form-control" placeholder="กรอกรหัส Location..."
                            id="locat_id" name="locat_id">                            
                            <div id="lc_id_valid" class="valid-feedback">กรุณากรอกรหัส Location</div>
                        </div>
                        <div class="invalid-feedback">กรุณากรอกรหัส Location...!</div>
                        <div class="form-group col-md-8">
                            <label for="uname">คำอธิบาย Location : </label>
                            <input type="text" class="form-control" placeholder="กรอกคำอธิบาย Location..."
                            id="locat_name" name="locat_name">
                            <div id="lc_name_valid" class="valid-feedback">กรุณากรอกคำอธิบาย Location</div>
                        </div>
                        <div class="invalid-feedback">กรุณากรอกคำอธิบาย Location...!</div>
                    </div>
                    <div class="row justify-content-md-center m-3">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-success w-100"
                            onclick="alocation.save()">
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

