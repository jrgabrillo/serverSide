<?php
session_start();
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
if(!isset($_SESSION['Username']) && !isset($_SESSION['Password'])){ header("Location:../"); }
$Functions = new Functions;
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
<link rel="icon" href="../Images/GSLOGO.png">
<script type="text/javascript" src="../JQuery/JQuery.js"></script>
<script type="text/javascript" src="../JQuery/JS.js"></script></head>
<script type="text/javascript" src="../JQuery/Admin.js"></script></head>
</head>

<body>
    <div id="Container">
        <div id="Header">
            <div id="Registrar">
                <ul>
                    <li class="Title">ADMINISTRATOR</li>
                    <?php
                    echo '<a href="?LogOut"><li>Log Out</li></a>';
					echo '<li id="AdminAdd">Add</li>';
					echo '<li id="ChangeSettings">Password Settings</li>';
                    ?>
                </ul>
            </div>
            <div id="StudentInfoDropDown">
            	<div class="Triangle"></div>
                <li class="Box-shadow" id="PassAdministrator">Administrator</li>
                <li class="Box-shadow" id="PassRegistrar">Registrar</li>
                <li class="Box-shadow" id="PassAssessment">Assessment</li>
                <li class="Box-shadow" id="PassCashier">Cashier</li>
                <li class="Box-shadow" id="PassFaculty">Faculty</li>
            </div>
            <div id="AdminAddDropDown">
            	<div class="Triangle"></div>
                <li class="Box-shadow" id="AddFaculty">Faculty</li>
            </div>
        </div><br/><br/>
        <div id="Content">
            <div id="RegistrarContent">
            	<div id="StudentsProgram"></div>
                <div id="DataContainer">
                	<span id="StudentsList"></span>
                    <div id="StudentInformation">
                        <div id="ListFaculty">
                            <table border="0" width="90%" align="center" class="Box-shadow" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td>
                                    	Faculty Add: &emsp; <span class="ErrorMessage"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" placeholder="Name of Faculty" id="FacultyName">&nbsp;
                                    <input type="hidden" value="FACULTY" id="FacultyNode"><input type="password" placeholder="Password" id="FacultyPassword">&nbsp;<input type="submit" value="Add" id="AddFaculty"></td>
                                </tr>
                                <tr>
                                	<td >
                                        <div id="FacultyList">
                                        </div>
                                    </td>
                                </tr>
                            </table><br/>
                        </div>
                        
                        <div id="UserSettings">
                            <table border="0" id="AdminPass" width="90%" align="center" class="Box-shadow" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td>Administrator Password &emsp; <span class="ErrorMessage"></span>
                                    </td>
                                </tr>
                            	<tr>
                                    <td>
                                        <input type="password" placeholder="Old Password" id="OldPassword1">&nbsp;
                                   		<input type="password" placeholder="New Password" id="NewPassword1">&nbsp;
                                        <input type="submit" value="Update" id="Password1">
                                    </td>
                                </tr>
                                
                            </table>
                            
                            <table border="0" id="RegPass" width="90%" align="center" class="Box-shadow" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td>Registrar Password &emsp; <span class="ErrorMessage"></span>
                                    </td>
                                </tr>
                            	<tr>
                                    <td>
                                        <input type="password" placeholder="Old Password" id="OldPassword2">&nbsp;
                                   		<input type="password" placeholder="New Password" id="NewPassword2">&nbsp;
                                        <input type="submit" value="Update" id="Password2">
                                    </td>
                                </tr>
                            </table>

                            <table border="0" id="AssessPass" width="90%" align="center" class="Box-shadow" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td>Assessment Password &emsp; <span class="ErrorMessage"></span>
                                    </td>
                                </tr>
                            	<tr>
                                    <td>
                                        <input type="password" placeholder="Old Password" id="OldPassword3">&nbsp;
                                   		<input type="password" placeholder="New Password" id="NewPassword3">&nbsp;
                                        <input type="submit" value="Update" id="Password3">
                                    </td>
                                </tr>
                            </table>

                            <table border="0" id="CashierPass" width="90%" align="center" class="Box-shadow" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td>Cashier Password &emsp; <span class="ErrorMessage">x</span>
                                    </td>
                                </tr>
                            	<tr>
                                    <td>
                                        <input type="password" placeholder="Old Password" id="OldPassword4">&nbsp;
                                   		<input type="password" placeholder="New Password" id="NewPassword4">&nbsp;
                                        <input type="submit" value="Update" id="Password4">
                                    </td>
                                </tr>
                            </table>

                        	
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</body>
</html>
