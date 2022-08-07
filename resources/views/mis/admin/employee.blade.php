@extends('layouts.app')
@section('title','จัดการข้อมูลพนักงาน')
@section('content')
<ol class="breadcrumb bg-white">    
    <li class="breadcrumb-item">ข้อมูลหลัก</li>
    <li class="breadcrumb-item">@yield('title')</li>
</ol>
<div>    
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-list-ul"></i><span class="ml-2">รายการข้อมูลพนักงาน</span>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-success float-right" 
                    onclick="aEmployee.action('create','')">
                        <i class="fas fa-plus"></i>
                        <span class="ml-2">เพิ่มพนักงาน</span>
                    </button>
                </div>
            </div>
            <hr>
            <table class="table table-sm table-hover" id="tblEmp">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">รหัสพนักงาน</th>
                        <th scope="col">ชื่อ-สกุล</th>
                        <th scope="col">ชื่อเล่น</th>
                        <th scope="col">เบอร์โทร</th>
                        <th scope="col">อีเมล์</th>                            
                        <th scope="col">ฝ่าย</th>
                        <th scope="col">Status</th>
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
