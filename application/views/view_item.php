<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backoffice/master_item.js"></script>

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
            Add New Item
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
            <table id="tableItem" class="table table-striped table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID Item</th>
                        <!-- <th>user_level_id</th> -->
                        <th>Category</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <!-- <th>Password</th> -->
                        <th>Item Name</th>
                        <th>Created At</th>
                        <!-- <th>Updated At</th> -->
                        <th>Status</th>
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
                <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>"> <!-- userId yang login -->
                <input type="hidden" id="idItem"> <!-- itemId record yg hendak di edit -->
                <form>
                <div class="form-group">
                        <label for="lblCategory">Category</label>
                        <select class="form-control" id="DrdCategoryEdit" name="DrdCategoryEdit" onchange="getTypeItem()" onfocusout="cekFormCreateNewItem('category')">
                        </select>
                        <div class="alert alert-error" id="categoryEditIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblType">Type</label>
                        <select class="form-control" id="DrdTypeEdit" name="DrdTypeEdit" onchange="getBrandItem()"  onfocusout="cekFormCreateNewItem('type')">
                        </select>
                        <div class="alert alert-error" id="typeEditIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblBrand">Brand</label>
                        <select class="form-control" id="DrdBrandEdit" name="DrdBrandEdit" onfocusout="cekFormCreateNewItem('brand')">
                        </select>
                        <div class="alert alert-error" id="brandEditIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblItemName">Item Name</label>
                        <input type="text" class="form-control" id="txtItemEdit" placeholder="Item Name" onfocusout="cekFormCreateNewItem('itemname')">
                        <div class="alert alert-error" id="nameEditIsAlreadyTaken">
                            <!-- <span>Looks like the username you entered already taken!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblItemRemark">Remark</label>
                        <input type="text" class="form-control" id="txtItemRemarkEdit" placeholder="Item Remark">
                    </div>
                    
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" id="statusEdit" value="1"> Aktif
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateUser" onclick="updateItem()">Save changes</button>
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
                <h4 class="modal-title" id="myModalLabel">Create Item</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>">
                <form>
                    <div class="form-group">
                        <label for="lblCategory">Category</label>
                        <select class="form-control" id="DrdCategory" name="DrdCategory" onchange="getTypeItem()" onfocusout="cekFormCreateNewItem('category')">
                        </select>
                       <div class="alert alert-error" id="categoryIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblType">Type</label>
                        <select class="form-control" id="DrdType" name="DrdType" onchange="getBrandItem()"  onfocusout="cekFormCreateNewItem('type')">
                        </select>
                        <div class="alert alert-error" id="typeIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblBrand">Brand</label>
                        <select class="form-control" id="DrdBrand" name="DrdBrand" onfocusout="cekFormCreateNewItem('brand')">
                        </select>
                        <div class="alert alert-error" id="brandIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblItemName">Item Name</label>
                        <input type="text" class="form-control" id="txtItemName" placeholder="Item Name" onfocusout="cekFormCreateNewItem('itemname')">
                        <div class="alert alert-error" id="nameIsAlreadyTaken">
                            <!-- <span>Looks like the username you entered already taken!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblItemRemark">Remark</label>
                        <input type="text" class="form-control" id="txtItemRemark" placeholder="Item Remark">
                    </div>
                    
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" id="isAktif" value="1" checked="checked"> Aktif
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createNewItem" onclick="createNewItem()">Save changes</button>
            </div>
        </div>
    </div>
</div>