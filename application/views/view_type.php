<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backoffice/master_type.js"></script>

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
            Add New Type
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
            <table id="tableType" class="table table-striped table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID Type</th>
                        <!-- <th>user_level_id</th> -->
                        <!-- <th>Password</th> -->
                        <th>Category Name</th>
                        <th>Type Name</th>
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
                <h4 class="modal-title" id="myModalLabel">Edit Type</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>"> <!-- userId yang login -->
                <input type="hidden" id="idType"> <!-- itemId record yg hendak di edit -->
                <form>
                <div class="form-group">
                        <label for="lblCategory">Category</label>
                        <select class="form-control" id="DrdCategoryEdit" name="DrdCategoryEdit" onfocusout="cekFormCreateNewCategory('category')">
                        </select>
                        <div class="alert alert-error" id="categoryEditIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblItemName">Type Name</label>
                        <input type="text" class="form-control" id="txtTypeEdit" placeholder="Item Name" onfocusout="cekFormCreateNewCategory('itemname')">
                        <div class="alert alert-error" id="nameEditIsAlreadyTaken">
                            <!-- <span>Looks like the username you entered already taken!</span> -->
                        </div>
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
                <button type="button" class="btn btn-primary" id="updateType" onclick="updateType()">Save changes</button>
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
                <h4 class="modal-title" id="myModalLabel">Create Type</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>">
                <form>
                    <div class="form-group">
                        <label for="lblCategory">Category</label>
                        <select class="form-control" id="DrdCategory" name="DrdCategory" onfocusout="cekFormCreateNewType('category')">
                        </select>
                       <div class="alert alert-error" id="categoryIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblTypeName">Type Name</label>
                        <input type="text" class="form-control" id="txtTypeName" placeholder="Type Name" onfocusout="cekFormCreateNewType('typename')">
                        <div class="alert alert-error" id="nameIsAlreadyTaken">
                            <!-- <span>Looks like the username you entered already taken!</span> -->
                        </div>
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
                <button type="button" class="btn btn-primary" id="createNewType" onclick="createNewType()">Save changes</button>
            </div>
        </div>
    </div>
</div>