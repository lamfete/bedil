/*
 * Function untuk meremove element dalam array
 * 
 * 
 * 
 */
function removeElementOfArray(arr, val) {
    var j = 0;
    for (var i = 0, l = arr.length; i < l; i++) {
        if (arr[i] !== val) {
        arr[j++] = arr[i];
        }
    }
    arr.length = j;
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