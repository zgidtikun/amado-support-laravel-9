$(document).ready(function(){
    defPage.setDefaultPage(window.location.pathname);    
});

const defPage = {
    setDefaultPage: function(url){
        console.log(url);
        switch(url){
            case '/admin/location': 
                alocation.initDataTable();
            break;
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
        var table = $('#tblLocat').DataTable({
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
        console.log(action,id,name);   
        if(action == 'create'){
            this.form.action = 'create';
            this.form.locat_id = this.form.locat_name = '';
            $('#locat_id').val('');
            $('#locat_name').val('');
            $('#modal-header-title').text('เพิ่ม Lication');
        }
        else{
            this.form.action = 'edit';
            this.form.locat_id = id;
            this.form.locat_name = name;
            $('#locat_id').val(id);
            $('#locat_name').val(name);
            $('#modal-header-title').text('แก้ไข Lication');
        }

        $('#modal-location').modal('show');
    },
    save: function(){

        

    },
    delete: function(id){
        console.log(id);
    }
};

$('#menu-a-mis-main').click(function(){
    $('#menu-a-mis-infosetup').toggleClass('show');
});