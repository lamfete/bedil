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

    $('#btnProceedSalesQuote').prop('disabled', true);

    // autoNumeric init
    $('#txtAdjItemPrice').autoNumeric('init');
    var autoNumInput = $('#txtAdjItemPrice').autoNumeric('init');

    $('#isAktif').prop('checked', true);
    
    $('#createNewItem').prop('disabled', true);

    // array untuk mengecek apakah semua field mandatory sudah diisi semua atau belum
    validation = [];
    cart = [];
    purchaseOrderLine = [];
    purchaseOrder = [];
    
    // Initialization end here

    $('#tableAdjustment').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: '../adjustmentexec/get_adjustment?type=datatables',
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
            // { "data": [7] }
            // { "data": [8] }
            // { "data": [9] },
            // { "data": [10] },
            // { "data": [11] },
            // { "data": [12] }
        ],
        "order": [[1, 'asc']]
    });

    $('#txtSuppId').autocomplete({
        serviceUrl: '../supplierexec/get_supplier_id?type=autocomplete',
        onSelect: function (suggestion) {
            var itemId = suggestion.value.substring(0, 10);
            // console.log(itemId);
            
            // function untuk mengisi harga sesuai dengan item_id yg dipilih
            // getPriceItem(itemId);
        }
    });

    $('#txtSuppAddId').autocomplete({
        serviceUrl: '../supplierexec/get_supplier_id?type=autocomplete',
        onSelect: function (suggestion) {
            var itemId = suggestion.value.substring(0, 10);
            // console.log(itemId);
            
            // function untuk mengisi harga sesuai dengan item_id yg dipilih
            // getPriceItem(itemId);
        }
    });

    $('#txtAdjItemId').autocomplete({
        serviceUrl: '../itemexec/get_id_item?type=autocomplete',
        onSelect: function (suggestion) {
            var itemId = suggestion.value.substring(0, 10);
            // console.log(itemId);
            
            // function untuk mengisi harga sesuai dengan item_id yg dipilih
            // getPriceItem(itemId);
        }
    });
} );

function clearTxtAdjItemId() {
    $('#txtAdjItemId').val('');
}

function clearAddItemAdjustmentTextfield() {
    clearTxtAdjItemId();
    $('#txtAdjItemDate').val('');
    $('#txtAdjItemPrice').val('');
    $('#txtAdjItemQty').val('');
    $('#txtAdjItemNote').val('');
    $('input:radio[name="adjItemType"]').prop('checked', false);
}

/*
 * Function enable tombol btnProceedSalesQuote
 * 
 * Yang di cek adalah field: customer address
 * 
 */
function enableButtonProceedPurchaseOrder() {

    if($('#txtSuppAddId').val() == '') {
        $('#btnProceedPurchaseOrder').prop('disabled', true);
    }
    else {
        $('#btnProceedPurchaseOrder').prop('disabled', false);
    }
}

/*
 * function untuk mengisi modal edit sales quote
 * 
 * 
 * 
 */
