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

    $('#btnProceedSalesOrder').prop('disabled', true);

    // autoNumeric init
    $('#txtItemPrice').autoNumeric('init');
    var autoNumInput = $('#txtItemPrice').autoNumeric('init');

    $('#isAktif').prop('checked', true);
    
    $('#createNewItem').prop('disabled', true);

    // array untuk mengecek apakah semua field mandatory sudah diisi semua atau belum
    validation = [];
    cart = [];
    salesOrderLine = [];
    salesOrder = [];
    
    // Initialization end here

    $('#tableSalesOrder').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: '../salesorderexec/get_sales_order?type=datatables',
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
            // { "data": [8] },
            // { "data": [9] },
            // { "data": [10] },
            // { "data": [11] },
            // { "data": [12] }
        ],
        "order": [[1, 'asc']]
    });

    $('#txtCustId').autocomplete({
        serviceUrl: '../customerexec/get_customer_id?type=autocomplete',
        onSelect: function (suggestion) {
            var itemId = suggestion.value.substring(0, 10);
            // console.log(itemId);
            
            // function untuk mengisi harga sesuai dengan item_id yg dipilih
            // getPriceItem(itemId);
        }
    });

    $('#txtCustAddId').autocomplete({
        serviceUrl: '../customerexec/get_customer_address_id?type=autocomplete',
        onSelect: function (suggestion) {
            var itemId = suggestion.value.substring(0, 10);
            // console.log(itemId);
            
            // function untuk mengisi harga sesuai dengan item_id yg dipilih
            // getPriceItem(itemId);
        }
    });

    $('#txtItemId').autocomplete({
        serviceUrl: '../itemexec/get_id_item?type=autocomplete',
        onSelect: function (suggestion) {
            var itemId = suggestion.value.substring(0, 10);
            // console.log(itemId);
            
            // function untuk mengisi harga sesuai dengan item_id yg dipilih
            // getPriceItem(itemId);
        }
    });
} );

function clearTxtCustId() {
    $('#txtItemId').val('');
}

function clearTxtCustAddId() {
    $('#txtCustAddId').val('');
}

function clearTxtItemId() {
    $('#txtItemId').val('');
}

/*
 * Function enable tombol btnProceedSalesQuote
 * 
 * Yang di cek adalah field: customer address
 * 
 */
function enableButtonProceedSalesOrder() {

    if($('#txtCustAddId').val() == '') {
        $('#btnProceedSalesOrder').prop('disabled', true);
    }
    else {
        $('#btnProceedSalesOrder').prop('disabled', false);
    }
}

/*
 * function untuk mengisi modal edit sales quote
 * 
 * 
 * 
 */
