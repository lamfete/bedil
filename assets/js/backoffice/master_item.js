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

    $('#tableItem').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: 'itemexec/get_item',
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
            { "data": [6] },
            { "data": [7] }
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
// untuk modal create item
$.ajax({
    type: "POST",
    url: "itemexec/get_cat_item",
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

// untuk modal edit item
$.ajax({
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

    enableButtonCreateNewItem();    
}

/*
 * 
 * 
 * 
 * 
 */
function createNewItem() {
    var createdby = $('#userIdLogin').val();
    var category = $("#DrdCategory").val();
    var type = $("#DrdType").val();
    var brand = $("#DrdBrand").val();
    var itemname = $("#txtItemName").val();
    var remark = $("#txtItemRemark").val();
    var isaktif = "";

    if($("#txtItemRemark").val() == '') {
        remark = "-";
    }

    if($('#isAktif').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }

    $.ajax({
        type: "POST",
        url: "itemexec/create_new_item",
        data: {
            itemCat: category,
            itemType: type,
            itemBrand: brand,
            itemName: itemname,
            remark: remark,
            isAktif: isaktif,
            createdBy: createdby
        },
        success: function(resp) {
            // alert("SUKSES BUAT USER BARU");
            alert(resp.message);
            window.location.href = '/item';
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.message);
            window.location.href = '/item';
        }
    });
}

/*
 * function untuk mengisi modal edit item
 * 
 * 
 * 
 */
function editItem(value) {
    // console.log(value);

    var iditem = value[0];
    // console.log(iditem);
    
    $.ajax({
        type: "POST",
        url: "itemexec/get_item_detail",
        data: {
            idItem: iditem
        },
        success: function(data){
            // console.log(data.data[0].brand_id);
            
            getTypeItem(data.data[0]);
            getBrandItem(data.data[0]);
            
            //set dropdown sesuai dengan record yg mau di edit
            $('#idItem').val(iditem);
            $('#DrdCategoryEdit').val(data.data[0].category_id);
            $('#txtItemEdit').val(data.data[0].item_name);
            $('#txtItemRemarkEdit').val(data.data[0].item_remark);
            
            if(data.data[0].item_status == 'AKTIF') {
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
    
    /*$.ajax({
        type: "POST",
        url: "itemexec/get_type_item?param=createmodal",
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
    });*/

    $('#DrdCategoryEdit').val(value[1]);
    $('#txtItemEdit').val(value[2]);
    $('#txtNameEdit').val(value[3]);
    $('#txtEmailEdit').val(value[4]);
    if(value[6]=='AKTIF'){  
        $('#statusEdit').prop('checked', true);
    }
    else {
        $('#statusEdit').prop('checked', false);
    }
};

/*
 * function untuk delete item
 * 
 * 
 */
function deleteItem(value) {
    // console.log(value[4]);

    var deleteRecord = confirm("Yakin hapus data item " + value[2] + " dari database?");

    if(deleteRecord == true) {
        $.ajax({
            type: "POST",
            url: "userexec/delete_user",
            data: {
                userId: value[0],
                userLogin: value[2],
                createdBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL DELETE USER");
                alert(resp.message);
                window.location.href = '/item';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/item';
            }
        });
    }
};

function updateItem() {
    var isaktif = "";

    if($('#statusEdit').is(':checked')) {
        isaktif = "AKTIF";
    } else {
        isaktif = "INAKTIF";
    }
    // console.log($('#userIdLogin').val() + ' ; ' + $('#idUser').val() + ' ; ' + $('#txtUserloginEdit').val() + ' ; ' + $('#name').val() + ' ; ' + $('#email').val() + ' ; ' + isaktif);
    var updateRecord = confirm("Yakin update data user " + $('#txtItemEdit').val() + "?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "itemexec/update_item",
            data: {
                itemId: $('#idItem').val(),
                categoryId: $('#DrdCategoryEdit').val(),
                typeId: $('#DrdTypeEdit').val(),
                brandId: $('#DrdBrandEdit').val(),
                itemName: $('#txtItemEdit').val(),
                itemRemark: $('#txtItemRemarkEdit').val(),
                itemStatus: isaktif,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '/item';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/item';
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
function enableButtonCreateNewItem() {
    console.log("validation.length: " + validation.length);
    if(validation.length == 4) {
        $('#createNewItem').prop('disabled', false);
    }
    else {
        $('#createNewItem').prop('disabled', true);
    }
}

/*
 * Function untuk mengecek field username dan email sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function cekFormCreateNewItem(param) {
    if(param=='itemname') {
        var category = $("#DrdCategory").val();
        var type = $("#DrdType").val();
        var brand = $("#DrdBrand").val();
        var itemname = $("#txtItemName").val();

        if(itemname == '' && $.inArray(param, validation) > -1) {
            removeElementOfArray(validation, param);
            console.log(validation);
        } else {
            $.ajax({
                type: "POST",
                url: "itemexec/cek_item?param=item",
                data: {
                    itemName: itemname,
                    itemCat: category,
                    itemType: type,
                    itemBrand: brand
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
                        enableButtonCreateNewItem();
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
    else if(param=="brand") {
        var brand = $("#DrdBrand").val();
        // console.log(userLevel);
        
        if(brand == 0) {
            if($.inArray(param, validation) > -1) {
                removeElementOfArray(validation, param);
                enableButtonCreateNewItem();
                console.log(validation);
            } else {
                $("#brandIsNull").html("<span>Must choose one!</span>");
                $("#brandIsNull").show();
            }
        } else {
            $('#brandIsNull').hide();

            if($.inArray(param, validation) == -1) {
                validation.push(param);    
            }

            console.log(validation);
            enableButtonCreateNewItem();
        }
    }
}

