$(document).ready(function() {
    /*
     * Initialization
     * 
     * 
     */
    $('#SupplierNameIsAlreadyTaken').hide();
    // $('#createNewSupplier').prop('disabled', true);

    // array untuk mengecek apakah semua field mandatory sudah diisi semua atau belum
    validation = [];
    // Initialization end here

    $('#table_supplier').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: 'supplierexec/get_supplier',
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
            { "data": [1] },
            { "data": [2] },
            { "data": [3] },
            { "data": [4] },
            { "data": [5] }
            // { "data": [6] }
            // { "data": [7] },
            // { "data": [8] },
            // { "data": [9] },
            // { "data": [10] },
            // { "data": [11] },
            // { "data": [12] }
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

    // enableButtonCreateNewSupplier();    
}

/*
 * 
 * 
 * 
 * 
 */
function createNewSupplier() {
    var createdby = $('#userIdLogin').val();
    var userlogin = $('#txtUsername').val();
    var supplierName = $('#txtSupplierName').val();
    var address1 = $('#txtAddress1').val();
    var address2 = $('#txtAddress2').val();
    var phone1 = $('#txtPhone1').val();
    var phone2 = $('#txtPhone2').val();
    var email1 = $('#txtEmail1').val();
    var email2 = $('#txtEmail2').val();
    var bankAcc1 = $('#txtBankAcc1').val();
    var bankAcc2 = $('#txtBankAcc2').val();

    $.ajax({
        type: "POST",
        url: "supplierexec/create_new_supplier",
        data: {
            userLogin: userlogin,
            supplierName: supplierName,
            address1: address1,
            address2: address2,
            phone1: phone1,
            phone2: phone2,
            email1: email1,
            email2: email2,
            bankAcc1: bankAcc1,
            bankAcc2: bankAcc2,
            createdBy: createdby
        },
        success: function(resp) {
            // alert("SUKSES BUAT USER BARU");
            alert(resp.message);
            // window.location.href = '/supplier';
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.message);
            // window.location.href = '/supplier';
        }
    });
}

/*
 * function untuk mengisi modal edit supplier
 * 
 * 
 * 
 */
function editSupplier(value) {
    var idSupplier = value[0];
    
    $.ajax({
        type: "POST",
        url: "supplierexec/edit_supplier",
        data: {
            idSupplier: idSupplier
        },
        success: function(resp) {
            console.log(resp.data[0]);
            $('#supplierId').val(resp.data[0].supplier_id);
            $('#txtSupplierNameEdit').val(resp.data[0].supplier_name);
            $('#txtAddress1Edit').val(resp.data[0].supplier_address_1);
            $('#txtAddress2Edit').val(resp.data[0].supplier_address_2);
            $('#txtPhone1Edit').val(resp.data[0].supplier_phone_1);
            $('#txtPhone2Edit').val(resp.data[0].supplier_phone_2);
            $('#txtEmail1Edit').val(resp.data[0].supplier_email_1);
            $('#txtEmail2Edit').val(resp.data[0].supplier_email_2);
            $('#txtBankAcc1Edit').val(resp.data[0].supplier_bank_acc_1);
            $('#txtBankAcc2Edit').val(resp.data[0].supplier_bank_acc_2);
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.message);
        }
    });
};

/*
 * function untuk delete supplier
 * 
 * 
 */
function deleteSupplier(value) {
    // console.log(value[1]);

    var deleteRecord = confirm("Yakin hapus data supplier " + value[1] + " dari database?");

    if(deleteRecord == true) {
        $.ajax({
            type: "POST",
            url: "supplierexec/delete_supplier",
            data: {
                supplierId: value[0],
                supplierName: value[1],
                createdBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL DELETE USER");
                alert(resp.message);
                window.location.href = '/supplier';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/supplier';
            }
        });
    }
};

function updateSupplier() {
    // console.log($('#userIdLogin').val() + ' ; ' + $('#idUser').val() + ' ; ' + $('#txtUserloginEdit').val() + ' ; ' + $('#name').val() + ' ; ' + $('#email').val() + ' ; ' + isaktif);
    var updateRecord = confirm("Yakin update data supplier " + $('#txtSupplierNameEdit').val() + "?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "supplierexec/update_supplier",
            data: {
                supplierId: $('#supplierId').val(),
                supplierName: $('#txtSupplierNameEdit').val(),
                supplierAdd1: $('#txtAddress1Edit').val(),
                supplierAdd2:  $('#txtAddress2Edit').val(),
                supplierPhone1: $('#txtPhone1Edit').val(),
                supplierPhone2: $('#txtPhone2Edit').val(),
                supplierEmail1: $('#txtEmail1Edit').val(),
                supplierEmail2: $('#txtEmail2Edit').val(),
                supplierBankAcc1: $('#txtBankAcc1Edit').val(),
                supplierBankAcc2: $('#txtBankAcc2Edit').val(),
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '/supplier';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/supplier';
            }
        });
    }
};

/*
 * Function enable tombol createNewSupplier
 * 
 * Yang di cek adalah field: supplier name, email
 * 
 */
function enableButtonCreateNewSupplier() {
    console.log("validation.length: " + validation.length);
    if(validation.length == 1) {
        $('#createNewSupplier').prop('disabled', false);
    }
    else {
        $('#createNewSupplier').prop('disabled', true);
    }
}

/*
 * Function untuk mengecek field supplier name dan no HP sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function cekFormCreateNewSupplier(param) {
    if(param=='supplierName') {
        var supplierName = $("#txtSupplierName").val();

        if(supplierName == '' && $.inArray(param, validation) > -1) {
            removeElementOfArray(validation, param);
            console.log(validation);
        } else {
            $.ajax({
                type: "POST",
                url: "supplierexec/cek_supplier?param=suppliername",
                data: "supplierName=" + supplierName,
                success: function(resp) {
                    // console.log('Username ' + resp.data[0].user_login + ' sudah dipakai');
                    if(resp.count === 1) {
                        $("#SupplierNameIsAlreadyTaken").html("<span>" + resp.message + "</span>");
                        $('#SupplierNameIsAlreadyTaken').show();
                    } else {
                        $('#SupplierNameIsAlreadyTaken').hide();
                        
                        if($.inArray("username", validation) == -1) {
                            validation.push("suppliername");    
                        }
                        
                        console.log(validation);
                        // enableButtonCreateNewSupplier();
                    }
                },
                error: function(resp) {
                    console.log('Error: ', resp);
                    alert("something went wrong");
                    window.location.href = '/supplier';
                }
            });
        }
    }
}