function editSalesOrder(value) {
    // console.log(value);
    // salesOrderLine = [];
    $("#tableEditSalesOrder tbody tr").remove(); 
    // console.log(salesQuoteLine); // output: []
    
    var salesOrderNo = value[0];
    console.log(salesOrderNo);
    $("#lblSalesOrderNo").text("Proceed Sales Order " + salesOrderNo);
    
    $.ajax({
        type: "POST",
        url: "../salesorderexec/get_sales_order_line",
        data: {
            salesOrderNo: salesOrderNo
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
                var subTotal = data.data[i].sales_order_qty * data.data[i].sales_order_price;

                // 2. memasukkan sales quote line ke dalam bentuk array (untuk simpan data)
                // init object
                var salesOrderLineitem = {
                    salesOrderLineId: data.data[i].item_id,
                    salesOrderLinePrice: data.data[i].sales_order_price,
                    salesOrderLineQty: data.data[i].sales_order_qty,
                    salesOrderLineKet: data.data[i].keterangan
                };
                salesOrderLine.push(salesOrderLineitem);
            }
            
            console.log(salesOrderLine);
            
            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].sales_order_qty * data.data[i].sales_order_price;

                // 1. memasukkan sales quote line ke dalam bentuk html (untuk tampilan)
                content +="<tr><td style='line-height:2.6;' id='lblIdItemEditLine"+ counter +"'>" + counter + "</td>";
                content +="<td style='line-height:2.6;' class='salesOrderForRemove'  id='lblItemIdEditLine"+ counter +"'>" + data.data[i].item_id + "</td>";
                content +="<td style='line-height:2.6;' id='lblItemNameEditLine"+ counter +"'>" + data.data[i].item_name + "</td>";
                content +="<td><input type='text' id='txtItemQtyEditLine"+ counter +"' class='form-control' value='" + data.data[i].sales_order_qty + "' onfocusout='editSalesOrderLine("+counter+")'/></td>";
                content +="<td><input type='text' id='txtItemPriceEditLine"+ counter +"' class='form-control' value='" + accounting.formatMoney(data.data[i].sales_order_price, "Rp. ", 2, ".", ",") + "' data-a-sign='Rp. ' data-a-dec=',' data-a-sep='.' onfocusout='editSalesOrderLine("+counter+")'/></td>";
                content +="<td id='lblSubTotalEditLine"+ counter +"' style='line-height:2.6;'>" + accounting.formatMoney(subTotal, "Rp. ", 2, ".", ",") + "</td>";
                content +="<td><textarea id='txtItemKetLine"+ counter +"' class='form-control' onfocusout='editSalesOrderLine("+counter+")'>" + data.data[i].keterangan + "</textarea></td>";
                content +="<td align='center' style='line-height:2.6;'><button type='button' class='btnRemoveSalesOrderLine btn btn-link'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td></tr>";
            }

            $('#tableEditSalesOrder').append(content);

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
 * function untuk mengisi modal process sales order
 * 
 * 
 * 
 */
function proceedSalesOrder(value) {
    // console.log(value);
    clearTxtCustAddId();
    var salesOrderNo = value[0];
    var customerId = value[2];
    var customerAddId = value[3];
    var keterangan = value[4];
    var userId = $('#userIdLogin').val();
    console.log(salesOrderNo);

    $("#tableProcessSalesOrder tbody tr").remove(); 

    $("#lblProcessSalesOrderNo").text("Process Sales Order " + salesOrderNo);
    // $('#txtCustAddId').val(customerAddId);

    $.ajax({
        type: "POST",
        url: "../customerexec/get_customer_address_id?type=modal&query=" + customerAddId,
        data: {
            customerAddId: customerAddId
        },
        success: function(data){
            $('#txtCustAddId').val(data.suggestions);
            // console.log(data.suggestions);
            enableButtonProceedSalesOrder();
        },
        error: function(data){
            console.log('Error:', data);
        }
    });
    
    $.ajax({
        type: "POST",
        url: "../salesorderexec/get_sales_order_line",
        data: {
            salesOrderNo: salesOrderNo
        },
        success: function(data){
            // console.log(data);

            var content_process = '';

            for(var i=0;i<data.count;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].sales_order_qty * data.data[i].sales_order_price;

                // 2. memasukkan sales order line ke dalam bentuk array (untuk simpan data)
                // init object
                var salesOrderLineitem = {
                    salesOrderLineId: data.data[i].item_id,
                    salesOrderLinePrice: data.data[i].sales_order_price,
                    salesOrderLineQty: data.data[i].sales_order_qty,
                    salesOrderLineKet: data.data[i].keterangan
                };
                salesOrderLine.push(salesOrderLineitem);
            }

            salesOrder = {
                salesOrderNo: salesOrderNo,
                customerId: customerId,
                keterangan: keterangan,
                salesOrderLine: salesOrderLine,
                userId: userId
            }
            
            // console.log(salesQuoteLine);
            
            for(var i=0;i<data.count;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].sales_order_qty * data.data[i].sales_order_price;

                // 1. memasukkan sales quote line ke dalam bentuk html (untuk tampilan)
                content_process +="<tr><td style='line-height:2.6;' id='lblIdItemProcessLine"+ counter +"'>" + counter + "</td>";
                content_process +="<td style='line-height:2.6;' class='salesOrderForRemove'  id='lblItemIdProcessLine"+ counter +"'>" + data.data[i].item_id + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemNameProcessLine"+ counter +"'>" + data.data[i].item_name + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemQtyProcessLine"+ counter +"'>" + data.data[i].sales_order_qty + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemPriceProcessLine"+ counter +"' align='right'>" + accounting.formatMoney(data.data[i].sales_order_price, "Rp. ", 2, ".", ",") + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblSubTotalEditLine"+ counter +"' align='right'>" + accounting.formatMoney(subTotal, "Rp. ", 2, ".", ",") + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemKeteranganProcessLine"+ counter +"'>" + data.data[i].keterangan + "</td>";
            }

            $('#tableProcessSalesOrder').append(content_process);
            // end here
        },
        error: function(data){
            console.log('Error:', data);
        }
    });
};

