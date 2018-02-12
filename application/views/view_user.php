<script type="text/javascript" src="{{ asset('/js/backoffice/master_user.js') }}"></script>

<?php
    echo "Hello, user " . $name->name . ".<br />";
?>

<table id="table_user" class="display" cellspacing="0" width="100%">
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
    <tfoot>
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
    </tfoot>
</table>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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