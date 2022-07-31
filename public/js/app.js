// import $ from "jquery";

$(document).ready(function(){
    defPage.setDefaultPage(window.location.pathname);   
    
    $('#menu-a-mis-main').click(function(){
        $('#menu-a-mis-infosetup').toggleClass('show');
    });
});

const defPage = {
    setDefaultPage: function(url){
        console.log(url);
        switch(url){
            case '/admin/location': 
                alocation.initDataTable();
            break;
            case '/admin/asset-type': 
                aAssetType.initDataTable();
            break;
        }
    }
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

        $.ajax({
            method: 'post',
            url: 'asset-type/setup',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            data: postData,
            success: function(response){       
                $('#modal-progress').modal('hide');
                if(response.status){                 
                    let text = (postData.action == 'delete' ? 'ลบข้อมูลเรียบร้อยแล้ว' : 'บันทึกข้อมูลเรียบร้อยแล้ว');
                    swalWithBootstrapButtons.fire({ 
                        icon: 'success', 
                        title: text,
                        confirmButtonText: 'ตกลง'
                    }).then((result) => {
                        $('#tblAsstty').DataTable().ajax.reload();
                    });
                }
                else{
                    let text = (postData.action == 'delete' ? 'ไม่สามารถลบข้อมูลได้' : 'ไม่สามารถบันทึกข้อมูลได้');
                    swalWithBootstrapButtons.fire({ 
                        icon: 'error', 
                        title: text, 
                        text: 'Error : '+response.message ,
                        confirmButtonText: 'ตกลง'
                    }).then((result) => {                            
                        $('#modal-assettype').modal('show');
                    });
                }
            },
            error: function(jqXhr, textStatus, errorMessage){
                $('#modal-progress').modal('hide');
                let text = (postData.action == 'delete' ? 'ไม่สามารถลบข้อมูลได้' : 'ไม่สามารถบันทึกข้อมูลได้');
                swalWithBootstrapButtons.fire({ 
                    icon: 'error', 
                    title: text, 
                    text: 'Error : '+errorMessage,
                    confirmButtonText: 'ตกลง'
                }).then((result) => {                            
                    $('#modal-location').modal('show');
                });
            }
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
            $.ajax({
                method: 'post',
                url: 'location/setup',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                data: {
                    action: this.form.action,
                    locat_id: $('#locat_id').val(),
                    locat_name: $('#locat_name').val()
                },
                success: function(response){    
                    $('#modal-progress').modal('hide');
                    if(response.status){                    
                        swalWithBootstrapButtons.fire({ 
                            icon: 'success', 
                            title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            $('#tblLocat').DataTable().ajax.reload();
                        });
                    }
                    else{
                        swalWithBootstrapButtons.fire({ 
                            icon: 'error', 
                            title: 'ไม่สามารถบันทึกข้อมูลได้', 
                            text: 'Error : '+response.errorMsg ,
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {                            
                            $('#modal-location').modal('show');
                        });
                    }
                },
                error: function(jqXhr, textStatus, errorMessage){
                    $('#modal-progress').modal('hide');
                        swalWithBootstrapButtons.fire({ 
                            icon: 'error', 
                            title: 'ไม่สามารถบันทึกข้อมูลได้', 
                            text: 'Error : '+errorMessage,
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {                            
                            $('#modal-location').modal('show');
                    });
                }
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
                $('#modal-progress').modal('show');
                $.ajax({
                    method: 'post',
                    url: 'location/setup',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    data: {
                        action: 'delete',
                        locat_id: id
                    },
                    success: function(response){
                        $('#modal-progress').modal('hide');
                        if(response.status){                     
                            swalWithBootstrapButtons.fire({ 
                                icon: 'success', 
                                title: 'ลบข้อมูลเรียบร้อยแล้ว',
                                confirmButtonText: 'ตกลง'
                            }).then((result) => {
                                $('#tblLocat').DataTable().ajax.reload();
                            });
                        }
                        else{
                            swalWithBootstrapButtons.fire({ 
                                icon: 'error', 
                                title: 'ไม่สามารถลบข้อมูลได้', 
                                text: 'Error : '+response.errorMsg ,
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    }
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
