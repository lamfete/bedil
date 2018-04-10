$(document).ready(function() {
    /*
     * Initialization
     * 
     * 
     */
    function hideNotification() {
        $('#categoryIsNull').hide();
        $('#categoryEditIsNull').hide();
        $('#brandIsNull').hide();
        $('#brandEditIsNull').hide();
        $('#typeIsNull').hide();
        $('#typeEditIsNull').hide();
        $('#nameIsAlreadyTaken').hide();
        $('#nameEditIsAlreadyTaken').hide();
    }

    hideNotification();

    $('#isAktif').prop('checked', true);
    
    $('#createNewType').prop('disabled', true);

    // array untuk mengecek apakah semua field mandatory sudah diisi semua atau belum
    validation = [];
    // Initialization end here

    $('#tableType').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            url: 'typeexec/get_type',
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
 * load category
 * 
 * 
 */
// untuk modal create type
$.ajax({
    type: "POST",
    url: "typeexec/get_cat_type",
    success: function(data){
        // console.log(data);
        var listCategory = "<option value='0'></option>";
        // var listCategory = "";
        
        for(var i=0;i<data.length;i++)
        {
            listCategory += '<option value=' + data[i].category_id + '>' + data[i].category_name + '</option>';
        }
        $('#DrdCategory').html(listCategory);
    },
    error: function(data){
        console.log('Error:', data);
    }
});

// untuk modal edit type
$.ajax({
    type: "POST",
    url: "typeexec/get_cat_type",
    success: function(data){
        // console.log(data);
        var listCategoryEdit = "<option value='0'></option>";
        // var listCategory = "";
        
        for(var i=0;i<data.length;i++)
        {
            listCategoryEdit += '<option value=' + data[i].category_id + '>' + data[i].category_name + '</option>';
        }
        $('#DrdCategoryEdit').html(listCategoryEdit);
    },
    error: function(data){
        console.log('Error:', data);
    }
});

/*
 * load type based on category
 * 
 * 
 */
function getCatType(param) {
    var categoryid = '';
    

    if(param) {
        // console.log("ADA ISINYA");
        categoryid = param.category_id;
    }
    else {
        // console.log("TIDAK ADA ISINYA");
        categoryid = $('#DrdCategoryEdit').val();
    }
    
    if(categoryid > 0) {
        // console.log(categoryid);
        $.ajax({
            type: "POST",
            url: "typeexec/get_cat_type",
            data: {
                categoryId: categoryid
            },
            success: function(data){
                // console.log(data);
                var listCategory = "<option value='0'></option>";
                // var listCategory = "";
                
                for(var i=0;i<data.length;i++)
                {
                    listCategory += '<option value=' + data[i].category_id + '>' + data[i].category_name + '</option>';
                }
                
                if(param) {
                    $('#DrdCategoryEdit').html(listCategory);

                    // untuk edit modal
                    $('#DrdCategoryEdit').val(param.category_id);
                } else {
                    $('#DrdCategory').html(listCategory);
                }
            },
            error: function(data){
                console.log('Error:', data);
            }
        });
    } 
}

/*
 * load type based on category
 * 
 * 
 */
function getBrandItem(param) {
    var typeid = '';   

    if(param) {
        // console.log("ADA ISINYA");
        typeid = param.type_id;
    }
    else {
        // console.log("TIDAK ADA ISINYA");
        typeid = $('#DrdType').val();
    }

    if(typeid > 0) {
        // console.log(categoryId);
        $.ajax({
            type: "POST",
            url: "itemexec/get_brand_item",
            data: {
                typeId: typeid
            },
            success: function(data){
                // console.log(data);
                var listBrand = "<option value='0'></option>";
                // var listCategory = "";
                
                for(var i=0;i<data.length;i++)
                {
                    listBrand += '<option value=' + data[i].brand_id + '>' + data[i].brand_name + '</option>';
                }
                // $('#DrdBrand').html(listBrand);

                if(param) {
                    $('#DrdBrandEdit').html(listBrand);

                    // untuk edit modal
                    $('#DrdBrandEdit').val(param.brand_id);
                } else {
                    $('#DrdBrand').html(listBrand);
                }
            },
            error: function(data){
                console.log('Error:', data);
            }
        });
    } 
}

/*
 * Function untuk mengosongkan semua textfield yang ada di form create new item
 * 
 * 
 * 
 */
function clearCreateModalTextfield() {
    $('#DrdCategory').val("0");;
    $('#txtTypeName').val('');
    // $('#isAktif').prop('checked', false); 
    
    validation = [];

    enableButtonCreateNewType();    
}

/*
 * 
 * 
 * 
 * 
 */
function createNewType() {
    var createdby = $('#userIdLogin').val();
    var category = $("#DrdCategory").val();
    var typename = $("#txtTypeName").val();
    var isaktif = "";

    if($('#isAktif').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }

    $.ajax({
        type: "POST",
        url: "typeexec/create_new_type",
        data: {
            typeCat: category,
            typeName: typename,
            isAktif: isaktif,
            createdBy: createdby
        },
        success: function(resp) {
            // alert("SUKSES BUAT USER BARU");
            alert(resp.message);
            window.location.href = '/type';
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.message);
            window.location.href = '/type';
        }
    });
}

/*
 * function untuk mengisi modal edit type
 * 
 * 
 * 
 */
function editType(value) {
    console.log(value);

    var idtype = value[0];
    // console.log(iditem);

    $('#txtTypeEdit').val(value[1]);
    
    $.ajax({
        type: "POST",
        url: "typeexec/get_type_detail",
        data: {
            idType: idtype
        },
        success: function(data){
            // console.log(data.data[0].brand_id);
            
            getCatType(data.data[0]);
            
            //set dropdown sesuai dengan record yg mau di edit
            $('#idType').val(idtype);
            $('#DrdCategoryEdit').val(data.data[0].category_id);
            $('#txtTypeEdit').val(data.data[0].type_name);

            if(value[6]=='AKTIF'){  
                $('#statusEdit').prop('checked', true);
            }
            else {
                $('#statusEdit').prop('checked', false);
            }
            
            if(data.data[0].type_status == 'AKTIF') {
                $('#statusEdit').prop("checked", true);
            }
            else {
                $('#statusEdit').prop("checked", false);
            }
            // end here
        },
        error: function(data){
            console.log('Error:', data);
        }
    });
};

/*
 * function untuk delete type
 * 
 * 
 */
function deleteType(value) {
    // console.log(value);

    var deleteRecord = confirm("Yakin hapus data type " + value[0] + " dari database?");

    if(deleteRecord == true) {
        $.ajax({
            type: "POST",
            url: "typeexec/delete_type",
            data: {
                typeId: value[0],
                typeName: value[1],
                createdBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL DELETE USER");
                alert(resp.message);
                window.location.href = '/type';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/type';
            }
        });
    }
};

function updateType() {
    var isaktif = "";

    if($('#statusEdit').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }
    console.log($('#userIdLogin').val() + ' ; ' + $('#DrdCategoryEdit').val() + ' ; ' + $('#txtTypeEdit').val() + isaktif);
    var updateRecord = confirm("Yakin update data type " + $('#txtTypeEdit').val() + "?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "typeexec/update_type",
            data: {
                typeId: $('#idType').val(),
                categoryId: $('#DrdCategoryEdit').val(),
                typeName: $('#txtTypeEdit').val(),
                typeStatus: isaktif,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '/type';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/type';
            }
        });
    }
};

