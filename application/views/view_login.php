<html>
    <head>
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url('bootstrap/css/bootstrap.min.css');?>">
    </head>
<body>
    <div class="container">
        <div class="row">
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">
        <form action="<?php echo base_url();?>index.php/login/form" method="post" name="login" class="form-group">
            <div id="form-login">
                <br /><br />
                <table border="0" cellpadding="4">
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td><input type="text" size="40" name="username" value="<?php echo set_value('username');?>" class="form-control"> <?php echo form_error('username');?></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><input type="password" size="40" name="password" value="<?php echo set_value('password');?>" class="form-control"> <?php echo form_error('password');?></td>
                    </tr>
                    <tr>
                        <td colspan=3>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="center"><input type="submit" name="login" value="Login" class="btn btn-default"></td>
                    </tr>
                </table>
            </div>
            </form>
        </div>
        <div class="col-md-4">&nbsp;</div>
        </div>
    </div>
</body>
</html>