/*
 * Function untuk memproses SO menjadi Shipper
 * 
 */
function proceedSoToShipper() {
    var salesOrderNo = $("#lblProcessSalesOrderNo").text().substring(20, 30);
    var custAddId = $("#txtCustAddId").val().substring(0, 10);
    // var customerId = salesQuoteLine[0].customerId;
    var customerId = salesOrder.customerId;
    var keterangan = salesOrder.keterangan;

    // var custAddId = $('#txtCustAddId').val();
    // console.log($("#lblSalesQuoteNo").text().substring(20, 30));
    // console.log(salesQuoteLine);
    // console.log(customerId);
    // console.log(custAddId);

    var updateRecord = confirm("Yakin Sales Order " + salesOrderNo + " diproses menjadi Sales Shipper?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "../salesorderexec/proceed_sales_order",
            data: {
                salesOrderNo: salesOrderNo,
                customerId: customerId,
                custAddId: custAddId,
                keterangan: keterangan,
                salesOrderLine: salesOrderLine,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '../salesorder/manage';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '../salesorder/manage';
            }
        });
    }
};

/*
 * function untuk remove <td> di edit sales quote
 * 
 * 
 */
$(document).on('click', 'button.btnRemoveSalesOrderLine', function () {
    var itemId = $(this).closest('tr').find('.salesOrderForRemove').text();
    // console.log(itemId);
    removeSalesOrderLine(itemId);
     
    $(this).closest('tr').remove();
    return false;
});

/*
 * function untuk delete sales order
 * 
 * 
 */
function deleteSalesOrder(value) {
    // console.log(value);

    var deleteRecord = confirm("Yakin hapus data sales order " + value[0] + " dari database?");

    if(deleteRecord == true) {
        $.ajax({
            type: "POST",
            url: "../salesorderexec/delete_sales_order",
            data: {
                salesOrderNo: value[0],
                salesOrderCust: value[2],
                createdBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL DELETE USER");
                alert(resp.message);
                window.location.href = '/salesorder/manage';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '/salesorder/manage';
            }
        });
    }
};

function updateSalesOrder() {
    var salesOrderNo = $("#lblSalesOrderNo").text().substring(20, 30);
    // console.log($("#lblSalesQuoteNo").text().substring(17, 27));
    var updateRecord = confirm("Yakin update data Sales Order " + salesOrderNo + "?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "../salesorderexec/update_sales_order",
            data: {
                salesOrderNo: salesOrderNo,
                salesOrderLine: salesOrderLine,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '../salesorder/manage';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '../salesorder/manage';
            }
        });
    }
};

