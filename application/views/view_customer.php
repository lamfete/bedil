<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backoffice/master_customer.js"></script>

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
            Add new customer
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
            <table id="table_user" class="table table-striped table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID customer</th>
                        <!-- <th>user_level_id</th> -->
                        <th>User Login</th>
                        <th>Name</th>
                        <th>Email</th>
                        <!-- <th>Password</th> -->
                        <th>Status</th>
                        <!-- <th>Created At</th> -->
                        <!-- <th>Updated At</th> -->
                        <th>Level user</th>
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
                <h4 class="modal-title" id="myModalLabel">Edit User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>"> <!-- userId yang login -->
                <input type="hidden" id="idUser"> <!-- userId record yg hendak di edit -->
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" id="txtUserloginEdit" placeholder="Username" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nameEdit">Name</label>
                        <input type="text" class="form-control" id="txtNameEdit" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="emailEdit">Email</label>
                        <input type="text" class="form-control" id="txtEmailEdit" placeholder="Email" onfocusout="cekFormEdiUser('email')">
                    </div>
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" id="statusEdit"> Aktif
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateUser" onclick="updateUser()">Save changes</button>
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
                <h4 class="modal-title" id="myModalLabel">Create User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdLogin" value="<?php echo $name->user_id; ?>">
                <form>
                    <div class="form-group">
                        <label for="lblUsername">Username</label>
                        <input type="text" class="form-control" id="txtUsername" placeholder="Username" onfocusout="cekFormCreateNewUser('username')">
                        <div class="alert alert-error" id="UsernameIsAlreadyTaken">
                            <!-- <span>Looks like the username you entered already taken!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblName">Name</label>
                        <input type="text" class="form-control" id="txtName" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="lblEmail">Email</label>
                        <input type="text" class="form-control" id="txtEmail" placeholder="Email" onfocusout="cekFormCreateNewUser('email')">
                        <div class="alert alert-error" id="EmailIsAlreadyExist">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lblPassword">Password</label>
                        <input type="password" class="form-control" id="txtPassword" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="lblUserLevel">User Level</label>
                        <select class="form-control" id="DrdUserLevel" name="DrdUserLevel" onfocusout="cekFormCreateNewUser('userLevel')">
                        </select>
                        <div class="alert alert-error" id="userLevelIsNull">
                            <!-- <span>Looks like the email you entered already exist!</span> -->
                        </div>
                    </div>
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" id="isAktif"> Aktif
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createNewUser" onclick="createNewUser()">Save changes</button>
            </div>
        </div>
    </div>
</div>