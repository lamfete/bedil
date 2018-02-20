$(document).ready(function() {
    $('#table_user').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: 'userexec/get_user',
            type: 'POST'
        },
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": [0] },
            // { "data": [1] },
            { "data": [2] },
            { "data": [3] },
            // { "data": [4] },
            { "data": [5] },
            // { "data": [6] },
            // { "data": [7] },
            { "data": [8] },
            { "data": [9] }
        ],
        "order": [[1, 'asc']]
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

// load user_level
$.ajax({
    type: "POST",
    url: "userexec/get_user_level",
    success: function(data){
        // console.log(data);
        for(var i=0;i<data.length;i++)
        {
            listUserLevel += '<option value=' + data[i].user_level_id + '>' + data[i].user_level_name + '</option>';
        }
        $('#userLevel').html(listUserLevel);
    },
    error: function(data){
        console.log('Error:', data);
    }
});

/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Name:</td>'+
            '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Status:</td>'+
            '<td>'+d.status+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Password:</td>'+
            '<td>'+d.password+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.created_at+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>'+d.updated_at+'</td>'+
        '</tr>'+
    '</table>';
}

// Add event listener for opening and closing details
$('#table_user tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
} );