var idItemTableItemSales = 1;
function addItemToTableItemSales() {
    var itemPrice = 0;
    var itemId = "";

    itemId = $('#txtItemId').val().substring(0, 10);
    itemName = $('#txtItemId').val().substring(13);
    itemPrice = $('#txtItemPrice').autoNumeric('get');
    itemQty = $('#txtItemQty').val();
    itemKet = '-';

    // init object
    var itemLine = {
        itemLineId: itemId,
        itemLinePrice: itemPrice,
        itemLineQty: itemQty,
        itemLineKet: itemKet
    };

    // if($.inArray(itemId, cart) == -1) {
    if (cart.filter(e => e.itemLineId === itemId).length == 0) {
        // cart.push(itemId);    
        cart.push(itemLine); 
        // console.log(itemId);
        // console.log(itemName);
        // console.log($('#txtItemPrice').autoNumeric('get'));
        var subTotal = $('#txtItemQty').val() * $('#txtItemPrice').autoNumeric('get');

        var data="<tr><td style='line-height:2.6;' id='lblIdItemLine"+ idItemTableItemSales +"'>" + idItemTableItemSales + "</td>";
        data +="<td style='line-height:2.6;' class='itemIdForRemove'  id='lblItemIdLine"+ idItemTableItemSales +"'>" + itemId + "</td>";
        data +="<td style='line-height:2.6;' id='lblItemNameLine"+ idItemTableItemSales +"'>" + itemName + "</td>";
        data +="<td><input type='text' id='txtItemQtyLine"+ idItemTableItemSales +"' class='form-control' value='" + $('#txtItemQty').val() + "' onfocusout='editItemLine("+idItemTableItemSales+")'/></td>";
        data +="<td><input type='text' id='txtItemPriceLine"+ idItemTableItemSales +"' class='form-control' value='" + $('#txtItemPrice').val() + "' data-a-sign='Rp. ' data-a-dec=',' data-a-sep='.' onfocusout='editItemLine("+idItemTableItemSales+")'/></td>";
        data +="<td id='lblSubTotal"+ idItemTableItemSales +"' style='line-height:2.6;'>" + accounting.formatMoney(subTotal, "Rp. ", 2, ".", ",") + "</td>";
        data +="<td><input type='text' id='txtItemKetLine"+ idItemTableItemSales +"' class='form-control' value='-' onfocusout='editItemLine("+idItemTableItemSales+")'/></td>";
        data +="<td align='center' style='line-height:2.6;'><button type='button' class='btnRemove btn btn-link'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td></tr>";
        $('#tableItem').append(data);
        $('#txtItemPriceLine'+ idItemTableItemSales).autoNumeric('init');
        idItemTableItemSales++;

        // clear textfield
        clearAddItemSaleTextfield();

        console.log(cart);
    }
    else {
        alert("Barang sudah ada.");
        clearAddItemSaleTextfield();
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

function editSalesOrderLine(paramIdItemTable) {
    hitungSubTotalSalesOrderLine(paramIdItemTable);
    // console.log(cart[paramIdItemTable - 1].itemLineId);
    // console.log($('#lblItemIdLine' + paramIdItemTable).text());
    // console.log(salesQuoteLine);
    if (salesOrderLine.filter(e => e.salesOrderLineId === $('#lblItemIdEditLine' + paramIdItemTable).text()).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = salesOrderLine.findIndex(x => x.salesOrderLineId == $('#lblItemIdEditLine' + paramIdItemTable).text());
        // console.log(index);
        
        if(index > -1) {
            // remove element yg lama
            salesOrderLine.splice(index, 1);

            // tambahkan itemLine yg sudah di edit ke dalam array
            salesOrderItemId = $('#lblItemIdEditLine' + paramIdItemTable).text();
            salesOrderItemPrice = $('#txtItemPriceEditLine'  + paramIdItemTable).autoNumeric('get');
            salesOrderItemQty = $('#txtItemQtyEditLine' + paramIdItemTable).val();
            salesOrderItemKet = $('#txtItemKetLine' + paramIdItemTable).val();

            // init object
            var salesOrderItemLine = {
                salesOrderLineId: salesOrderItemId,
                salesOrderLinePrice: salesOrderItemPrice,
                salesOrderLineQty: salesOrderItemQty,
                salesOrderLineKet: salesOrderItemKet
            };

            salesOrderLine.push(salesOrderItemLine);
            console.log(salesOrderLine);
        }
    }
}

function editItemLine(paramIdItemTable) {
    hitungSubTotal(paramIdItemTable);
    // console.log(cart[paramIdItemTable - 1].itemLineId);
    // console.log($('#lblItemIdLine' + paramIdItemTable).text());
    if (cart.filter(e => e.itemLineId === $('#lblItemIdLine' + paramIdItemTable).text()).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = cart.findIndex(x => x.itemLineId == $('#lblItemIdLine' + paramIdItemTable).text());
        // console.log(index);

        if(index > -1) {
            // remove element yg lama
            cart.splice(index, 1);

            // tambahkan itemLine yg sudah di edit ke dalam array
            itemId = $('#lblItemIdLine' + paramIdItemTable).text();
            itemPrice = $('#txtItemPriceLine'  + paramIdItemTable).autoNumeric('get');
            itemQty = $('#txtItemQtyLine' + paramIdItemTable).val();
            itemKet = $('#txtItemKetLine' + paramIdItemTable).val();

            // init object
            var itemLine = {
                itemLineId: itemId,
                itemLinePrice: itemPrice,
                itemLineQty: itemQty,
                itemLineKet: itemKet
            };

            cart.push(itemLine);
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

function removeSalesOrderLine(paramItemId) {
    console.log(paramItemId);
    if (salesOrderLine.filter(e => e.salesOrderLineId === paramItemId).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = salesOrderLine.findIndex(x => x.salesOrderLineId == paramItemId);
        console.log(index);

        if(index > -1) {
            // remove element yg lama
            salesOrderLine.splice(index, 1);
        }
        console.log(salesOrderLine);
    }
}

function hitungSubTotal(paramIdItemTable) {
    // console.log($('#txtItemQtyLine' + (paramIdItemTable - 1)).val() * accounting.unformat($('#txtItemPriceLine' + (paramIdItemTable - 1)).val(), ","));
    // console.log(accounting.unformat($('#txtItemPriceLine').val(), ","));
    var subTotalPerLine = $('#txtItemQtyLine' + (paramIdItemTable)).val() * accounting.unformat($('#txtItemPriceLine' + (paramIdItemTable)).val(), ",");
    // console.log(accounting.formatMoney(subTotalPerLine, "Rp. ", 2, ".", ","));
    $('#lblSubTotal' + (paramIdItemTable)).html(accounting.formatMoney(subTotalPerLine, "Rp. ", 2, ".", ","));
}

function hitungSubTotalSalesOrderLine(paramIdItemTable) {
    var subTotalSalesQuote = $('#txtItemQtyEditLine' + (paramIdItemTable)).val() * accounting.unformat($('#txtItemPriceEditLine' + (paramIdItemTable)).val(), ",");
    $('#lblSubTotalEditLine' + (paramIdItemTable)).html(accounting.formatMoney(subTotalSalesQuote, "Rp. ", 2, ".", ","));
}

/*
 * Function untuk mengecek field username dan email sudah ada atau belum di database
 * 
 * Function untuk mengecek sudah memilih user level atau belum
 * 
 */
function createNewSalesQuote() {
    console.log(cart);
    customerId = $('#txtCustId').val().substring(0, 10);
    keterangan = $('#txtKeterangan').val();
    $.ajax({
        type: "POST",
        url: "../salesquoteexec/create_new_sales_quote",
        /*data: {
            itemCat: category,
            itemType: type,
            itemBrand: brand,
            itemName: itemname,
            remark: remark,
            isAktif: isaktif,
            createdBy: createdby
        },*/
        data: {
            customerId: customerId,
            shoppingCart: cart,
            keterangan: keterangan
             // kirim dari dari javascript dalam bentuk array of object, diterima oleh PHP array of array
        },
        success: function(resp) {
            // alert("SUKSES BUAT USER BARU");
            alert(resp.message);
            window.location.href = '/salesquote/manage';
        },
        error: function(resp) {
            // alert("something went wrong");
            alert('Error: ', resp.message);
            window.location.href = '/salesquote/manage';
        }
    }); 
}

