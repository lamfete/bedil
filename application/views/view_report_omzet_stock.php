<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backoffice/report_omzetstock.js"></script>

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
        <!--<button type="button" class="btn btn-lg" onclick="window.location.href='/accpayable/add'">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Create New Acc Payable
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

<div class="row">
    <div class="col-xs-12">
        <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>">
        <table id="tableReportOmzetStock" class="table table-striped table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Item ID</th>
                    <!-- <th>user_level_id</th> -->
                    <th>Item Name</th>
                    <th>Omzet IDR</th>
                    <!-- <th>Kirim Ke</th> -->
                    <!-- <th>Password</th> -->
                    <!-- <th>Item Name</th> -->
                    <!-- <th>Created At</th> -->
                    <!-- <th>Keterangan</th> -->
                    <!-- <th>Status</th> -->
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="lblAccPayableNo">Edit Acc Payable</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>"> <!-- userId yang login -->
                <input type="hidden" id="idItem"> <!-- itemId record yg hendak di edit -->
                
                <table id="tableEditAccPayable" class="table table-striped table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="1%"></th>
                            <th width="2%">ID Item</th>
                            <!-- <th>user_level_id</th> -->
                            <th width="14%">Name</th>
                            <th width="4%">Qty</th>
                            <th width="13%">Price</th>
                            <!-- <th>Password</th> -->
                            <th width="10%">Subtotal</th>
                            <th width="10%">Keterangan</th>
                            <!-- <th>Updated At</th>
                            <th>Status</th> -->
                            <th width="1%">Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateAccPayable" onclick="updateAccPayable()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Process Modal -->
<div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="lblProcessAccPayableNo">Process Acc Payable</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-xs-3">
                        <label for="lblSuppAddId">Supplier Address:</label>
                    </div>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" id="txtSuppAddId" onfocusout="enableButtonProceedAccPayable()" placeholder="Supplier Address ID">
                    </div>
                </div>
                <table id="tableProcessAccPayable" class="table table-striped table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="1%"></th>
                            <th width="2%">ID Item</th>
                            <!-- <th>user_level_id</th> -->
                            <th width="14%">Name</th>
                            <th width="4%">Qty</th>
                            <th width="13%">Price</th>
                            <!-- <th>Password</th> -->
                            <th width="10%">Subtotal</th>
                            <th width="10%">Keterangan</th>
                            <!-- <th>Updated At</th>
                            <th>Status</th> -->
                            <!-- <th width="1%">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnProceedAccPayable" onclick="proceedAp()">Proceed Acc Payable</button>
            </div>
        </div>
    </div>
</div>