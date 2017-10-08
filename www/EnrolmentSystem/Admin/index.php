<?php
session_start();
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
include("../PhpFiles2/Functions.php"); 
$Functions2 = new DatabaseClasses;
$Functions = new Functions;
if(!isset($_SESSION['Username']) && !isset($_SESSION['Password'])){ header("Location:../"); }
if(isset($_GET['LogOut'])){
	session_destroy();
	header("Location:../");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" href="../CSS/General.css" type="text/css">
    <link rel="stylesheet" href="../CSS/Admin.css" type="text/css">
    <link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap.css" type="text/css"/>
    <link rel="icon" href="../Images/GSLOGO.png">

    <link rel="stylesheet" href="../date/lib/themes/default.css" id="theme_base">
    <link rel="stylesheet" href="../date/lib/themes/default.date.css" id="theme_date">
    <link rel="stylesheet" href="../date/lib/themes/default.time.css" id="theme_time">

    <script type="text/javascript" src="../JQuery/JQuery.js"></script>
    <script type="text/javascript" src="../JQuery/JS.js"></script></head>
    <script type="text/javascript" src="../JQuery/Admin.js"></script></head>
    <script type="text/javascript" src="../JQuery/Validation.js"></script>
    <script type="text/javascript" src="../BOOTSTRAP/js/bootstrap.min.js"></script>
    <script src="../date/lib/picker.js"></script>
    <script src="../date/lib/picker.date.js"></script>
    <script src="../date/lib/picker.time.js"></script>
    <script src="../date/lib/legacy.js"></script>
    <style>
        .col-md-4 {
        width: 33.33333333% !important;
        }    
    </style>
</head>

<body>
    <nav class="navbar label-primary WhiteText" role="navigation" style='height:120px; background:#060E62;'>
        <div class="container-fluid">
            <div class="navbar-header col-md-12">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand col-md-12">
                    <div class="col-md-5">
                        <img src='../Images/GSLOGO.png' class='col-md-3'>
                        <h1 style='color:#fff; font-family:monotype corsiva;'>PSU-OUS-EES</h1>
                    </div>
                    <div class="col-md-5"><h1 style='color:#fff; font-family:monotype corsiva;'><p>Welcome</p></h1></div>
                    <div class="col-md-2"><h1 style='color:#fff; font-family:monotype corsiva;'><p class='text-right' id="Timely">Loading time</p></h1></div>
                    
                </span>
            </div>
            <div class="collapse navbar-collapse">
            </div>
        </div>
    </nav>
    <nav class="navbar label-primary WhiteText" role="navigation" style='xborder-top:1px solid #000; background:#060E62;'>
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">Administrator</span>
            </div>
            <div class="collapse navbar-collapse">
                <h4 class="pull-right"><a href="?LogOut"><button class="btn btn-default btn-danger">Log Out</button></a></h4>
            </div>
        </div>
    </nav>
    <div class='jumobtron'>
        <div class="container">
            <br/>
            <div class='col-md-12'>
                <div class='col-md-7'>
                    <div class='panel panel-default'>
                        <div class="panel-heading"><h4>Account Settings</h4></div>
                        <table class="table table-striped box-shadow">
                            <tr>
                                <td>
                                    Administrator
                                    <?php
                                        $Query = $Functions2->PDO_SQL("SELECT * FROM users WHERE UserNode = 'ADMIN'");
                                        echo "<a class='btn btn-success btn-sm pull-right' href='#UKey#{$Query[0][0]}#1'>Update password</a>";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Registrar
                                    <?php
                                        $Query = $Functions2->PDO_SQL("SELECT * FROM users WHERE UserNode = 'REGISTRAR'");
                                        echo "<a class='btn btn-success btn-sm pull-right' href='#UKey#{$Query[0][0]}#2'>Update password</a>";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Assessment
                                    <?php
                                        $Query = $Functions2->PDO_SQL("SELECT * FROM users WHERE UserNode = 'ASSESSMENT'");
                                        echo "<a class='btn btn-success btn-sm pull-right' href='#UKey#{$Query[0][0]}#3'>Update password</a>";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Cashier
                                    <?php
                                        $Query = $Functions2->PDO_SQL("SELECT * FROM users WHERE UserNode = 'CASHIER'");
                                        echo "<a class='btn btn-success btn-sm pull-right' href='#UKey#{$Query[0][0]}#4'>Update password</a>";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="col-md-12">Faculty <span id="ErrorFaculty"></span><input type='button' class='btn btn-xs btn-danger' value='Add Faculty' id='ButtonFacultyAdd'><br/></div>
                                    <div class="col-md-4 alert alert-warning hidden" id='FacultyForm'>
                                        <div class='col-md-12'>
                                            Name:<span id="ErrorFacultyName"></span>
                                            <input type="text" class="form-control" placeholder="Name of Faculty" id="FacultyName">
                                            <input type="hidden" value="FACULTY" id="FacultyNode">
                                        </div>
                                        <div class='col-md-12'>
                                            Password:<span id="ErrorFacultyPassword"></span>
                                            <input type="password" class="form-control" placeholder="Password" id="FacultyPassword">
                                        </div>
                                        <div class='col-md-12'><br/>
                                            <input type="submit" class="btn btn-success btn-sm disabled" value="Add" id="SubmitFaculty">
                                            <input type="submit" class="btn btn-warning btn-sm" value="cancel" id="CancelAddFaculty">
                                        </div>
                                    </div>
                                    <div id="FacultyList"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='col-md-5'>
                    <div class='panel panel-info'>
                        <div class='panel-heading'><h4>Enrolment cut off</h4></div>
                        <div class='panel-body' id='EnrolmentCutoffForm'></div>
                    </div>
                </div>	
                <div class='col-md-5'>
                    <div class='panel panel-danger'>
                        <div class='panel-heading'><h4>Grade Lock<small> Professor's rating submission cut off</small></h4></div>
                        <div class='panel-body' id='CutoffForm'></div>
                    </div>
                </div>  
                <div class='col-md-5'>
                    <div class="panel panel-primary">
                        <div class="panel-heading"><h4>Fee Management <a href='#AddFee' class='btn btn-sm btn-warning pull-right hidden'>Add Fee</a></h4></div>
                        <div id="FeeList"></div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <div class="modal fade" id="Modal_PasswordManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">System: Password Manager<div class='small' id="UserIdentity"></div></h4>
                </div>
                <div class='panel-body'>
                    <div id='PasswordManagementForm'>
                        <div class='col-md-6'>
                            New password: <span id="ErrorPassword"></span>
                            <input type='password' class='form-control' id='PasswordField'/>
                            <label>
                                <input type='checkbox' id="ShowAsText"><small><i>Show as text</i></small>
                            </label>
                        </div>
                        <div class='col-md-6'>
                            <br/>
                            <input type='button' class='btn btn-sm btn-info disabled' value='Update' id='UpdatePassword'/>
                            <input type='button' class='btn btn-sm btn-danger' value='Cancel' data-dismiss="modal"/>
                        </div>
                    </div>
                    <div id="PasswordNotification" class='hidden'></div>
                </div>
            </div>
        </div>
    </div>            

    <div class="modal fade" id="Modal_FeeManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">System: Fee Manager<div class='small' id="FeeIdentity"></div></h4>
                </div>
                <div class='panel-body' id="FeeForm">
                </div>
            </div>
        </div>
    </div>  

    <div class="modal fade" id="ModalConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="Text_ModalConfirmation"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning btn-sm" id="Button_Execute">Ok</button>
                </div>
            </div>
        </div>
    </div>  

    <div class="modal fade" id="ModalAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="Text_ModalAlert"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>    
              
</body>
</html>
