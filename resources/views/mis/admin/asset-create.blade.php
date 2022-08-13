@extends('layouts.app')
@section('title','จัดการข้อมูลทรัพย์สิน')
@section('content')
<ol class="breadcrumb bg-white">    
    <li class="breadcrumb-item">ทรัพย์สิน</li>
    <li class="breadcrumb-item">@yield('title')</li>
    <li class="breadcrumb-item">เพิ่มทรัพย์สิน</li>
</ol>
<div class="row justify-content-md-center h-100"> 
    <div class="col-8">  
        <div class="card mb-2">
            <div class="card-header">
                <i class="fas fa-plus"></i><span class="ml-2">เพิ่มทรัพย์สิน</span>
            </div>
            <div class="card-body">
                <form method="post" action="{{url('admin/asset/setup')}}">
                    @csrf
                    <input type="hidden" id="action" name="action" value="create">
                    <div class="row m-3">
                        <div class="form-group col-md-4">
                            <label>รหัสทรัพย์สิน : </label>
                            <input type="text" class="form-control @error('asset_number') is-invalid else is-valid @enderror" placeholder="กรอกรหัสทรัพย์สิน..."
                            name="asset_number" value="{{old('asset_number')}}">
                            @error('asset_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>ประเภททรัพย์สิน : </label>
                            <select class="form-control @error('asset_type') is-invalid else is-valid @enderror"
                            name="asset_type">
                                <option value="" disabled selected>กรุณาเลือก...</option>
                                @foreach($asset_type as $type)
                                <option value="{{$type->it_asstty_id}}"
                                @if(old('asset_type') == $type->it_asstty_id) selected @endif>
                                    {{$type->it_asstty_name}}
                                </option>
                                @endforeach
                            </select>
                            @error('asset_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>ประเภทถือครอง : </label>
                            <select class="form-control @error('asset_group') is-invalid else is-valid @enderror"
                            name="asset_group">
                                <option value="" disabled selected>กรุณาเลือก...</option>
                                <option value="ทรัพย์สินบุคคลถือครอง"
                                @if(old('asset_group') == 'ทรัพย์สินบุคคลถือครอง') selected @endif>ทรัพย์สินบุคคลถือครอง</option>
                                <option value="ทรัพย์สินส่วนกลางฝ่าย"
                                @if(old('asset_group') == 'ทรัพย์สินส่วนกลางฝ่าย') selected @endif>ทรัพย์สินส่วนกลางฝ่าย</option>
                            </select>
                            @error('asset_group')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <hr class="pb-3">
                    <div class="row m-3">
                        <div class="form-group col-md-7">
                            <label>ชื่อทรัพย์สิน : </label>
                            <input type="text" class="form-control @error('asset_name') is-invalid else is-valid @enderror" placeholder="กรอกชื่อทรัพย์สิน..."
                            name="asset_name" value="{{old('asset_name')}}">                            
                            @error('asset_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-5">
                            <label>S/N : </label>
                            <input type="text" class="form-control @error('asset_serial') is-invalid else is-valid @enderror" placeholder="กรอก Serial number..."
                            name="asset_serial" value="{{old('asset_serial')}}">
                        </div>                                
                        <div class="form-group col-md-4">
                            <label>ราคา : </label>
                            <input type="number" class="form-control @error('asset_price') is-invalid else is-valid @enderror" placeholder="กรอกราคา..."
                            name="asset_price" value="{{old('asset_price')}}">
                            @error('asset_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Expired Date : </label>
                            <input type="text" class="form-control datepicker @error('asset_expire') is-invalid else is-valid @enderror" placeholder="YYYY-MM-DD"
                            name="asset_expire">
                        </div>                        
                        <div class="form-group col-md-4">
                            <label>Warrantry : </label>
                            <input type="text" class="form-control @error('asset_warrantry') is-invalid else is-valid @enderror"                                    
                            name="asset_warrantry">
                        </div>
                        <div class="form-group col-md-7">
                            <label>หมายเหตุ : </label>
                            <textarea class="form-control @error('asset_remark') is-invalid else is-valid @enderror" rows="5" placeholder="กรอกหมายเหตุ..."
                            name="asset_remark" ></textarea>
                        </div>
                    </div>
                    <hr class="pb-3">
                    <div class="row mb-3 mx-3">
                        <div class="form-group col-md-4">
                            <label>สถานะ : </label>
                            <select class="form-control @error('asset_status') is-invalid else is-valid @enderror"
                            name="asset_status" >
                                <option value="" disabled selected>กรุณาเลือก...</option>
                                <option value="ใช้งาน">ใช้งาน</option>
                                <option value="สำรอง">สำรอง</option>
                                <option value="ส่งซ่อม">ส่งซ่อม</option>
                                <option value="ออกจำหน่าย">ออกจำหน่าย</option>
                                <option value="ยืมใช้งาน">ยืมใช้งาน</option>
                                <option value="ไม่ใช้งาน">ไม่ใช้งาน</option>
                            </select>
                            @error('asset_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <hr class="pb-3">
                    <div class="row justify-content-md-center m-3">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100"><i class="fas fa-save"></i> บันทึก</button>
                        </div>
                        <div class="col-md-2">
                            <button type="reset" class="btn btn-danger w-100"><i class="fas fa-ban"></i> ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        @if (\Session::has('executeFail'))
        Swal.fire({ 
            icon: 'error', 
            title: 'ไม่สามารถบันทึกข้อมูลได้', 
            text: "{!! \Session::get('executeFail') !!}",
            confirmButtonText: 'ตกลง'
        });
        @endif
    });
</script>
@extends('layouts.progress')
@endsection