<?php
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
$Functions = new Functions;

if(isset($_GET['AddFaculty'])){
	$ID = $Functions->IDGenerator('users','UserID');
	$UName = $_POST['Name'];
	$Node = $_POST['Node'];
	$PWord = sha1($_POST['Password']);
	$Count = $Functions->UserCheck($UName,$PWord);
	if($Count == 0){
		if($Query = mysql_query("INSERT INTO users(UserID,UserName,UserPassword,UserNode) VALUES('$ID','$UName','$PWord','$Node')") or die(mysql_error())){
			$Query = mysql_query("INSERT INTO faculty(ProfessorName) VALUES('$UName')");
		}
	}

}

if(isset($_GET['FacultyList'])){
	$Query = mysql_query("SELECT * FROM users WHERE UserNode = 'FACULTY'");
	echo '<table border="0" width="100%" align="center">';
	for($x=1;$Row = mysql_fetch_assoc($Query);$x++){
		echo '<tr><td>'.($x).'.&nbsp;'.$Row['UserName'].'</td></tr>';
	}
	echo '</table>';
}

if(isset($_GET['Update'])){
	$NewPassword = sha1($_POST['Password']);
	$Node = $_POST['Node'];
	$Data = $Functions->SelectOne("users","UserNode","$Node");
	$Query = mysql_query("UPDATE users SET UserPassword = '$NewPassword', UserNode = '$Node' WHERE UserID = '$Data[0]'");
}

if(isset($_GET['PasswordCheck'])){
	$Password = sha1($_POST['Password']);
	$Node = $_POST['Node'];
	if($Query = mysql_query("SELECT * FROM users WHERE UserNode = '$Node' AND UserPassword = '$Password'")){
		echo mysql_num_rows($Query);
	}
}

?>