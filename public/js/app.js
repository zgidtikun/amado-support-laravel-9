// import $ from "jquery";

$(document).ready(function(){
    defPage.setDefaultPage(window.location.pathname);   
    
    $('#menu-a-mis-main').click(function(){
        $('#menu-a-mis-infosetup').toggleClass('show');
    });
    $('#menu-a-mis-asset').click(function(){
        $('#menu-a-mis-asset-setup').toggleClass('show');
    });
});

const defPage = {
    mainPage: [
        '/admin/location', '/admin/asset-type', '/admin/department', '/admin/employee',
    ],
    setDefaultPage: function(url){
        console.log(url);
        switch(url){
            case '/admin/location': alocation.initDataTable(); break;
            case '/admin/asset-type': aAssetType.initDataTable(); break;
            case '/admin/department': aDepartment.initDataTable(); break;
            case '/admin/employee': aEmployee.initDataTable(); break;
        }
    },
};

const swalInit = {
    initBootstrap: function(){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });
        return swalWithBootstrapButtons;
    }
}

const operator = {
    returnResponse: {},
    baseUrl: window.location.origin,
    resetPassword: function(user){

        let dataPost = { username: user },
            link = this.baseUrl+'/reset-password',
            responseMsg;

        let response = this.execute(link,dataPost);
        let swalWithBootstrapButtons = swalInit.initBootstrap();
        console.log(response);
        if(!jQuery.isEmptyObject(response)){
            if(response.result == 'success')          
                responseMsg = 'Reset Password Complete.';
            else if(response.result == 'error') 
                responseMsg = 'Reset Password Fail!';

            swalWithBootstrapButtons.fire({ 
                icon: response.result, 
                title: responseMsg, 
                text: response.message,
                confirmButtonText: 'ตกลง'
            }).then((result) => {  
                $('#modal-progress').modal('hide');  
                if(response.result == 'success')    
                    $('#tblDept').DataTable().ajax.reload();  
                else                  
                    $('#modal-location').modal('show');
            });
        }

    },
    getDetail: function(link,dataPost){

    },
    execute: function(link,dataPost){
        $.ajax({
            method: 'post',
            url: link,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            data: dataPost,
            async: true,
            success: function(response){       
                if(response.status){ 
                    this.returnResponse = { result: 'success' };
                }
                else{
                    this.returnResponse = {
                        result: 'error',
                        message: 'response.message'
                    }
                }
            },
            error: function(jqXhr, textStatus, errorMessage){
                this.returnResponse = {
                    result: 'error',
                    message: 'Error : '+errorMessage
                }
            }
        });
        return this.returnResponse;
    }
}