/*
 * Function enable tombol createNewUser
 * 
 * Yang di cek adalah field: username, email dan user level
 * 
 */
function enableButtonCreateNewType() {
    console.log("validation.length: " + validation.length);
    if(validation.length == 2) {
        $('#createNewType').prop('disabled', false);
    }
    else {
        $('#createNewType').prop('disabled', true);
    }
}

/*
 * Function untuk mengecek field username dan email sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function cekFormCreateNewType(param) {
    if(param=='typename') {
        var category = $("#DrdCategory").val();
        var typename = $("#txtTypeName").val();
console.log(category + ' | ' + typename);
        if(typename == '' && $.inArray(param, validation) > -1) {
            removeElementOfArray(validation, param);
            console.log(validation);
        } else {
            $.ajax({
                type: "POST",
                url: "typeexec/cek_type?param=type",
                data: {
                    typeName: typename,
                    typeCat: category
                },
                success: function(resp) {
                    // console.log('Username ' + resp.data[0].user_login + ' sudah dipakai');
                    if(resp.count === 1) {
                        $("#nameIsAlreadyTaken").html("<span>" + resp.message + "</span>");
                        $('#nameIsAlreadyTaken').show();
                    } else {
                        $('#nameIsAlreadyTaken').hide();
                        
                        if($.inArray(param, validation) == -1) {
                            validation.push(param);    
                        }
                        
                        console.log(validation);
                        enableButtonCreateNewType();
                    }
                },
                error: function(resp) {
                    console.log('Error: ', resp);
                    alert("something went wrong");
                    window.location.href = '/item';
                }
            });
            //console.log(category + ' | '+ type + ' | '+ brand + ' | '+ itemname);
        }
    } 
    else if(param=="category") {
        var category = $("#DrdCategory").val();
        // console.log(userLevel);
        
        if(category == 0) {
            if($.inArray(param, validation) > -1) {
                removeElementOfArray(validation, param);
                enableButtonCreateNewType();
                console.log(validation);
            } else {
                $("#categoryIsNull").html("<span>Must choose one!</span>");
                $("#categoryIsNull").show();
            }
        } else {
            $('#categoryIsNull').hide();

            if($.inArray(param, validation) == -1) {
                validation.push(param);    
            }

            console.log(validation);
            enableButtonCreateNewType();
        }
    }
}

