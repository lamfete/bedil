<html>
    <head>
    <title>
    </title>
    </head>
<body>
    <form action="<?php echo base_url();?>index.php/login/form" method="post" name="login">
    <div id="form-login">
        Administrator Page - Plase Login First
        <br><br>
        <table border="0" cellpadding="4">
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" size="40" name="username" value="<?php echo set_value('username');?>"> <?php echo form_error('username');?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="password" size="40" name="password" value="<?php echo set_value('password');?>"> <?php echo form_error('password');?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="login" value="Login"> </td>
            </tr>
        </table>
    </div>
    </form>

</body>
</html>