function editPurchaseOrder(value) {
    // console.log(value);
    purchaseOrderLine = [];
    $("#tableEditPurchaseOrder tbody tr").remove(); 
    // console.log(purchaseOrderLine); // output: []
    
    var purchaseOrderNo = value[0];
    // console.log(purchaseOrderNo);
    $("#lblPurchaseOrderNo").text("Edit Purchase Order " + purchaseOrderNo);
    
    $.ajax({
        type: "POST",
        url: "../purchaseorderexec/get_purchase_order_line",
        data: {
            purchaseOrderNo: purchaseOrderNo
        },
        success: function(data){
            // console.log(data.data[0].brand_id);
           
            /* ketika klik tombol edit sales quote, 2 hal yang dilakukan:
             * 1. memasukkan sales quote line ke dalam bentuk html (untuk tampilan)
             * 2. memasukkan sales quote line ke dalam bentuk array (untuk simpan data)
             */ 
            var content = '';

            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].purchase_order_qty * data.data[i].purchase_order_price;

                // 2. memasukkan sales quote line ke dalam bentuk array (untuk simpan data)
                // init object
                var purchaseOrderLineitem = {
                    purchaseOrderLineId: data.data[i].item_id,
                    purchaseOrderLinePrice: data.data[i].purchase_order_price,
                    purchaseOrderLineQty: data.data[i].purchase_order_qty,
                    purchaseOrderLineKet: data.data[i].keterangan
                };
                purchaseOrderLine.push(purchaseOrderLineitem);
            }
            
            console.log(purchaseOrderLine);
            
            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].purchase_order_qty * data.data[i].purchase_order_price;

                // 1. memasukkan sales quote line ke dalam bentuk html (untuk tampilan)
                content +="<tr><td style='line-height:2.6;' id='lblIdItemEditLine"+ counter +"'>" + counter + "</td>";
                content +="<td style='line-height:2.6;' class='purchaseOrderForRemove'  id='lblItemIdEditLine"+ counter +"'>" + data.data[i].item_id + "</td>";
                content +="<td style='line-height:2.6;' id='lblItemNameEditLine"+ counter +"'>" + data.data[i].item_name + "</td>";
                content +="<td><input type='text' id='txtItemQtyEditLine"+ counter +"' class='form-control' value='" + data.data[i].purchase_order_qty + "' onfocusout='editPurchaseOrderLine("+counter+")'/></td>";
                content +="<td><input type='text' id='txtItemPriceEditLine"+ counter +"' class='form-control' value='" + accounting.formatMoney(data.data[i].purchase_order_price, "Rp. ", 2, ".", ",") + "' data-a-sign='Rp. ' data-a-dec=',' data-a-sep='.' onfocusout='editPurchaseOrderLine("+counter+")'/></td>";
                content +="<td id='lblSubTotalEditLine"+ counter +"' style='line-height:2.6;'>" + accounting.formatMoney(subTotal, "Rp. ", 2, ".", ",") + "</td>";
                content +="<td><textarea id='txtItemKetLine"+ counter +"' class='form-control' onfocusout='editPurchaseOrderLine("+counter+")'>" + data.data[i].keterangan + "</textarea></td>";
                content +="<td align='center' style='line-height:2.6;'><button type='button' class='btnRemovePurchaseOrderLine btn btn-link'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td></tr>";
            }

            $('#tableEditPurchaseOrder').append(content);

            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;
                
                $('#txtItemPriceEditLine' + counter).autoNumeric('init');
            }
            // end here
        },
        error: function(data){
            console.log('Error:', data);
        }
    });
};

/*
 * function untuk mengisi modal process purchase order
 * 
 * 
 * 
 */
function proceedPurchaseOrder(value) {
    // console.log(value);
    // clearTxtSuppAddId();
    var purchaseOrderNo = value[0];
    var supplierId = value[2];
    var keterangan = value[3];
    var userId = $('#userIdLogin').val();
    console.log(purchaseOrderNo);

    $("#tableProcessPurchaseOrder tbody tr").remove(); 
    $("#txtSuppAddId").val(supplierId);
    $("#lblProcessPurchaseOrderNo").text("Process Sales Quote " + purchaseOrderNo);
    
    $.ajax({
        type: "POST",
        url: "../purchaseorderexec/get_purchase_order_line",
        data: {
            purchaseOrderNo: purchaseOrderNo
        },
        success: function(data){
            console.log(data.data.length);

            var content_process = '';

            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].purchase_order_qty * data.data[i].purchase_order_price;

                // 2. memasukkan sales quote line ke dalam bentuk array (untuk simpan data)
                // init object
                var purchaseOrderLineitem = {
                    purchaseOrderLineId: data.data[i].item_id,
                    purchaseOrderLinePrice: data.data[i].purchase_order_price,
                    purchaseOrderLineQty: data.data[i].purchase_order_qty,
                    purchaseOrderLineKet: data.data[i].keterangan
                };
                purchaseOrderLine.push(purchaseOrderLineitem);
            }

            purchaseOrder = {
                purchaseOrderNo: purchaseOrderNo,
                supplierId: supplierId,
                keterangan: keterangan,
                purchaseOrderLine: purchaseOrderLine,
                userId: userId
            }
            
            // console.log(purchaseOrderLine);
            
            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].purchase_order_qty * data.data[i].purchase_order_price;

                // 1. memasukkan sales quote line ke dalam bentuk html (untuk tampilan)
                content_process +="<tr><td style='line-height:2.6;' id='lblIdItemProcessLine"+ counter +"'>" + counter + "</td>";
                content_process +="<td style='line-height:2.6;' class='purchaseOrderForRemove'  id='lblItemIdProcessLine"+ counter +"'>" + data.data[i].item_id + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemNameProcessLine"+ counter +"'>" + data.data[i].item_name + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemQtyProcessLine"+ counter +"'>" + data.data[i].purchase_order_qty + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemPriceProcessLine"+ counter +"' align='right'>" + accounting.formatMoney(data.data[i].purchase_order_price, "Rp. ", 2, ".", ",") + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblSubTotalEditLine"+ counter +"' align='right'>" + accounting.formatMoney(subTotal, "Rp. ", 2, ".", ",") + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemKeteranganProcessLine"+ counter +"'>" + data.data[i].keterangan + "</td>";
            }

            $('#tableProcessPurchaseOrder').append(content_process);
            // end here
        },
        error: function(data){
            console.log('Error:', data);
        }
    });
};

