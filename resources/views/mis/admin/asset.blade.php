@extends('layouts.app')
@section('title','จัดการข้อมูลทรัพย์สิน')
@section('content')
<ol class="breadcrumb bg-white">    
    <li class="breadcrumb-item">ทรัพย์สิน</li>
    <li class="breadcrumb-item">@yield('title')</li>
</ol>
<div>
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-list-ul"></i><span class="ml-2">รายการข้อมูลทรัพย์สิน</span>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-success float-right" 
                    onclick="window.open('/admin/asset/create','_self')"></i>
                        <span class="ml-2">เพิ่มทรัพย์สิน</span>
                    </button>
                </div>
            </div>
            <hr>
            <table class="table table-sm table-hover table-striped" id="tblAsst">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">รหัสทรัพย์สิน</th>
                        <th scope="col">ประเภททรัพย์สิน</th>
                        <th scope="col">ชื่อทรัพย์สิน</th>
                        <th scope="col">S/N</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">ประเภทถือครอง</th>
                        <th scope="col" class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                    </tr>
                </thead>
                <tbody>                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@extends('layouts.progress')
@endsection