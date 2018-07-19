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
    $('#txtItemPrice').autoNumeric('init');
    var autoNumInput = $('#txtItemPrice').autoNumeric('init');

    $('#isAktif').prop('checked', true);
    
    $('#createNewItem').prop('disabled', true);

    // array untuk mengecek apakah semua field mandatory sudah diisi semua atau belum
    validation = [];
    cart = [];
    salesQuoteLine = [];
    salesQuote = [];
    
    // Initialization end here

    $('#tableSalesQuote').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "bAutowidth": false,
        "ajax": {
            //url: '<?php echo base_url('userexec/get_user'); ?>',
            url: '../salesquoteexec/get_sales_quote?type=datatables',
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
function enableButtonProceedSalesQuote() {

    if($('#txtCustAddId').val() == '') {
        $('#btnProceedSalesQuote').prop('disabled', true);
    }
    else {
        $('#btnProceedSalesQuote').prop('disabled', false);
    }
}

/*
 * function untuk mengisi modal edit sales quote
 * 
 * 
 * 
 */
function editSalesQuote(value) {
    // console.log(value);
    salesQuoteLine = [];
    $("#tableEditSalesQuote tbody tr").remove(); 
    // console.log(salesQuoteLine); // output: []
    
    var salesQuoteNo = value[0];
    // console.log(salesQuoteNo);
    $("#lblSalesQuoteNo").text("Edit Sales Quote " + salesQuoteNo);
    
    $.ajax({
        type: "POST",
        url: "../salesquoteexec/get_sales_quote_line",
        data: {
            salesQuoteNo: salesQuoteNo
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
                var subTotal = data.data[i].sales_quote_qty * data.data[i].sales_quote_price;

                // 2. memasukkan sales quote line ke dalam bentuk array (untuk simpan data)
                // init object
                var salesQuoteLineitem = {
                    salesQuoteLineId: data.data[i].item_id,
                    salesQuoteLinePrice: data.data[i].sales_quote_price,
                    salesQuoteLineQty: data.data[i].sales_quote_qty,
                    salesQuoteLineKet: data.data[i].keterangan
                };
                salesQuoteLine.push(salesQuoteLineitem);
            }
            
            console.log(salesQuoteLine);
            
            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].sales_quote_qty * data.data[i].sales_quote_price;

                // 1. memasukkan sales quote line ke dalam bentuk html (untuk tampilan)
                content +="<tr><td style='line-height:2.6;' id='lblIdItemEditLine"+ counter +"'>" + counter + "</td>";
                content +="<td style='line-height:2.6;' class='salesQuoteForRemove'  id='lblItemIdEditLine"+ counter +"'>" + data.data[i].item_id + "</td>";
                content +="<td style='line-height:2.6;' id='lblItemNameEditLine"+ counter +"'>" + data.data[i].item_name + "</td>";
                content +="<td><input type='text' id='txtItemQtyEditLine"+ counter +"' class='form-control' value='" + data.data[i].sales_quote_qty + "' onfocusout='editSalesQuoteLine("+counter+")'/></td>";
                content +="<td><input type='text' id='txtItemPriceEditLine"+ counter +"' class='form-control' value='" + accounting.formatMoney(data.data[i].sales_quote_price, "Rp. ", 2, ".", ",") + "' data-a-sign='Rp. ' data-a-dec=',' data-a-sep='.' onfocusout='editSalesQuoteLine("+counter+")'/></td>";
                content +="<td id='lblSubTotalEditLine"+ counter +"' style='line-height:2.6;'>" + accounting.formatMoney(subTotal, "Rp. ", 2, ".", ",") + "</td>";
                content +="<td><textarea id='txtItemKetLine"+ counter +"' class='form-control' onfocusout='editSalesQuoteLine("+counter+")'>" + data.data[i].keterangan + "</textarea></td>";
                content +="<td align='center' style='line-height:2.6;'><button type='button' class='btnRemoveSalesQuoteLine btn btn-link'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td></tr>";
            }

            $('#tableEditSalesQuote').append(content);

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
 * function untuk mengisi modal process sales quote
 * 
 * 
 * 
 */
function proceedSalesQuote(value) {
    // console.log(value);
    clearTxtCustAddId();
    var salesQuoteNo = value[0];
    var customerId = value[2];
    var keterangan = value[3];
    var userId = $('#userIdLogin').val();
    console.log(salesQuoteNo);

    $("#tableProcessSalesQuote tbody tr").remove(); 

    $("#lblProcessSalesQuoteNo").text("Process Sales Quote " + salesQuoteNo);
    
    $.ajax({
        type: "POST",
        url: "../salesquoteexec/get_sales_quote_line",
        data: {
            salesQuoteNo: salesQuoteNo
        },
        success: function(data){
            // console.log(data.data[0].brand_id);

            var content_process = '';

            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].sales_quote_qty * data.data[i].sales_quote_price;

                // 2. memasukkan sales quote line ke dalam bentuk array (untuk simpan data)
                // init object
                var salesQuoteLineitem = {
                    salesQuoteLineId: data.data[i].item_id,
                    salesQuoteLinePrice: data.data[i].sales_quote_price,
                    salesQuoteLineQty: data.data[i].sales_quote_qty,
                    salesQuoteLineKet: data.data[i].keterangan
                };
                salesQuoteLine.push(salesQuoteLineitem);
            }

            salesQuote = {
                salesQuoteNo: salesQuoteNo,
                customerId: customerId,
                keterangan: keterangan,
                salesQuoteLine: salesQuoteLine,
                userId: userId
            }
            
            // console.log(salesQuoteLine);
            
            for(var i=0;i<data.data.length;i++) {
                var counter = i+1;                
                var subTotal = data.data[i].sales_quote_qty * data.data[i].sales_quote_price;

                // 1. memasukkan sales quote line ke dalam bentuk html (untuk tampilan)
                content_process +="<tr><td style='line-height:2.6;' id='lblIdItemProcessLine"+ counter +"'>" + counter + "</td>";
                content_process +="<td style='line-height:2.6;' class='salesQuoteForRemove'  id='lblItemIdProcessLine"+ counter +"'>" + data.data[i].item_id + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemNameProcessLine"+ counter +"'>" + data.data[i].item_name + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemQtyProcessLine"+ counter +"'>" + data.data[i].sales_quote_qty + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemPriceProcessLine"+ counter +"' align='right'>" + accounting.formatMoney(data.data[i].sales_quote_price, "Rp. ", 2, ".", ",") + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblSubTotalEditLine"+ counter +"' align='right'>" + accounting.formatMoney(subTotal, "Rp. ", 2, ".", ",") + "</td>";
                content_process +="<td style='line-height:2.6;' id='lblItemKeteranganProcessLine"+ counter +"'>" + data.data[i].keterangan + "</td>";
            }

            $('#tableProcessSalesQuote').append(content_process);
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
function proceedSqToSo() {
    var salesQuoteNo = $("#lblProcessSalesQuoteNo").text().substring(20, 30);
    var custAddId = $("#txtCustAddId").val().substring(0, 10);
    // var customerId = salesQuoteLine[0].customerId;
    var customerId = salesQuote.customerId;
    var keterangan = salesQuote.keterangan;

    // var custAddId = $('#txtCustAddId').val();
    // console.log($("#lblSalesQuoteNo").text().substring(20, 30));
    // console.log(salesQuoteLine);
    // console.log(customerId);
    // console.log(custAddId);

    var updateRecord = confirm("Yakin Sales Quote " + salesQuoteNo + " diproses menjadi Sales Order?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "../salesquoteexec/proceed_sales_quote",
            data: {
                salesQuoteNo: salesQuoteNo,
                customerId: customerId,
                custAddId: custAddId,
                keterangan: keterangan,
                salesQuoteLine: salesQuoteLine,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                // window.location.href = '../salesquote/manage';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                // window.location.href = '../salesquote/manage';
            }
        });
    }
};

/*
 * function untuk remove <td> di edit sales quote
 * 
 * 
 */
$(document).on('click', 'button.btnRemoveSalesQuoteLine', function () {
    var itemId = $(this).closest('tr').find('.salesQuoteForRemove').text();
    // console.log(itemId);
    removeSalesQuoteLine(itemId);
     
    $(this).closest('tr').remove();
    return false;
});

/*
 * function untuk delete sales quote
 * 
 * 
 */
function deleteSalesQuote(value) {
    // console.log(value);

    var deleteRecord = confirm("Yakin hapus data sales quote " + value[0] + " dari database?");

    if(deleteRecord == true) {
        $.ajax({
            type: "POST",
            url: "../salesquoteexec/delete_sales_quote",
            data: {
                salesQuoteNo: value[0],
                salesQuoteCust: value[2],
                createdBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL DELETE USER");
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
};

function updateSalesQuote() {
    var salesQuoteNo = $("#lblSalesQuoteNo").text().substring(17, 27);
    // console.log($("#lblSalesQuoteNo").text().substring(17, 27));
    var updateRecord = confirm("Yakin update data Sales Quote " + salesQuoteNo + "?");

    if(updateRecord == true) {
        $.ajax({
            type: "POST",
            url: "../salesquoteexec/update_sales_quote",
            data: {
                salesQuoteNo: salesQuoteNo,
                salesQuoteLine: salesQuoteLine,
                updatedBy: $('#userIdLogin').val()
            },
            success: function(resp) {
                // alert("BERHASIL UPDATE USER");
                alert(resp.message);
                window.location.href = '../salesquote/manage';
            },
            error: function(resp) {
                // alert("something went wrong");
                alert('Error: ', resp.message);
                window.location.href = '../salesquote/manage';
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

function editSalesQuoteLine(paramIdItemTable) {
    hitungSubTotalSalesQuoteLine(paramIdItemTable);
    // console.log(cart[paramIdItemTable - 1].itemLineId);
    // console.log($('#lblItemIdLine' + paramIdItemTable).text());
    // console.log(salesQuoteLine);
    if (salesQuoteLine.filter(e => e.salesQuoteLineId === $('#lblItemIdEditLine' + paramIdItemTable).text()).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = salesQuoteLine.findIndex(x => x.salesQuoteLineId == $('#lblItemIdEditLine' + paramIdItemTable).text());
        // console.log(index);
        
        if(index > -1) {
            // remove element yg lama
            salesQuoteLine.splice(index, 1);

            // tambahkan itemLine yg sudah di edit ke dalam array
            salesQuoteItemId = $('#lblItemIdEditLine' + paramIdItemTable).text();
            salesQuoteItemPrice = $('#txtItemPriceEditLine'  + paramIdItemTable).autoNumeric('get');
            salesQuoteItemQty = $('#txtItemQtyEditLine' + paramIdItemTable).val();
            salesQuoteItemKet = $('#txtItemKetLine' + paramIdItemTable).val();

            // init object
            var salesQuoteItemLine = {
                salesQuoteLineId: salesQuoteItemId,
                salesQuoteLinePrice: salesQuoteItemPrice,
                salesQuoteLineQty: salesQuoteItemQty,
                salesQuoteLineKet: salesQuoteItemKet
            };

            salesQuoteLine.push(salesQuoteItemLine);
            console.log(salesQuoteLine);
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

function removeSalesQuoteLine(paramItemId) {
    console.log(paramItemId);
    if (salesQuoteLine.filter(e => e.salesQuoteLineId === paramItemId).length > -1) {
        // console.log("BARANG SUDAH ADA");
        var index = salesQuoteLine.findIndex(x => x.salesQuoteLineId == paramItemId);
        console.log(index);

        if(index > -1) {
            // remove element yg lama
            salesQuoteLine.splice(index, 1);
        }
        console.log(salesQuoteLine);
    }
}

function hitungSubTotal(paramIdItemTable) {
    // console.log($('#txtItemQtyLine' + (paramIdItemTable - 1)).val() * accounting.unformat($('#txtItemPriceLine' + (paramIdItemTable - 1)).val(), ","));
    // console.log(accounting.unformat($('#txtItemPriceLine').val(), ","));
    var subTotalPerLine = $('#txtItemQtyLine' + (paramIdItemTable)).val() * accounting.unformat($('#txtItemPriceLine' + (paramIdItemTable)).val(), ",");
    // console.log(accounting.formatMoney(subTotalPerLine, "Rp. ", 2, ".", ","));
    $('#lblSubTotal' + (paramIdItemTable)).html(accounting.formatMoney(subTotalPerLine, "Rp. ", 2, ".", ","));
}

function hitungSubTotalSalesQuoteLine(paramIdItemTable) {
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

