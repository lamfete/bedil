<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backoffice/master_supplier.js"></script>

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
        <button type="button" class="btn btn-lg" data-toggle="modal" data-target="#createModal" onclick="clearCreateModalTextfield()">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Add new supplier
        </button>
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
            <table id="table_supplier" class="table table-striped table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID supplier</th>
                        <!-- <th>user_level_id</th> -->
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Bank Acc</th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Created At</th> -->
                        <!-- <th>Updated At</th> -->
                        <!-- <th>Level user</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Supplier</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>"> <!-- userId yang login -->
                <input type="hidden" id="supplierId">
                <form>
                    <div class="form-group">
                        <label for="lblSupplierName">Supplier name</label>
                        <input type="text" class="form-control" id="txtSupplierNameEdit" placeholder="Supplier Name">
                    </div>
                    <div class="form-group">
                        <label for="lblAddress1">Address 1</label>
                        <input type="text" class="form-control" id="txtAddress1Edit" placeholder="Address 1">
                    </div>
                    <div class="form-group">
                        <label for="lblAddress2">Address 2</label>
                        <input type="text" class="form-control" id="txtAddress2Edit" placeholder="Address 2">
                    </div>
                    <div class="form-group">
                        <label for="lblPhone1">Phone 1</label>
                        <input type="text" class="form-control" id="txtPhone1Edit" placeholder="Phone 1">
                    </div>
                    <div class="form-group">
                        <label for="lblPhone2">Phone 2</label>
                        <input type="text" class="form-control" id="txtPhone2Edit" placeholder="Phone 2">
                    </div>
                    <div class="form-group">
                        <label for="lblEmail1">Email 1</label>
                        <input type="text" class="form-control" id="txtEmail1Edit" placeholder="Email 1">
                    </div>
                    <div class="form-group">
                        <label for="lblEmail2">Email</label>
                        <input type="text" class="form-control" id="txtEmail2Edit" placeholder="Email 2">
                    </div>
                    <div class="form-group">
                        <label for="lblBankAcc1">Bank Acc 1</label>
                        <input type="text" class="form-control" id="txtBankAcc1Edit" placeholder="Bank Acc 1">
                    </div>
                    <div class="form-group">
                        <label for="lblBankAcc2">Bank Acc 2</label>
                        <input type="text" class="form-control" id="txtBankAcc2Edit" placeholder="Bank Acc 2">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateSupplier" onclick="updateSupplier()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Supplier</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>">
                <form>
                    <div class="form-group">
                        <label for="lblSupplierName">Supplier name</label>
                        <input type="text" class="form-control" id="txtSupplierName" placeholder="Supplier Name" onfocusout="cekFormCreateNewSupplier('supplierName')">
                        <div class="alert alert-error" id="SupplierNameIsAlreadyTaken">
                            <!-- <span>Looks like the username you entered already taken!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblAddress1">Address 1</label>
                        <input type="text" class="form-control" id="txtAddress1" placeholder="Address 1">
                    </div>
                    <div class="form-group">
                        <label for="lblAddress2">Address 2</label>
                        <input type="text" class="form-control" id="txtAddress2" placeholder="Address 2">
                    </div>
                    <div class="form-group">
                        <label for="lblPhone1">Phone 1</label>
                        <input type="text" class="form-control" id="txtPhone1" placeholder="Phone 1">
                    </div>
                    <div class="form-group">
                        <label for="lblPhone2">Phone 2</label>
                        <input type="text" class="form-control" id="txtPhone2" placeholder="Phone 2">
                    </div>
                    <div class="form-group">
                        <label for="lblEmail1">Email 1</label>
                        <input type="text" class="form-control" id="txtEmail1" placeholder="Email 1">
                        <!-- <div class="alert alert-error" id="EmailIsAlreadyExist"> -->
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        <!-- </div> -->
                    </div>
                    <div class="form-group">
                        <label for="lblEmail2">Email</label>
                        <input type="text" class="form-control" id="txtEmail2" placeholder="Email 2">
                        <!--<div class="alert alert-error" id="EmailIsAlreadyExist"> -->
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        <!--</div>-->
                    </div>
                    <div class="form-group">
                        <label for="lblBankAcc1">Bank Acc 1</label>
                        <input type="text" class="form-control" id="txtBankAcc1" placeholder="Bank Acc 1">
                    </div>
                    <div class="form-group">
                        <label for="lblBankAcc2">Bank Acc 2</label>
                        <input type="text" class="form-control" id="txtBankAcc2" placeholder="Bank Acc 2">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createNewSupplier" onclick="createNewSupplier()">Save changes</button>
            </div>
        </div>
    </div>
</div>