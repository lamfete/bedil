<!DOCTYPE html>
<html>
<head>

<title>Administration</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>

    <!-- Custom styles for this template -->
    <link href="assets/style/theme.css" rel="stylesheet">
</head>
<body>

<?php
    if($userlevel->user_level_id == 1) {
?>
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
                <a class="navbar-brand" href="#">Bedil</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo "/login/home"; ?>">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="#">Brand</a></li>
                    <li><a href="#">Category</a></li>
                    <li><a href="#">Type</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Item</a></li>
                    <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo "/user"; ?>">User</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="<?php echo "/login/logout"; ?>">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
            </div>
        </nav>
        <br /></br /><br /></br />
        <div class="container theme-showcase" role="main">
<?php
    } elseif($userlevel->user_level_id == 2) {
?>
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
                <a class="navbar-brand" href="#">Bedil</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo "/login/home"; ?>">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="#">Brand</a></li>
                    <li><a href="#">Category</a></li>
                    <li><a href="#">Type</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Item</a></li>
                    <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="<?php echo "/login/logout"; ?>">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
            </div>
        </nav>
        <br /><br /><br /></br />
        <div class="container theme-showcase" role="main">
<?php
    }
?>