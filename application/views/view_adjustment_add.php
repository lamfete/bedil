<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backoffice/adjustment.js"></script>

<div class="row">
    <div class="col-xs-12">
        <?php
            error_reporting(E_ALL & ~E_NOTICE);
            echo "Hello, user " . $name->name . ".<br />";
        ?>
        <!-- Button trigger modal -->
        <?php
            if($userlevel->user_level_id == 1) {
        ?>
        <!--<button type="button" class="btn btn-lg" data-toggle="modal" data-target="#createModal" onclick="clearCreateModalTextfield()">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Add New Sales
        </button>-->
        <?php
            }
        ?>
    </div>
</div>

<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-12">
        
    </div>
</div>

<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-2">
        <label for="lblAdjDate">Date:</label>
    </div>
    <div class="col-xs-10">
        <input type="date" class="form-control" id="txtAdjItemDate"  autofocus placeholder="Date">
    </div>
</div>
<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-2">
        <label for="lblAdjItemType">Type:</label>
    </div>
    <div class="col-xs-5">
        <input type="radio" class="btn btn-default" name="adjItemType" value='IN'> In
    </div>
    <div class="col-xs-5">
        <input type="radio" class="btn btn-default" name="adjItemType" value='OUT'> Out
    </div>
</div>
<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-2">
        <label for="lblItemId">Item ID:</label>
    </div>
    <div class="col-xs-10">
        <input type="text" class="form-control" id="txtAdjItemId" onclick="clearTxtAdjItemId()" placeholder="Item ID">
    </div>
</div>
<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-2">
        <label for="lblItemQty">Qty:</label>
    </div>
    <div class="col-xs-10">
        <input type="text" class="form-control" id="txtAdjItemQty" placeholder="Item Qty">
    </div>
</div>
<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-2">
        <label for="lblItemPrice">Price:</label>
    </div>
    <div class="col-xs-10">
        <input type="text" class="form-control" id="txtAdjItemPrice" data-a-sign="Rp. " data-a-dec="," data-a-sep="." placeholder="Item Price">
    </div>
</div>
<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-2">
        <label for="lblAdjItemNote">Note:</label>
    </div>
    <div class="col-xs-10">
        <input type="text" class="form-control" id="txtAdjItemNote" placeholder="Note">
    </div>
</div>


<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-12">
    <button type="button" class="btn btn-lg" onclick="addItemToTableItemAdjustment()">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        Add Item
    </button>
    </div>
</div>

<div class="row" style="margin-bottom:10px;">
    <div class="col-xs-12">
        
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
            <table id="tableItem" class="table table-striped table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID Item</th>
                        <!-- <th>user_level_id</th> -->
                        <th>Name</th>
                        <th>Adj Type</th>
                        <th style="width: 10%;">Qty</th>
                        <th>Price</th>
                        <!-- <th>Password</th> -->
                        <th>Subtotal</th>
                        <th>Keterangan</th>
                        <!-- <th>Updated At</th>
                        <th>Status</th> -->
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <!--<tfoot>
                        <tr>
                        <th>ID user</th>
                        <th>user_level_id</th>
                        <th>User Login</th>
                        <th>Name</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Level user</th>
                        <th>Action</th>
                    </tr>
                </tfoot>-->
            </table>
        </div>
</div>

<div class="row">
    <div class="col-xs-12" style="margin-bottom:10px;">
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <button type="button" class="btn btn-lg" onclick="createNewAdjustment()">
            <span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>
            Proceed
        </button>
    <!-- </div>
    <div class="col-xs-12"> -->
        <button type="button" class="btn btn-lg" onclick="window.location.href='/purchaseorder/manage'">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            Cancel
        </button>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        &nbsp;
    </div>
</div>