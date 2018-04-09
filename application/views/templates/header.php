<!DOCTYPE html>
<html>
<head>

<title>Administration</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="assets/DataTables/DataTables-1.10.16/css/jquery.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="assets/DataTables/Responsive-2.2.1/css/responsive.bootstrap.min.css"/>

    <!-- Custom styles for this template -->
    <link href="assets/style/theme.css" rel="stylesheet">

    <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/DataTables/Responsive-2.2.1/css/responsive.bootstrap.min.css">-->

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/js/jquery/jquery-3.3.1.js"></script>

    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>-->
    <!--<link rel="stylesheet" href="http://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css"/> -->
    <!--<link rel="stylesheet" href="http://cdn.datatables.net/responsive/1.0.2/css/dataTables.responsive.css"/>-->
    <style>
        /*body {
            font-size: 140%;
        }*/

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }
    </style>

</head>
<body>


        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">RONDA</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo "/home"; ?>">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li><a href="/category">Category</a></li>
                        <li><a href="/type">Type</a></li>
                        <li><a href="/brand">Brand</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="/item">Item</a></li>
                        <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                    <?php
                        // if($userlevel->user_level_id == 1) {
                    ?>
                    <li><a href="<?php echo "/user"; ?>">User</a></li>
                    <?php
                        // }
                    ?>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="<?php echo "/login/logout"; ?>">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <br /></br /><br /></br />
        <div class="container theme-showcase" role="main">
