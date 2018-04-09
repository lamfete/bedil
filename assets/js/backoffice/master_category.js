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
    
    $('#createNewItem').prop('disabled', true);

    // array untuk mengecek apakah semua field mandatory sudah diisi semua atau belum
    validation = [];
    // Initialization end here

    $('#tableCategory').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: 'categoryexec/get_category',
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
            { "data": [4] }
            // { "data": [5] }
            // { "data": [6] },
            // { "data": [7] }
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
// untuk modal create category
/*$.ajax({
    type: "POST",
    url: "categoryexec/get_cat_category",
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
});*/

// untuk modal edit item
/*$.ajax({
    type: "POST",
    url: "itemexec/get_cat_item",
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
});*/

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
function getTypeItem(param) {
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
            url: "itemexec/get_type_item",
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
    $('#DrdBrand').val();
    $('#DrdBrandEdit').val();
    $('#txtItemName').val();
    $('#txtItemRemark').val();
    // $('#isAktif').prop('checked', false); 
    
    validation = [];

    enableButtonCreateNewCategory();    
}

/*
 * 
 * 
 * 
 * 
 */
function createNewCategory() {
    var createdby = $('#userIdLogin').val();
    var categoryname = $("#txtCategoryName").val();
    var isaktif = "";

    if($('#isAktif').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }

    $.ajax({
        type: "POST",
        url: "categoryexec/create_new_category",
        data: {
            categoryName: categoryname,
            isAktif: isaktif,
            createdBy: createdby
        },
        success: function(resp) {
            // alert("SUKSES BUAT USER BARU");
            alert(resp.message);
            window.location.href = '/category';
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.message);
            window.location.href = '/category';
        }
    });
}

/*
 * function untuk mengisi modal edit item
 * 
 * 
 * 
 */
function editCategory(value) {
    console.log(value);

    var idcategory = value[0];
    // console.log(idcategory);

    if(value[3] == 'AKTIF') {
        $('#statusEdit').prop("checked", true);
    }
    else {
        $('#statusEdit').prop("checked", false);
    }

    $('#idCategory').val(idcategory);
    $('#txtCategoryEdit').val(value[1]);
};

/*
 * function untuk delete category
 * 
 * 
 */
function deleteCategory(value) {
    // console.log(value);

    var deleteRecord = confirm("Yakin hapus data category " + value[0] + " dari database?");

    if(deleteRecord == true) {
        $.ajax({
            type: "POST",
            url: "categoryexec/delete_category",
            data: {
                categoryId: value[0],
                categoryName: value[1],
                createdBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL DELETE USER");
                alert(resp.message);
                window.location.href = '/category';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/category';
            }
        });
    }
};

function updateCategory() {
    var isaktif = "";

    if($('#statusEdit').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }
    // console.log($('#userIdLogin').val() + ' ; ' + $('#idCategory').val() + ' ; ' + $('#txtCategoryEdit').val() + isaktif);
    var updateRecord = confirm("Yakin update data user " + $('#txtCategoryEdit').val() + "?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "categoryexec/update_category",
            data: {
                categoryId: $('#idCategory').val(),
                categoryName: $('#txtCategoryEdit').val(),
                categoryStatus: isaktif,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '/category';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/category';
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
function enableButtonCreateNewCategory() {
    console.log("validation.length: " + validation.length);
    if(validation.length == 1) {
        $('#createNewCategory').prop('disabled', false);
    }
    else {
        $('#createNewCategory').prop('disabled', true);
    }
}

/*
 * Function untuk mengecek field username dan email sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function cekFormCreateNewCategory(param) {
    if(param=='categoryname') {
        var categoryname = $("#txtCategoryName").val();
        
        if(categoryname == '' && $.inArray(param, validation) > -1) {
            removeElementOfArray(validation, param);
            console.log(validation);
            console.log("TES");
        } else {
            $.ajax({
                type: "POST",
                url: "categoryexec/cek_category?param=category",
                data: {
                    categoryName: categoryname
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
                        enableButtonCreateNewCategory();
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
}

