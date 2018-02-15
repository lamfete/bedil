$(document).ready(function() {
    $('#table_user').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: 'userexec/get_user',
            type: 'POST'
        },
        "columns": [
            null,
            null,
            null,
            null,
            { "visible": false },
            null,
            null,
            null,
            null,
            null
        ]
    });
} );

function editUser(value) {
    $('#user_login').val(value[2]);
    $('#name').val(value[3]);
    if(value[5]=='AKTIF'){  
        $('#status').prop('checked', true);
    }
    else {
        $('#status').prop('checked', false);
    }
};