/*
 * Function untuk memproses SQ menjadi SO
 * 
 */
function proceedPoToGr() {
    var purchaseOrderNo = $("#lblProcessPurchaseOrderNo").text().substring(20, 30);
    var supplierId = $("#txtSuppAddId").val().substring(0, 10);
    // var supplierId = purchaseOrderLine[0].supplierId;
    var supplierId = purchaseOrder.supplierId;
    var keterangan = purchaseOrder.keterangan;

    // var custAddId = $('#txtCustAddId').val();
    // console.log($("#lblPurchaseOrderNo").text().substring(20, 30));
    // console.log(purchaseOrderLine);
    // console.log(supplierId);
    // console.log(custAddId);

    var updateRecord = confirm("Yakin Purchase Order " + purchaseOrderNo + " diproses menjadi Good Receipt?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "../purchaseorderexec/proceed_purchase_order",
            data: {
                purchaseOrderNo: purchaseOrderNo,
                supplierId: supplierId,
                keterangan: keterangan,
                purchaseOrderLine: purchaseOrderLine,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '../purchaseorder/manage';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '../purchaseorder/manage';
            }
        });
    }
};

/*
 * function untuk remove <td> di edit sales quote
 * 
 * 
 */
$(document).on('click', 'button.btnRemovePurchaseOrderLine', function () {
    var itemId = $(this).closest('tr').find('.purchaseOrderForRemove').text();
    // console.log(itemId);
    removePurchaseOrderLine(itemId);
     
    $(this).closest('tr').remove();
    return false;
});

/*
 * function untuk delete purchase order
 * 
 * 
 */
function deleteAdjustment(value) {
    // console.log(value);

    var deleteRecord = confirm("Yakin hapus data adjustment " + value[0] + " dari database?");

    if(deleteRecord == true) {
        $.ajax({
            type: "POST",
            url: "../adjustmentexec/delete_adjustment",
            data: {
                kartuStokId: value[0],
                createdBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL DELETE USER");
                alert(resp.message);
                window.location.href = '/adjustment/manage';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/adjustment/manage';
            }
        });
    }
};

function updatePurchaseOrder() {
    var purchaseOrderNo = $("#lblPurchaseOrderNo").text().substring(20, 30);
    // console.log($("#lblSalesQuoteNo").text().substring(17, 27));
    var updateRecord = confirm("Yakin update data Purchase Order " + purchaseOrderNo + "?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "../purchaseorderexec/update_purchase_order",
            data: {
                purchaseOrderNo: purchaseOrderNo,
                purchaseOrderLine: purchaseOrderLine,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '../purchaseorder/manage';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '../purchaseorder/manage';
            }
        });
    }
};

