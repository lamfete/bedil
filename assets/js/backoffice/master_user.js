$(document).ready(function() {
    /*
     * Initialization
     * 
     * 
     */
    $('#UsernameIsAlreadyTaken').hide();
    $('#EmailIsAlreadyExist').hide();
    $('#userLevelIsNull').hide();
    $('#createNewUser').prop('disabled', true);
    validation = [];
    // Initialization end here

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
            { "data": [4] },
            // { "data": [5] },
            { "data": [6] },
            // { "data": [7] },
            // { "data": [8] },
            { "data": [9] },
            { "data": [10] }
        ],
        "order": [[1, 'asc']]
    });
} );

// load user_level
$.ajax({
    type: "POST",
    url: "userexec/get_user_level",
    success: function(data){
        // console.log(data);
        var listUserLevel = "<option value='0'></option>";
        // var listUserLevel = "";
        
        for(var i=0;i<data.length;i++)
        {
            listUserLevel += '<option value=' + data[i].user_level_id + '>' + data[i].user_level_name + '</option>';
        }
        $('#DrdUserLevel').html(listUserLevel);
    },
    error: function(data){
        console.log('Error:', data);
    }
});

function createNewUser() {
    var userlogin = $('#txtUsername').val();
    var name = $('#txtName').val();
    var email = $('#txtEmail').val();
    var password = $('#txtPassword').val();
    var userlevel = $('#DrdUserLevel').val();
    var isaktif = "";

    if($('#isAktif').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }

    console.log(userlevel);
}

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

/*
 * Function enable tombol createNewUser
 * 
 * Yang di cek adalah field: username, email dan user level
 * 
 */
function enableButtonCreateNewUser() {
    if(validation.length == 3) {
        $('#createNewUser').prop('disabled', false);
    }
}

/*
 * Function untuk mengecek field username dan email sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function cekFormCreateNewUser(param) {
    // var validation = [];

    if(param=='username') {
        var username = $("#txtUsername").val();

        $.ajax({
            type: "POST",
            url: "userexec/cek_create_new_user?param=username",
            data: "userLogin=" + username,
            success: function(resp) {
                // console.log('Username ' + resp.data[0].user_login + ' sudah dipakai');
                if(resp.count === 1) {
                    $("#UsernameIsAlreadyTaken").html("<span>" + resp.message + "</span>");
                    $('#UsernameIsAlreadyTaken').show();
                } else {
                    $('#UsernameIsAlreadyTaken').hide();
                    
                    if($.inArray("username", validation) == -1) {
                        validation.push("username");    
                    }
                    
                    console.log(validation);
                    enableButtonCreateNewUser();
                }
            },
            error: function(resp) {
                console.log('Error: ', resp);
                alert("something went wrong");
                window.location.href = '/user';
            }
        });
    } else if(param=="email") {
        var email = $("#txtEmail").val();

        $.ajax({
            type: "POST",
            url: "userexec/cek_create_new_user?param=email",
            data: "email=" + email,
            success: function(resp) {
                // console.log('Username ' + resp.data[0].user_login + ' sudah dipakai');
                if(resp.count === 1) {
                    $("#EmailIsAlreadyExist").html("<span>" + resp.message + "</span>");
                    $('#EmailIsAlreadyExist').show();
                } else {
                    $('#EmailIsAlreadyExist').hide();
                    
                    if($.inArray("email", validation) == -1) {
                        validation.push("email");
                    }

                    console.log(validation);
                    enableButtonCreateNewUser();
                }
            },
            error: function(resp) {
                console.log('Error: ', resp);
                alert("something went wrong");
                window.location.href = '/user';
            }
        });
    }

    else if(param=="userLevel") {
        var userLevel = $("#DrdUserLevel").val();
        // console.log(userLevel);
        
        if(userLevel == 0) {
            $("#userLevelIsNull").html("<span>Must choose one!</span>");
            $("#userLevelIsNull").show();
        } else {
            $('#userLevelIsNull').hide();

            if($.inArray("userlevel", validation) == -1) {
                validation.push("userlevel");    
            }

            console.log(validation);
            enableButtonCreateNewUser();
        }
    }

    
}

/* 
 * Function untuk menampilkan detail datatables
 * 
 * Formatting function for row details - modify as you need 
 * 
 */
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

/*
 * Function untuk show detail (klik tombol plus) di datatables
 * 
 * Add event listener for opening and closing details
 * 
 */
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