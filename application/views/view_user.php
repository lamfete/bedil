<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backoffice/master_user.js"></script>

<div class="row">
    <div class="col-md-12">
        <?php
            echo "Hello, user " . $name->name . ".<br />";
        ?>
        <!-- Button trigger modal -->
        <?php
            if($userlevel->user_level_id == 1) {
        ?>
        <button type="button" class="btn btn-lg" data-toggle="modal" data-target="#createModal">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Add new user
        </button>
        <?php
            }
        ?>
    </div>
</div>

<div class="row" style="margin-bottom:10px;">
    <div class="col-md-12">
        
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table id="table_user" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
            <thead>
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
                <p id='tes'></p>
                <!-- <input type="text" id="username" class="form-control"> -->
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" id="user_login" placeholder="Username" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Name">
                    </div>
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" id="status"> Aktif
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
                <p id='tes'></p>
                <!-- <input type="text" id="username" class="form-control"> -->
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" id="user_login" placeholder="Username" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Name">
                    </div>
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" id="status"> Aktif
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>