var idAdjItemTableAdjItemAdjustment = 1;
function addItemToTableItemAdjustment() {
    var adjItemPrice = 0;
    var adjItemId = "";

    adjItemDate = $('#txtAdjItemDate').val();
    adjItemId = $('#txtAdjItemId').val().substring(0, 10);
    adjItemName = $('#txtAdjItemId').val().substring(13);
    adjItemType = $("input[name='adjItemType']:checked"). val();
    adjItemPrice = $('#txtAdjItemPrice').autoNumeric('get');
    adjItemQty = $('#txtAdjItemQty').val();
    adjItemKet = $('#txtAdjItemNote').val();

    // init object
    var adjItemLine = {
        adjItemLineDate: adjItemDate,
        adjItemLineId: adjItemId,
        adjItemLineType: adjItemType,
        adjItemLinePrice: adjItemPrice,
        adjItemLineQty: adjItemQty,
        adjItemLineKet: adjItemKet
    };

    // if($.inArray(itemId, cart) == -1) {
    if (cart.filter(e => e.adjItemLineId === adjItemId).length == 0) {
        // cart.push(adjItemId);    
        cart.push(adjItemLine); 
        // console.log(adjItemId);
        // console.log(adjItemName);
        // console.log($('#txtAdjItemPrice').autoNumeric('get'));
        var subTotal = $('#txtAdjItemQty').val() * $('#txtAdjItemPrice').autoNumeric('get');

        var data="<tr><td style='line-height:2.6;' id='lblIdAdjItemLine"+ idAdjItemTableAdjItemAdjustment +"'>" + idAdjItemTableAdjItemAdjustment + "</td>";
        data +="<td style='line-height:2.6;' class='itemIdForRemove'  id='lblAdjItemIdLine"+ idAdjItemTableAdjItemAdjustment +"'>" + adjItemId + "</td>";
        data +="<td style='line-height:2.6;' id='lblAdjItemNameLine"+ idAdjItemTableAdjItemAdjustment +"'>" + adjItemName + "</td>";
        data +="<td style='line-height:2.6;' id='lblAdjItemTypeLine"+ idAdjItemTableAdjItemAdjustment +"'>" + adjItemType + "</td>";
        data +="<td style='width=20%;'><input type='text' id='txtAdjItemQtyLine"+ idAdjItemTableAdjItemAdjustment +"' class='form-control' value='" + $('#txtAdjItemQty').val() + "' onfocusout='editItemLine("+idAdjItemTableAdjItemAdjustment+")'/></td>";
        data +="<td><input type='text' id='txtAdjItemPriceLine"+ idAdjItemTableAdjItemAdjustment +"' class='form-control' value='" + $('#txtAdjItemPrice').val() + "' data-a-sign='Rp. ' data-a-dec=',' data-a-sep='.' onfocusout='editItemLine("+idAdjItemTableAdjItemAdjustment+")'/></td>";
        data +="<td id='lblSubTotal"+ idAdjItemTableAdjItemAdjustment +"' style='line-height:2.6;'>" + accounting.formatMoney(subTotal, "Rp. ", 2, ".", ",") + "</td>";
        data +="<td><input type='text' id='txtItemKetLine"+ idAdjItemTableAdjItemAdjustment +"' class='form-control' value='" + $('#txtAdjItemNote').val() + "' onfocusout='editItemLine("+idAdjItemTableAdjItemAdjustment+")'/></td>";
        data +="<td align='center' style='line-height:2.6;'><button type='button' class='btnRemove btn btn-link'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td></tr>";
        $('#tableItem').append(data);
        $('#txtAdjItemPriceLine'+ idAdjItemTableAdjItemAdjustment).autoNumeric('init');
        idAdjItemTableAdjItemAdjustment++;

        // clear textfield
        clearAddItemAdjustmentTextfield();

        console.log(cart);
    }
    else {
        alert("Barang sudah ada.");
        clearAddItemAdjustmentTextfield();
        console.log(cart);
    }
}

$(document).on('click', 'button.btnRemove', function () {
    var itemId = $(this).closest('tr').find('.itemIdForRemove').text();
    // console.log(itemId);
    removeItemLine(itemId);
     
    $(this).closest('tr').remove();
    return false;
});

function editPurchaseOrderLine(paramIdItemTable) {
    hitungSubTotalPurchaseOrderLine(paramIdItemTable);
    // console.log(cart[paramIdItemTable - 1].itemLineId);
    // console.log($('#lblItemIdLine' + paramIdItemTable).text());
    // console.log(purchaseOrderLine);
    if (purchaseOrderLine.filter(e => e.purchaseOrderLineId === $('#lblItemIdEditLine' + paramIdItemTable).text()).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = purchaseOrderLine.findIndex(x => x.purchaseOrderLineId == $('#lblItemIdEditLine' + paramIdItemTable).text());
        // console.log(index);
        
        if(index > -1) {
            // remove element yg lama
            purchaseOrderLine.splice(index, 1);

            // tambahkan itemLine yg sudah di edit ke dalam array
            purchaseOrderItemId = $('#lblItemIdEditLine' + paramIdItemTable).text();
            purchaseOrderItemPrice = $('#txtItemPriceEditLine'  + paramIdItemTable).autoNumeric('get');
            purchaseOrderItemQty = $('#txtItemQtyEditLine' + paramIdItemTable).val();
            purchaseOrderItemKet = $('#txtItemKetLine' + paramIdItemTable).val();

            // init object
            var purchaseOrderItemLine = {
                purchaseOrderLineId: purchaseOrderItemId,
                purchaseOrderLinePrice: purchaseOrderItemPrice,
                purchaseOrderLineQty: purchaseOrderItemQty,
                purchaseOrderLineKet: purchaseOrderItemKet
            };

            purchaseOrderLine.push(purchaseOrderItemLine);
            console.log(purchaseOrderLine);
        }
    }
}

