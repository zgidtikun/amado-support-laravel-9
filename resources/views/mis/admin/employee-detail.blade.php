@extends('layouts.app')
@section('title','จัดการข้อมูลพนักงาน')
@section('content')
<ol class="breadcrumb bg-white">    
    <li class="breadcrumb-item">ข้อมูลหลัก</li>
    <li class="breadcrumb-item">@yield('title')</li>
    <li class="breadcrumb-item">{{ $navigate }}</li>
</ol>

<div class="row justify-content-md-center h-100"> 
    <div class="col-8">  
        <div class="card mb-3">
            <div class="card-header">
                @if($mode == 'create') <i class="fas fa-user-plus"></i>
                @elseif($mode == 'update') <i class="fas fa-user-cog"></i>
                @endif
                <span class="ml-2">{{ $navigate }}</span>
            </div>
            <div class="cart-body">
                <form method="post" id="formEmpDetail" action="{{ url('admin/employee/setup') }}">
                    @csrf
                    <input type="hidden" id="action" name="action" value="{{ $mode }}">
                    <div class="row m-3">
                        <div class="form-group col-md-3">
                            <label>รหัสพนักงาน : </label>
                            <input type="text" class="form-control form-control-sm @error('emp_id') is-invalid @enderror"                         
                            id="emp_id" name="emp_id" placeholder="กรอกรหัสพนักงาน..."
                            @if(!empty(old('emp_id')))
                            value="{{ old('emp_id') }}"
                            @elseif(!empty($person->it_emp_id))
                            value="{{ $person->it_emp_id }}"
                            @endif
                            @if($mode == 'update') readonly @endif
                            >
                            @error('emp_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>ฝ่าย : </label>
                            <select class="form-control form-control-sm"                         
                            id="dept_id" name="dept_id"
                            >
                            @foreach($department as $dept)
                            <option value="{{ $dept->it_dept_id }}" 
                            @if(!empty(old('dept_id')) && old('dept_id') == $dept->it_dept_id)
                            selected
                            @elseif(!empty($person->it_dept_id) && $person->it_dept_id == $dept->it_dept_id)
                            selected
                            @endif >{{ $dept->it_dept_name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>สถานะ : </label>
                            <select class="form-control form-control-sm"                         
                            id="emp_active" name="emp_active"
                            >
                                <option value="active" 
                                @if(!empty(old('emp_active')) && old('emp_active') == 'active')
                                selected
                                @elseif(!empty($person->it_emp_active) && $person->it_emp_active == 'active')
                                selected
                                @endif >Active</option>
                                <option value="inactive"
                                @if(!empty(old('emp_active')) && old('emp_active') == 'inactive')
                                selected
                                @elseif(!empty($person->it_emp_active) && $person->it_emp_active == 'inactive')
                                selected
                                @endif >Inactive</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <div class="form-group col-md-4">
                            <label>ชื่อ : </label>
                            <input type="text" class="form-control form-control-sm @error('emp_name') is-invalid @enderror"                         
                            id="emp_name" name="emp_name" placeholder="กรอกชื่อ..."
                            @if(!empty(old('emp_name')))
                            value="{{ old('emp_name') }}"
                            @elseif(!empty($person->it_emp_name))
                            value="{{ $person->it_emp_name }}"
                            @endif
                            >
                            @error('emp_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-5">
                            <label>นามสกุล : </label>
                            <input type="text" class="form-control form-control-sm @error('emp_surname') is-invalid @enderror"                         
                            id="emp_surname" name="emp_surname" placeholder="กรอกนามสกุล..."
                            @if(!empty(old('emp_surname')))
                            value="{{ old('emp_surname') }}"
                            @elseif(!empty($person->it_emp_surname))
                            value="{{ $person->it_emp_surname }}"
                            @endif>
                            @error('emp_surname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>ชื่อเล่น : </label>
                            <input type="text" class="form-control form-control-sm @error('emp_nickname') is-invalid @enderror"                         
                            id="emp_nickname" name="emp_nickname" placeholder="กรอกชื่อเล่น..."
                            @if(!empty(old('emp_nickname')))
                            value="{{ old('emp_nickname') }}"
                            @elseif(!empty($person->it_emp_nickname))
                            value="{{ $person->it_emp_nickname }}"
                            @endif>
                            @error('emp_nickname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>เบอร์โทรศัพท์ : </label>
                            <input type="text" class="form-control form-control-sm @error('emp_tel') is-invalid @enderror"                         
                            id="emp_tel" name="emp_tel" placeholder="กรอกเบอร์โทรศัพท์..."
                            @if(!empty(old('emp_tel')))
                            value="{{ old('emp_tel') }}"
                            @elseif(!empty($person->it_emp_tel))
                            value="{{ $person->it_emp_tel }}"
                            @endif>
                            @error('emp_tel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>E-Mail : </label>
                            <input type="email" class="form-control form-control-sm @error('emp_email_second') is-invalid @enderror"                         
                            id="emp_email" name="emp_email" placeholder="กรอก E-Mail..."
                            @if(!empty(old('emp_email')))
                            value="{{ old('emp_email') }}"
                            @elseif(!empty($person->it_emp_email))
                            value="{{ $person->it_emp_email }}"
                            @endif>
                            @error('emp_email_second')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row justify-content-md-center m-3">  
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-save"></i> บันทึก
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger w-100" d
                            onclick="aEmployee.resetFormDetail('{{ $mode }}')">
                                <i class="fas fa-ban"></i> ยกเลิก
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-warning" href="{{ url('admin/employee') }}" role="button">
                                <i class="fas fa-arrow-alt-circle-left"></i> ย้อนกลับ
                            </a>
                        </div>
                    </div>
                </form>
            </div>                 
        </div>   
        @if($mode == 'update')
        <div class="card">            
            <div class="card-header">
                <i class="fas fa-key"></i>
                <span class="ml-2">ข้อมูลรหัสเข้าสู่ระบบ</span>
            </div>
            <table class="table table-sm table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" width="10%">#</th>
                        <th scope="col" class="text-center">Username</th>
                        <th scope="col" class="text-center" width="15%">Role</th>
                        <th scope="col" class="text-center" width="15%"><i class="fas fa-ellipsis-h"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key=>$user)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ $user->username }}</td>
                        <td class="text-center">{{ $user->rule }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm"
                            onclick="operator.resetPassword('{{ $user->username }}')">
                                <i class="fas fa-key"></i> Reset Password
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- <div class="card-footer"></div> -->
        </div>
        @endif
    </div>           
</div>
<script>
    $(document).ready(function(){
        @if (\Session::has('executeFail'))
        Swal.fire({ 
            icon: 'error', 
            title: 'ไม่สามารถบันทึกข้อมูลได้', 
            text: '{!! \Session::get('loginFail') !!}',
            confirmButtonText: 'ตกลง'
        });
        @endif
        @if($mode == 'update')
        aEmployee.setPersonData({
            emp_id: '{{ $person->it_emp_id }}',
            emp_name: '{{ $person->it_emp_name }}',
            emp_surname: '{{ $person->it_emp_surname }}',
            emp_nickname: '{{ $person->it_emp_nickname }}',
            emp_tel: '{{ $person->it_emp_tel }}',
            emp_email: '{{ $person->it_emp_email }}',
            emp_active: '{{ $person->it_emp_active }}',
            dept_id: '{{ $person->it_dept_id }}',
        });
        @endif
    });
</script>
@extends('layouts.progress')
@endsection