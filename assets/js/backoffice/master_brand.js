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
    
    $('#createNewBrand').prop('disabled', true);

    // array untuk mengecek apakah semua field mandatory sudah diisi semua atau belum
    validation = [];
    // Initialization end here

    $('#tableBrand').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: 'brandexec/get_brand',
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
            { "data": [5] },
            { "data": [6] }
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
// untuk modal create brand
$.ajax({
    type: "POST",
    url: "brandexec/get_cat_brand",
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

// untuk modal edit brand
$.ajax({
    type: "POST",
    url: "brandexec/get_cat_brand",
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
 * load category based on id_item
 * for edit purpose
 * 
 */
/*function getCategoryItem() {
    var categoryid = $('#DrdCategory').val()
    
    if(categoryid > 0) {
        console.log(categoryid);
        $.ajax({
            type: "POST",
            url: "itemexec/get_type_item",
            data: {
                categoryId: categoryid
            },
            success: function(data){
                console.log(data);
                var listType = "<option value='0'></option>";
                // var listCategory = "";
                
                for(var i=0;i<data.length;i++)
                {
                    listType += '<option value=' + data[i].type_id + '>' + data[i].type_name + '</option>';
                }
                $('#DrdType').html(listType);
            },
            error: function(data){
                console.log('Error:', data);
            }
        });
    } 
}*/

/*
 * load type based on category
 * 
 * 
 */
function getTypeBrand(param) {
    var categoryid = '';
    

    if(param) {
        // console.log("ADA ISINYA");
        categoryid = param.category_id;
    }
    else {
        // console.log("TIDAK ADA ISINYA");
        categoryid = $('#DrdCategory').val();
    }
    
    if(categoryid > 0) {
        // console.log(categoryid);
        $.ajax({
            type: "POST",
            url: "brandexec/get_type_brand",
            data: {
                categoryId: categoryid
            },
            success: function(data){
                // console.log(data);
                var listType = "<option value='0'></option>";
                // var listCategory = "";
                
                for(var i=0;i<data.length;i++)
                {
                    listType += '<option value=' + data[i].type_id + '>' + data[i].type_name + '</option>';
                }
                
                if(param) {
                    $('#DrdTypeEdit').html(listType);

                    // untuk edit modal
                    $('#DrdTypeEdit').val(param.type_id);
                } else {
                    $('#DrdType').html(listType);
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
    $('#DrdCategory').val("0");
    $('#DrdCategoryEdit').val("0");
    $('#DrdType').val("0");
    $('#DrdTypeEdit').val("0");
    $('#txtBrandName').val('');
    // $('#isAktif').prop('checked', false); 
    
    validation = [];

    enableButtonCreateNewBrand();    
}

/*
 * 
 * 
 * 
 * 
 */
function createNewBrand() {
    var createdby = $('#userIdLogin').val();
    var category = $("#DrdCategory").val();
    var type = $("#DrdType").val();
    var brandname = $("#txtBrandName").val();
    var isaktif = "";

    if($('#isAktif').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }

    $.ajax({
        type: "POST",
        url: "brandexec/create_new_brand",
        data: {
            brandCat: category,
            brandType: type,
            brandName: brandname,
            isAktif: isaktif,
            createdBy: createdby
        },
        success: function(resp) {
            // alert("SUKSES BUAT USER BARU");
            alert(resp.message);
            window.location.href = '/brand';
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.message);
            window.location.href = '/brand';
        }
    });
}

/*
 * function untuk mengisi modal edit item
 * 
 * 
 * 
 */
function editBrand(value) {
    console.log(value);

    var idbrand = value[0];
    // console.log(idbrand);
    
    $.ajax({
        type: "POST",
        url: "brandexec/get_brand_detail",
        data: {
            idBrand: idbrand
        },
        success: function(data){
            // console.log(data.data[0].category_id);
            
            getTypeBrand(data.data[0]);
            
            //set dropdown sesuai dengan record yg mau di edit
            $('#idBrand').val(idbrand);
            $('#DrdCategoryEdit').val(data.data[0].category_id);
            $('#txtBrandEdit').val(data.data[0].brand_name);
            
            if(data.data[0].brand_status == 'AKTIF') {
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
 * function untuk delete item
 * 
 * 
 */
function deleteBrand(value) {
    // console.log(value);

    var deleteRecord = confirm("Yakin hapus data brand " + value[3] + " dari database?");

    if(deleteRecord == true) {
        $.ajax({
            type: "POST",
            url: "brandexec/delete_brand",
            data: {
                brandId: value[0],
                brandName: value[3],
                createdBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL DELETE BRAND");
                alert(resp.message);
                window.location.href = '/brand';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/brand';
            }
        });
    }
};

function updateBrand() {
    var isaktif = "";

    if($('#statusEdit').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }
    // console.log($('#userIdLogin').val() + ' ; ' + $('#idUser').val() + ' ; ' + $('#txtUserloginEdit').val() + ' ; ' + $('#name').val() + ' ; ' + $('#email').val() + ' ; ' + isaktif);
    var updateRecord = confirm("Yakin update data brand " + $('#txtBrandEdit').val() + "?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "brandexec/update_brand",
            data: {
                brandId: $('#idBrand').val(),
                brandName: $('#txtBrandEdit').val(),
                brandStatus: isaktif,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '/brand';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/brand';
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
function enableButtonCreateNewBrand() {
    console.log("validation.length: " + validation.length);
    if(validation.length == 3) {
        $('#createNewBrand').prop('disabled', false);
    }
    else {
        $('#createNewBrand').prop('disabled', true);
    }
}

/*
 * Function untuk mengecek field username dan email sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function cekFormCreateNewBrand(param) {
    if(param=='brandname') {
        var category = $("#DrdCategory").val();
        var type = $("#DrdType").val();
        var brandname = $("#txtBrandName").val();

        if(brandname == '' && $.inArray(param, validation) > -1) {
            removeElementOfArray(validation, param);
            console.log(validation);
        } else {
            $.ajax({
                type: "POST",
                url: "brandexec/cek_brand?param=brand",
                data: {
                    brandName: brandname,
                    brandCat: category,
                    brandType: type
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
                        enableButtonCreateNewBrand();
                    }
                },
                error: function(resp) {
                    console.log('Error: ', resp);
                    alert("something went wrong");
                    // window.location.href = '/brand';
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
                enableButtonCreateNewItem();
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
            enableButtonCreateNewItem();
        }
    }
    else if(param=="type") {
        var type = $("#DrdType").val();
        // console.log(userLevel);
        
        if(type == 0) {
            if($.inArray(param, validation) > -1) {
                removeElementOfArray(validation, param);
                enableButtonCreateNewItem();
                console.log(validation);
            } else {
                $("#typeIsNull").html("<span>Must choose one!</span>");
                $("#typeIsNull").show();
            }
        } else {
            $('#typeIsNull').hide();

            if($.inArray(param, validation) == -1) {
                validation.push(param);    
            }

            console.log(validation);
            enableButtonCreateNewItem();
        }
    }
}