function editItemLine(paramIdItemTable) {
    hitungSubTotal(paramIdItemTable);
    // console.log(cart[paramIdItemTable - 1].adjItemLineId);
    // console.log($('#lblAdjItemIdLine' + paramIdItemTable).text());
    if (cart.filter(e => e.adjItemLineId === $('#lblIdAdjItemLine' + paramIdItemTable).text()).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = cart.findIndex(x => x.adjItemLineId == $('#lblAdjItemIdLine' + paramIdItemTable).text());
        console.log(cart);
        // console.log(index);

        if(index > -1) {
            // remove element yg lama
            cart.splice(index, 1);

            // tambahkan itemLine yg sudah di edit ke dalam array
            adjItemId = $('#lblIdAdjItemLine' + paramIdItemTable).text();
            adjItemType = $('#lblAdjItemTypeLine' + paramIdItemTable).text();
            adjItemPrice = $('#txtAdjItemPriceLine'  + paramIdItemTable).autoNumeric('get');
            adjItemQty = $('#txtAdjItemQtyLine' + paramIdItemTable).val();
            adjItemKet = $('#txtItemKetLine' + paramIdItemTable).val();

            // init object
            var adjItemLine = {
                adjItemLineType: adjItemType,
                adjItemLineId: adjItemId,
                adjItemLinePrice: adjItemPrice,
                adjItemLineQty: adjItemQty,
                adjItemLineKet: adjItemKet
            };

            cart.push(adjItemLine);
            console.log(cart);
        }
    }
}

function removeItemLine(paramItemId) {
    // console.log(paramItemId);
    if (cart.filter(e => e.itemLineId === paramItemId).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = cart.findIndex(x => x.itemLineId == paramItemId);
        console.log(index);

        if(index > -1) {
            // remove element yg lama
            cart.splice(index, 1);
        }
        console.log(cart);
    }
}

function removePurchaseOrderLine(paramItemId) {
    console.log(paramItemId);
    if (purchaseOrderLine.filter(e => e.purchaseOrderLineId === paramItemId).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = purchaseOrderLine.findIndex(x => x.purchaseOrderLineId == paramItemId);
        console.log(index);

        if(index > -1) {
            // remove element yg lama
            purchaseOrderLine.splice(index, 1);
        }
        console.log(purchaseOrderLine);
    }
}

function hitungSubTotal(paramIdItemTable) {
    // console.log($('#txtItemQtyLine' + (paramIdItemTable - 1)).val() * accounting.unformat($('#txtItemPriceLine' + (paramIdItemTable - 1)).val(), ","));
    // console.log(accounting.unformat($('#txtItemPriceLine').val(), ","));
    var subTotalPerLine = $('#txtAdjItemQtyLine' + (paramIdItemTable)).val() * accounting.unformat($('#txtAdjItemPriceLine' + (paramIdItemTable)).val(), ",");
    // console.log(accounting.formatMoney(subTotalPerLine, "Rp. ", 2, ".", ","));
    $('#lblSubTotal' + (paramIdItemTable)).html(accounting.formatMoney(subTotalPerLine, "Rp. ", 2, ".", ","));
}

function hitungSubTotalPurchaseOrderLine(paramIdItemTable) {
    var subTotalPurchaseOrder = $('#txtAdjItemQtyEditLine' + (paramIdItemTable)).val() * accounting.unformat($('#txtAdjItemPriceEditLine' + (paramIdItemTable)).val(), ",");
    $('#lblSubTotalEditLine' + (paramIdItemTable)).html(accounting.formatMoney(subTotalPurchaseOrder, "Rp. ", 2, ".", ","));
}

/*
 * Function untuk mengecek field username dan email sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function createNewAdjustment() {
    // console.log(cart);
    
    $.ajax({
        type: "POST",
        url: "../adjustmentexec/create_new_adjustment",
        data: {
            adjustmentLine: cart
             // kirim dari dari javascript dalam bentuk array of object, diterima oleh PHP array of array
        },
        success: function(resp) {
            // alert("SUKSES BUAT USER BARU");
            alert(resp.message);
            window.location.href = '/adjustment/manage';
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.message);
            window.location.href = '/adjustment/manage';
        }
    }); 
}

