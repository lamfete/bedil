<html>
    <head>
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <style>
        .toshow {
            display:none;
            color: red;
            text-align: right;
            font-size: 70%;
        }
    </style>
    </head>
<body>
    
    <?php 
        if($wrong_username_pass == 1) {
            
    ?>
            <script>
                $(function(){
                    $('#username').val("");
                    $('#password').val("");
                    $(".toshow").fadeIn(500);
                });
            </script>
    <?php
        }
    ?>

    <div class="container">
        <div class="row">
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">
        <form action="<?php echo base_url();?>login/form" method="post" id="form_login" name="login" class="form-group">
            <div id="form-login">
                <br /><br />
                <table border="0" cellpadding="4">
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td><input type="text" size="40" id="username" name="username" placeholder="username" value="<?php echo set_value('username');?>" class="form-control"> <?php echo form_error('username');?></td>
                    </tr>
                    
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><input type="password" size="40" id="password" name="password" placeholder="password" value="<?php echo set_value('password');?>" class="form-control"> <?php echo form_error('password');?></td>
                    </tr>
                    <tr>
                        <td colspan=3>
                            <div id="toshow" class="toshow">
                                Wrong username or password.
                            </div>&nbsp;
                        </td>
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