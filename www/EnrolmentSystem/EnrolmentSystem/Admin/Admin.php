<?php
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
include("../PhpFiles2/Functions.php"); 
$Functions2 = new DatabaseClasses;
$Functions = new FunctionsExt;

if(isset($_GET['AddFaculty'])){
	$ID = $Functions->IDGenerator('users','UserID');
	$Node = $_POST['Node'];
	$PWord = sha1($_POST['Password']);
    $Query = $Functions2->PDO_SQL("SELECT * FROM users WHERE UserName = '{$_POST['Name']}'");
    count($Query);
	if(count($Query) == 0){
		if($Query = mysql_query("INSERT INTO users(UserID,UserName,UserPassword,UserNode) VALUES('$ID','{$_POST['Name']}','$PWord','$Node')") or die(mysql_error())){
			$Query = mysql_query("INSERT INTO faculty(ProfessorName) VALUES('{$_POST['Name']}')");
		}
		else
			echo "<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> Unable to create faculty's Account Error No. 7834</span></span>";
	}
	else
		echo "<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> Unable to create faculty's Account. Faculty was already in the database. Error No. 0126</span></span>";
}

if(isset($_GET['FacultyList'])){
	$Query = mysql_query("SELECT * FROM users WHERE UserNode = 'FACULTY' ORDER BY UserName");
	echo '<table class="table table-striped table-bordered">';
	for($x=1;$Row = mysql_fetch_assoc($Query);$x++){
		echo "<tr><td>{$x}. {$Row['UserName']}<a class='btn btn-success btn-sm pull-right' href='#UKey#{$Row['UserID']}'>Update password</a></td></tr>";
	}
	echo '</table>';
}

if(isset($_GET['FeeList'])){
    $Query = $Functions2->PDO_SQL("SELECT * FROM fee WHERE FeeName!='Units(Masteral)' && FeeName!='Units(Doctoral)'");
    $Query2 = $Functions2->PDO_SQL("SELECT * FROM fee WHERE FeeName='Units(Masteral)'");
    $Query3 = $Functions2->PDO_SQL("SELECT * FROM fee WHERE FeeName='Units(Doctoral)'");
    echo "
	    <table class='table table-striped'>
    		<tr>
    			<th>Fee</th>
    			<th>Regular</th>
    			<th>Int'l</th>
    			<th></th>
    		</tr>
    		<tr>
    			<td>Unit (Masteral)</td>
    			<td>{$Query2[0][2]}</td>
    			<td>{$Query2[0][3]}</td>
    			<td>
                    <a href='#UFee#{$Query2[0][1]}#{$Query2[0][2]}#{$Query2[0][3]}' class='btn btn-danger btn-xs pull-right'>Update</a>
                </td>
    		</tr>
    		<tr>
    			<td>Unit (Doctoral)</td>
    			<td>{$Query3[0][2]}</td>
    			<td>{$Query3[0][3]}</td>
    			<td>
                    <a href='#UFee#{$Query3[0][1]}#{$Query3[0][2]}#{$Query3[0][3]}' class='btn btn-danger btn-xs pull-right'>Update</a>
                </td>
    		</tr>
    ";
    foreach ($Query as $a => $b) {
        /*
        $Options = "
            <div class='pull-right'>
                <div class='btn-group'>
                    <button type='button' class='btn btn-danger btn-xs dropdown-toggle' data-toggle='dropdown'>
                        Options
                        <span class='caret'></span>
                    </button>
                    <ul class='dropdown-menu pull-right' role='menu'>
                        <li><a href='#UFee#{$b[1]}#{$b[2]}#{$b[3]}'>Update</a></li>
                        <li><a href='#DFee#{$b[1]}'>Delete</a></li>
                    </ul>
                </div>
            </div>
        ";
        */

        $Options = "<a  href='#UFee#{$b[1]}#{$b[2]}#{$b[3]}' class='btn btn-danger btn-xs pull-right'>Update</a>";
                    
    	echo "
    		<tr>
    			<td>{$b[1]}</td>
    			<td>{$b[2]}</td>
    			<td>{$b[3]}</td>
    			<td>{$Options}</td>
    		</tr>
    	";
    }
    echo "</table>";
}

if(isset($_GET['Update'])){
	$Data = $_POST['Data'];
	$NewPassword = sha1($Data[1]);
    $Query = $Functions2->PDO_Query2("UPDATE users SET UserPassword = '$NewPassword' WHERE UserID = '$Data[0]'");
	if($Query == 1)
		echo 1;
	else
		echo 0;
}

if(isset($_GET['UpdateFee'])){
	$Data = $_POST['Data'];
    $Query = $Functions2->PDO_Query2("UPDATE fee SET FeePrice = '{$Data[1]}',FeePrice2 = '{$Data[2]}' WHERE FeeName = '{$Data[0]}'");
	if($Query == 1)
		echo 1;
	else
		echo 0;
}

