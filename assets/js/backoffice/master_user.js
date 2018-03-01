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

    // array untuk mengecek apakah semua field mandatory sudah diisi semua atau belum
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
            // { "data": [9] },
            // { "data": [10] },
            { "data": [11] },
            { "data": [12] }
        ],
        "order": [[1, 'asc']]
    });
} );

/*
 * load user_level
 * 
 * 
 */
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

/*
 * Function untuk mengosongkan semua textfield yang ada di form create new user
 * 
 * 
 * 
 */
function clearCreateModalTextfield() {
    $('#txtUsername').val("");
    $('#txtName').val("");
    $('#txtEmail').val("");
    $('#txtPassword').val("");
    $('#DrdUserLevel').val("0");
    $('#isAktif').prop('checked', false); 
    
    validation = [];

    enableButtonCreateNewUser();    
}

/*
 * 
 * 
 * 
 * 
 */
function createNewUser() {
    var createdby = $('#userIdLogin').val();
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

    $.ajax({
        type: "POST",
        url: "userexec/create_new_user",
        data: {
            userLevelId: userlevel,
            userLogin: userlogin,
            name: name,
            email: email,
            password: password,
            status: isaktif,
            createdBy: createdby
        },
        success: function(resp) {
            // alert("SUKSES BUAT USER BARU");
            alert(resp.message);
            window.location.href = '/user';
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.error);
            window.location.href = '/user';
        }
    });
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
    console.log("validation.length: " + validation.length);
    if(validation.length == 3) {
        $('#createNewUser').prop('disabled', false);
    }
    else {
        $('#createNewUser').prop('disabled', true);
    }
}

/*
 * Function untuk mengecek field username dan email sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function cekFormCreateNewUser(param) {
    if(param=='username') {
        var username = $("#txtUsername").val();

        if(username == '' && $.inArray(param, validation) > -1) {
            removeElementOfArray(validation, param);
            console.log(validation);
        } else {
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
        }
    } else if(param=="email") {
        var email = $("#txtEmail").val();

        if(email == '' && $.inArray(param, validation) > -1) {
            removeElementOfArray(validation, param);
            console.log(validation);
        } else {
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
    }

    else if(param=="userLevel") {
        var userLevel = $("#DrdUserLevel").val();
        // console.log(userLevel);
        
        if(userLevel == 0) {
            if($.inArray(param, validation) > -1) {
                removeElementOfArray(validation, param);
                enableButtonCreateNewUser();
                console.log(validation);
            } else {
                $("#userLevelIsNull").html("<span>Must choose one!</span>");
                $("#userLevelIsNull").show();
            }
        } else {
            $('#userLevelIsNull').hide();

            if($.inArray(param, validation) == -1) {
                validation.push(param);    
            }

            console.log(validation);
            enableButtonCreateNewUser();
        }
    }
}