const aEmployee = {
    person: null,
    initDataTable: function(){
        let table = $('#tblEmp').DataTable({
            ajax: {
                method: 'get',
                url: 'employee/all',
                dataType: 'json',
                dataSrc: ''
            },
            pageLength: 25,
            procressing: true,
            info: true,
            lengthChange: true,
            columns: [
                { data: 'no' },
                { data: 'it_emp_id' },
                { data: 'it_emp_fullname' },
                { 
                    data: 'it_emp_nickname', render: function(data, type, row, meta){
                        if(data == '' || data === null) return 'ไม่มีข้อมูล';
                        else return data;
                    } 
                },
                { 
                    data: 'it_emp_tel', render: function(data, type, row, meta){
                        if(data == '' || data === null) return 'ไม่มีข้อมูล';
                        else return data;
                    }
                },
                { 
                    data: 'it_emp_email', render: function(data, type, row, meta){
                        if(data == '' || data === null) return 'ไม่มีข้อมูล';
                        else return data;
                    }
                },
                { data: 'it_dept_name' },
                { data: 'it_emp_active' },
                {
                    data: 'it_emp_id', render: function(data, type, row, meta){
                        let param = "'update','"+data+"'";
                        let content = '<button type="button" class="btn btn-warning mr-2"';
                        content += 'onclick="aEmployee.action('+param+')"><i class="fas fa-pen"></i></button>';
                        return content;
                    }
                }
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'justify-content-center',
                    searchable: false,
                    orderable: false
                },
                { targets: 1, className: 'justify-content-center' },
                { targets: 2, className: 'justify-content-center' },
                { targets: 3, className: 'justify-content-center' },
                { targets: 4, className: 'justify-content-center' },
                { targets: 5, className: 'justify-content-center' },
                { targets: 6, className: 'justify-content-center' },
                { 
                    targets: 7, 
                    className: 'justify-content-center',
                    searchable: false,
                    orderable: false 
                },
                {
                    targets: 8,
                    className: 'text-center',
                    searchable: false,
                    orderable: false
                }
            ],
            order: [[1, 'asc']]
        });

        table.on('order.dt search.dt', function () {
            let i = 1;
    
            table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    },
    action: function(ac,id){
        let url = 'employee/action/'+ac+'/'+id;
        window.location = url;
    },
    setPersonData: function(data) {
        this.person = data;
    },
    resetFormDetail: function(mode){
        if(mode == 'create')
            $('#formEmpDetail')[0].reset();
        else{
            $('#emp_id').val(this.person.emp_id);
            $('#emp_name').val(this.person.emp_name);
            $('#emp_surname').val(this.person.emp_surname);
            $('#emp_nickname').val(this.person.emp_nickname);
            $('#emp_tel').val(this.person.emp_tel);
            $('#emp_email').val(this.person.emp_email);
            $('#emp_active').val(this.person.emp_active);
            $('#dept_id').val(this.person.dept_id);
        }
    }
};

const aDepartment = {
    form: {
        action: 'insert',
        dept_id: '',
        dept_name: ''
    },
    initDataTable: function(){
        let table = $('#tblDept').DataTable({
            ajax: {
                method: 'get',
                url: 'department/all',
                dataType: 'json',
                dataSrc: ''
            },
            pageLength: 25,
            procressing: true,
            info: true,
            lengthChange: true,
            columns: [
                { data: 'it_dept_id' },
                { data: 'it_dept_name' },
                {
                    data: 'it_asstty_id', render: function(data, type, row, meta){
                        let param = "'"+row.it_dept_id+"','"+row.it_dept_name+"'";
                        let content = '<button type="button" class="btn btn-warning mr-2"';
                        content += 'onclick="aDepartment.action(\'update\','+param+')"><i class="fas fa-pen"></i></button>';
                        content += '<button type="button" class="btn btn-danger ';
                        content += 'onclick="aDepartment.action(\'delete\','+param+')"><i class="fas fa-minus"></i></button>';
                        return content;
                    }
                }
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'text-center justify-content-center',
                    searchable: false,
                    orderable: false
                },
                { targets: 1, className: 'justify-content-center' },
                {
                    targets: 2,
                    className: 'text-center',
                    searchable: false,
                    orderable: false
                }
            ],
            order: [[1, 'asc']]
        });

        table.on('order.dt search.dt', function () {
            let i = 1;
    
            table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    },
    action: function(action,id,name){  
        this.form.action = action;
        $('#dept_name').removeClass('is-valid');
        $('#dept_name').removeClass('is-invalid');
        if(action != 'delete'){
            if(action == 'insert'){
                this.form.dept_id = this.form.dept_name = '';
                $('#dept_name').val('');
                $('#modal-header-title').text('เพิ่มประเภททรัพย์สิน');
            }
            else{
                this.form.dept_id = id;
                this.form.dept_name = name;
                $('#dept_name').val(name);
                $('#modal-header-title').text('แก้ไขประเภททรัพย์สิน');
            }
            $('#modal-department').modal('show');
        }
        else{
            this.form.dept_id = id
            let swalWithBootstrapButtons = swalInit.initBootstrap();
            swalWithBootstrapButtons.fire({
                title: 'ยืนยันการลบข้อมูล',
                text: "ต้องการลบ "+name+" หรือไม่",
                showCancelButton: true,
                confirmButtonText: 'ลบข้อมูล',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if(result.isConfirmed)
                    this.actuate();
            });
        }
    },
    actuate: function(){
        
        if(this.form.action != 'delete')
            if(!this.valid())
                return;

        let swalWithBootstrapButtons = swalInit.initBootstrap();
        let postData = { action: this.form.action };

        if(this.form.action == 'update'){
            postData.dept_id = this.form.dept_id;
            postData.dept_name = $('#dept_name').val();
        }
        else if(this.form.action == 'insert')
            postData.dept_name = $('#dept_name').val();
        else postData.dept_id = this.form.dept_id;

        if(this.form.action != 'delete')
            $('#modal-department').modal('hide');

        $('#modal-progress').modal('show');         
        let response,
            responseMsg;
        
        response = operator.execute('department/setup',postData);

        if(response.result == 'success')          
            responseMsg = (postData.action == 'delete' ? 'ลบข้อมูลเรียบร้อยแล้ว' : 'บันทึกข้อมูลเรียบร้อยแล้ว');
        else if(response.result == 'error') 
            responseMsg = (postData.action == 'delete' ? 'ไม่สามารถลบข้อมูลได้' : 'ไม่สามารถบันทึกข้อมูลได้');

        swalWithBootstrapButtons.fire({ 
            icon: response.result, 
            title: responseMsg, 
            text: response.message,
            confirmButtonText: 'ตกลง'
        }).then((result) => {  
            $('#modal-progress').modal('hide');  
            if(response.result == 'success')    
                $('#tblDept').DataTable().ajax.reload();  
            else                  
                $('#modal-location').modal('show');
        });

    },
    valid: function(){
        if($('#dept_name').val() == ''){
            $('#dept_name').removeClass('is-valid');
            $('#dept_name').addClass('is-invalid');
            return false
        }
        else{
            $('#dept_name').removeClass('is-invalid');
            $('#dept_name').addClass('is-valid');
            return true;
        }
    }
};

const aAssetType = {
    form: {
        action: 'insert',
        asstty_id: '',
        asstty_name: ''
    },
    initDataTable: function(){
        let table = $('#tblAsstty').DataTable({
            ajax: {
                method: 'get',
                url: 'asset-type/all',
                dataType: 'json',
                dataSrc: ''
            },
            pageLength: 25,
            procressing: true,
            info: true,
            lengthChange: true,
            columns: [
                { data: 'it_asstty_id' },
                { data: 'it_asstty_name' },
                {
                    data: 'it_asstty_id', render: function(data, type, row, meta){
                        let param = "'"+row.it_asstty_id+"','"+row.it_asstty_name+"'";
                        let content = '<button type="button" class="btn btn-warning btn-sm mr-2"';
                        content += 'onclick="aAssetType.action(\'update\','+param+')"><i class="fas fa-pen"></i></button>';
                        content += '<button type="button" class="btn btn-danger btn-sm"';
                        content += 'onclick="aAssetType.action(\'delete\','+param+')"><i class="fas fa-minus"></i></button>';
                        return content;
                    }
                }
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'text-center justify-content-center',
                    searchable: false,
                    orderable: false
                },
                { targets: 1, className: 'justify-content-center' },
                {
                    targets: 2,
                    className: 'text-center',
                    searchable: false,
                    orderable: false
                }
            ],
            order: [[1, 'asc']]
        });

        table.on('order.dt search.dt', function () {
            let i = 1;
    
            table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    },
    action: function(action,id,name){  
        this.form.action = action;
        $('#asstty_name').removeClass('is-valid');
        $('#asstty_name').removeClass('is-invalid');
        if(action != 'delete'){
            if(action == 'insert'){
                this.form.asstty_id = this.form.asstty_name = '';
                $('#asstty_name').val('');
                $('#modal-header-title').text('เพิ่มประเภททรัพย์สิน');
            }
            else{
                this.form.asstty_id = id;
                this.form.asstty_name = name;
                $('#asstty_name').val(name);
                $('#modal-header-title').text('แก้ไขประเภททรัพย์สิน');
            }
            $('#modal-assettype').modal('show');
        }
        else{
            this.form.asstty_id = id
            let swalWithBootstrapButtons = swalInit.initBootstrap();
            swalWithBootstrapButtons.fire({
                title: 'ยืนยันการลบข้อมูล',
                text: "ต้องการลบ "+name+" หรือไม่",
                showCancelButton: true,
                confirmButtonText: 'ลบข้อมูล',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if(result.isConfirmed)
                    this.actuate();
            });
        }
    },
    actuate: function(){
        
        if(this.form.action != 'delete')
            if(!this.valid())
                return;

        let swalWithBootstrapButtons = swalInit.initBootstrap();
        let postData = { action: this.form.action };

        if(this.form.action == 'update'){
            postData.asstty_id = this.form.asstty_id;
            postData.asstty_name = $('#asstty_name').val();
        }
        else if(this.form.action == 'insert')
            postData.asstty_name = $('#asstty_name').val();
        else postData.asstty_id = this.form.asstty_id;

        if(this.form.action != 'delete')
            $('#modal-assettype').modal('hide');

        $('#modal-progress').modal('show');
        let response,
            responseMsg;
        
        response = operator.execute('asset-type/setup',postData);

        if(response.result == 'success')          
            responseMsg = (postData.action == 'delete' ? 'ลบข้อมูลเรียบร้อยแล้ว' : 'บันทึกข้อมูลเรียบร้อยแล้ว');
        else if(response.result == 'error') 
            responseMsg = (postData.action == 'delete' ? 'ไม่สามารถลบข้อมูลได้' : 'ไม่สามารถบันทึกข้อมูลได้');

        swalWithBootstrapButtons.fire({ 
            icon: response.result, 
            title: responseMsg, 
            text: response.message,
            confirmButtonText: 'ตกลง'
        }).then((result) => {  
            $('#modal-progress').modal('hide');  
            if(response.result == 'success')    
                $('#tblAsstty').DataTable().ajax.reload();  
            else                  
                $('#modal-assettype').modal('show');
        });
        
    },
    valid: function(){
        if($('#asstty_name').val() == ''){
            $('#asstty_name').removeClass('is-valid');
            $('#asstty_name').addClass('is-invalid');
            return false
        }
        else{
            $('#asstty_name').removeClass('is-invalid');
            $('#asstty_name').addClass('is-valid');
            return true;
        }
    }
};

const alocation = {
    form: {
        action: 'create',
        locat_id: '',
        locat_name: '',
    },
    initDataTable: function(){
        let table = $('#tblLocat').DataTable({
            ajax: {
                method: 'get',
                url: 'location/all',
                dataType: 'json',
                dataSrc: '',
            },
            pageLength: 25,
            processing: true,
            info: true,
            lengthChange: true,
            columns: [
                { data: 'no' },
                { data: 'id' },
                { data: 'name' },                
                { 
                    data: 'id', render: function(data, type, row, meta){
                        let param_edit = "'edit','"+row.id+"','"+row.name+"'";
                        let param_delete = "'"+row.id+"'";
                        let content = '<button type="button" class="btn btn-warning btn-sm mr-2"';
                        content += 'onclick="alocation.actionLocation('+param_edit+')"><i class="fas fa-pen"></i></button>';
                        content += '<button type="button" class="btn btn-danger btn-sm"';
                        content += 'onclick="alocation.delete('+param_delete+')"><i class="fas fa-minus"></i></button>';
                        return content;
                    } 
                },
            ],
            columnDefs: [
                { 
                    targets: 0, 
                    className: 'text-center justify-content-center',
                    searchable: false,
                    orderable: false, 
                },    
                { targets: 1, className: 'justify-content-center' }, 
                { targets: 2, className: 'justify-content-center' },             
                { 
                    targets: 3, 
                    className: 'text-center',
                    searchable: false,
                    orderable: false, 
                },
            ],
            order: [[1, 'asc']],
        });

        table.on('order.dt search.dt', function () {
            let i = 1;
    
            table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    },
    actionLocation: function(action,id,name){  
        if(action == 'create'){
            this.form.action = 'create';
            this.form.locat_id = this.form.locat_name = '';
            $('#locat_id').val('');
            $('#locat_id').prop('readonly',false);
            $('#locat_name').val('');
            $('#modal-header-title').text('เพิ่ม Lication');
        }
        else{
            this.form.action = 'edit';
            this.form.locat_id = id;
            this.form.locat_name = name;
            $('#locat_id').val(id);
            $('#locat_id').prop('readonly',true);
            $('#locat_name').val(name);
            $('#modal-header-title').text('แก้ไข Lication');
        }
        $('#modal-location').modal('show');
    },
    save: function(){
        if(this.valid()){
            $('#modal-location').modal('hide');
            $('#modal-progress').modal('show');
            let swalWithBootstrapButtons = swalInit.initBootstrap();

            let response,
            responseMsg;

            let postData = {
                action: this.form.action,
                locat_id: $('#locat_id').val(),
                locat_name: $('#locat_name').val()
            }
        
            response = operator.execute('location/setup',postData);
            responseMsg = (response.result == 'success' ? 'บันทึกข้อมูลเรียบร้อยแล้ว' : 'ไม่สามารถบันทึกข้อมูลได้');

            swalWithBootstrapButtons.fire({ 
                icon: response.result, 
                title: responseMsg, 
                text: response.message,
                confirmButtonText: 'ตกลง'
            }).then((result) => {  
                $('#modal-progress').modal('hide');  
                if(response.result == 'success')    
                    $('#tblLocat').DataTable().ajax.reload();  
                else                  
                    $('#modal-location').modal('show');
            });          
        }
    },
    delete: function(id){   
        let swalWithBootstrapButtons = swalInit.initBootstrap();
        swalWithBootstrapButtons.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: "ต้องการลบ "+id+" หรือไม่",
            showCancelButton: true,
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if(result.isConfirmed){           
                
                let response,
                responseMsg;
    
                let postData = {
                    action: 'delete',
                    locat_id: id
                }
            
                response = operator.execute('location/setup',postData);
                responseMsg = (response.result == 'success' ? 'ลบข้อมูลเรียบร้อยแล้ว' : 'ไม่สามารถลบข้อมูลได้');
    
                swalWithBootstrapButtons.fire({ 
                    icon: response.result, 
                    title: responseMsg, 
                    text: response.message,
                    confirmButtonText: 'ตกลง'
                }).then((result) => {  
                    $('#modal-progress').modal('hide');  
                    if(response.result == 'success')    
                        $('#tblLocat').DataTable().ajax.reload();  
                    else                  
                        $('#modal-location').modal('show');
                });
            }
        })
    },
    valid: function(){
        let valid_id = true,
            valid_name = true;

        if($('#locat_id').val() == ''){
            $('#locat_id').removeClass('is-valid');
            $('#locat_id').addClass('is-invalid');
            valid_id = false;
        }
        else{
            $('#locat_id').removeClass('is-invalid');
            $('#locat_id').addClass('is-valid');
            valid_id = true;
        }

        if($('#locat_name').val() == ''){
            $('#locat_name').removeClass('is-valid');
            $('#locat_name').addClass('is-invalid');
            valid_name = false;
        }
        else{
            $('#locat_name').removeClass('is-invalid');
            $('#locat_name').addClass('is-valid');
            valid_name = true;
        }

        return (valid_id && valid_name) ? true : false;
    }
};