if(isset($_GET['PasswordCheck'])){
	$Password = sha1($_POST['Password']);
	$Node = $_POST['Node'];
	if($Query = mysql_query("SELECT * FROM users WHERE UserNode = '$Node' AND UserPassword = '$Password'")){
		echo mysql_num_rows($Query);
	}
}

if(isset($_GET['FeeForm'])){
    echo "
        <div id='FeeManagementForm'>
            <div id='FeeFormField' class='col-md-6 hidden'>
                Fee: <span id='ErrorFee'></span>
                <input type='text' class='form-control' id='FeeField'/>
            </div>
            <div class='col-md-12'></div>
            <div class='col-md-6'>
                Regular: <span id='ErrorRegular'></span>
                <input type='text' class='form-control' id='RegularField'/>
            </div>
            <div class='col-md-6'>
                International: <span id='ErrorInternational'></span>
                <input type='text' class='form-control' id='InternationalField'/>
            </div>
            <div class='col-md-12'>
                <br/>
                <input type='button' class='btn btn-sm btn-info disabled' value='Update' id='FeeUpdateButton'/>
                <input type='button' class='btn btn-sm btn-danger' value='Cancel' data-dismiss='modal'/>
            </div>
        </div>
        <div id='FeeNotification' class='hidden'></div>
    ";
}

if(isset($_GET['AddFee'])){
    $Data = $_POST['Data'];
    $Query = $Functions2->PDO_Query2("INSERT INTO fee(FeeName,FeePrice,FeePrice2,Required) VALUES('{$Data[0]}','{$Data[1]}','{$Data[2]}','2')");
    if($Query == 1)
        echo 1;
    else
        echo 0;
}

if(isset($_GET['CheckFee'])){
    $Query = $Functions2->PDO_SQL("SELECT * FROM fee WHERE FeeName='{$_POST['Data']}'");
    if((count($Query) == 0) && ($Functions->ValidationCourseTitle($_POST['Data']) !== 1))
        echo 0;
    else
        echo 1;
}

if(isset($_GET['DeleteFee'])){
    $Query = $Functions2->PDO_Query2("DELETE FROM fee WHERE FeeName = '{$_POST['Data']}'");
    if($Query == 1)
        echo 1;
    else
        echo 0;
}

if(isset($_GET['SetCutOff'])){
    $Data = "{$_POST['Data']} 00:00:00";
    $Query = $Functions2->PDO_Query2("UPDATE settings SET SettingsStatus = '{$Data}' WHERE SettingsLabel = 'CutOffDate'");
    if($Query == 1)
        echo 1;
    else
        echo 0;
}

if(isset($_GET['SetEnrolmentCutOff'])){
    $Data = "{$_POST['Data']} 00:00:00";
    $Query = $Functions2->PDO_Query2("UPDATE settings SET SettingsStatus = '{$Data}' WHERE SettingsLabel = 'EnrolmentCutOffDate'");
    if($Query == 1)
        echo 1;
    else
        echo 0;
}

if(isset($_GET['CutOffForm'])){
    $Sem = $Functions2->YearSemNow();
    $Query = $Functions2->PDO_SQL("SELECT * FROM settings WHERE SettingsLabel = 'CutOffDate'");
    if($Query[0][2] == ""){
        echo "
            <div class='col-md-12 alert alert-info'>
                Cut off date is not set. 
            </div>
        ";
    }
    else{
        $Date = date("F j, Y",strtotime($Query[0][2]));
        echo "
            <div class='col-md-12 alert alert-danger'>
                Cut off date for {$Sem[1]} {$Sem[0]} is set on: <strong>{$Date}</strong> 
            </div>
        ";
    }
    echo "<input type='button' id='LockDate' class='btn btn-sm btn-danger btn-block' value='Set cut off date for {$Sem[1]} {$Sem[0]}'>";
}

if(isset($_GET['EnrolmentCutOffForm'])){
    $Sem = $Functions2->YearSemNow();
    $Query = $Functions2->PDO_SQL("SELECT * FROM settings WHERE SettingsLabel = 'EnrolmentCutOffDate'");
    if($Query[0][2] == ""){
        echo "
            <div class='col-md-12 alert alert-danger'>
                Enrolment cut off date is not set. 
            </div>
        ";
    }
    else{
        $Date = date("F j, Y",strtotime($Query[0][2]));
        echo "
            <div class='col-md-12 alert alert-info'>
                Enrolment cut off date for {$Sem[1]} {$Sem[0]} is set on: <br/><strong>{$Date}</strong> 
            </div>
        ";
    }
    echo "<input type='button' id='EnrolmentLockDate' class='btn btn-sm btn-info btn-block' value='Set enrolment cut off date for {$Sem[1]} {$Sem[0]}'>";
}

?>