<?php
include("gabruX/Functions.php");
$Function = new Functions;
$Function->DBConnection('localhost','root','','enrolmentsystem');
class FunctionsExt extends Functions{
	private $Query;
	private $Row;
	private $Array;
	private $Table;
	private $Number;
	public $Error;
	public $Status;

	function StudentsEnrolledNow(){
		$FirstSem = array('6','7','8','9','10');
		$SecondSem = array('11','12','1','2','3');
		$Summer = array('4','5'); $Sem = "";

		$Query = mysql_query("SELECT * FROM studentscourse");
		while($Row = mysql_fetch_assoc($Query)){
			$MonthEnrolled = explode('-',$Row['DateEnrolled']);
			for($x = 0;$x < count($FirstSem); $x++){
				if($MonthEnrolled[1] == $FirstSem[$x]){ $Sem = '1st Sem'; break; }
				else if($MonthEnrolled[1] == @$SecondSem[$x]){ $Sem = '2nd Sem'; break; }
				else if($MonthEnrolled[1] == @$Summer[$x]){ $Sem = 'Summer'; break; }
			}

			echo $Row['DateEnrolled'].' = '.$Sem.'<br/>';
		}


		$MonthQuery = mysql_query("SELECT DATE_FORMAT(NOW(),'%M') as Month"); $MonthRow = mysql_fetch_assoc($MonthQuery);
		$MonthNow = $MonthRow['Month'];
		for($x = 0;$x < count($FirstSem); $x++){
			if($MonthNow == $FirstSem[$x]){ $Sem = '1st Sem'; break; }
			else if($MonthNow == @$SecondSem[$x]){ $Sem = '2nd Sem'; break; }
			else if($MonthNow == @$Summer[$x]){ $Sem = 'Summer'; break; }
		}
		$YearQuery = mysql_query("SELECT DATE_FORMAT(NOW(),'%Y') as Year") or die(mysql_error()); $YearRow = mysql_fetch_assoc($YearQuery);
		$YearNow = $YearRow['Year'];
	}

	function DateNow(){
		$Row = mysql_fetch_assoc(mysql_query("SELECT curdate() as Date"));
		return $Row['Date'];		
	}
	function CodeGenerator(){
		$Functions = new self;
		$Status = true;
		$Num = mysql_num_rows(mysql_query("SELECT * FROM enrolledsubject"));
		for($x=0;$Status == true;$x++){
			$Code = substr(sha1($Num+$x),0,6);
			$Data = $Functions->SelectOne("enrolledsubject","RegistrationCode","$Code");
			if(strlen($Data[6]) == 0)
				$Status = false;
		}
		return $Code;
	}
	function SelectOne($Table,$Column,$Compare){
		$Array = array(); $Array2 = array();
		$Query = mysql_query("SELECT * FROM $Table WHERE $Column = '$Compare'") or die(mysql_error());
		$Row = @mysql_fetch_assoc($Query);
		$Query2 = mysql_query("describe $Table");
		while($Row2 = @mysql_fetch_assoc($Query2)){
			$Array[] = $Row2['Field'];
		}
		for($x=0;$x<count($Array);$x++){
			$Array2[] = $Row[$Array[$x]];
		}
		return $Array2;
	}
	function TableID($Table){
		$Array = array();
		$Query = mysql_query("SELECT * FROM $Table");
		while($Row = mysql_fetch_assoc($Query)){
			$Array[] = $Row['UserID'];
		}
		return $Array;
	}

	function YearSemNow(){
		$FirstSem = array('June','July','August','September','October');
		$SecondSem = array('November','December','January','February','March');
		$Summer = array('April','May'); $Sem = "";
		$MonthQuery = mysql_query("SELECT DATE_FORMAT(NOW(),'%M') as Month"); $MonthRow = mysql_fetch_assoc($MonthQuery);
		$MonthNow = $MonthRow['Month'];
		for($x = 0;$x < count($FirstSem); $x++){
			if($MonthNow == $FirstSem[$x]){ $Sem = '1st Sem'; break; }
			else if($MonthNow == @$SecondSem[$x]){ $Sem = '2nd Sem'; break; }
			else if($MonthNow == @$Summer[$x]){ $Sem = 'Summer'; break; }
		}
		$YearQuery = mysql_query("SELECT DATE_FORMAT(NOW(),'%Y') as Year") or die(mysql_error()); $YearRow = mysql_fetch_assoc($YearQuery);
		$YearNow = $YearRow['Year'];
		// $StudentSem = $YearNow.'/'.$Sem;
		return array($YearNow,$Sem);
	}

	function YearSemGenerator(){
		$FirstSem = array('June','July','August','September','October');
		$SecondSem = array('November','December','January','February','March');
		$Summer = array('April','May'); $Sem = "";
		$MonthQuery = mysql_query("SELECT DATE_FORMAT(NOW(),'%M') as Month"); $MonthRow = mysql_fetch_assoc($MonthQuery);
		$MonthNow = $MonthRow['Month'];
		for($x = 0;$x < count($FirstSem); $x++){
			if($MonthNow == $FirstSem[$x]){ $Sem = '1st Sem'; break; }
			else if($MonthNow == @$SecondSem[$x]){ $Sem = '2nd Sem'; break; }
			else if($MonthNow == @$Summer[$x]){ $Sem = 'Summer'; break; }
		}
		$YearQuery = mysql_query("SELECT DATE_FORMAT(NOW(),'%Y') as Year") or die(mysql_error()); $YearRow = mysql_fetch_assoc($YearQuery);
		$YearNow = $YearRow['Year'];
		return $StudentSem = $YearNow.'/'.$Sem;
	}
	function IDGenerator($Table,$ID){
		$Functions = new self;
		$Status = true;
		for($x=0;$Status == true;$x++){
			$TempID = sha1($Functions->TableCounter($Table)+$x);
			$Query = mysql_query("SELECT * FROM $Table WHERE $ID = '$TempID'");
			if(mysql_num_rows($Query) == 0){
				$Status = false;
			}
		}
		return $TempID;
	}
	function TableCounter($Table){
		$Query = mysql_query("SELECT * FROM $Table");
		$Number = mysql_num_rows($Query);
		return $Number;
	}
	function TableCounter2($Table,$Compare,$Value){
		$Query = mysql_query("SELECT * FROM $Table WHERE $Compare = '$Value'");
		$Number = mysql_num_rows($Query);
		return $Number;
	}
	function ShowStudentsPerProgram($Program){
		$Array = array();
		$Query = mysql_query("SELECT * FROM studentscourse WHERE StudentCourse = '$Program'");
		while($Row = mysql_fetch_assoc($Query)){
			$Array[] = $Row['StudentIDNumber']; 
		}
		return $Array;

	}


	function ReportListSemester($Table,$Compare,$Value,$Looper){
		$Function = new self;
		$Query = mysql_query("SELECT * FROM $Table WHERE $Compare = '$Value'");
		echo '<table class="table table-striped panel panel-primary" border="0">';
		echo '<th width="50%">Name</th><th>Student ID Number</th><th></th>';
		for($x=0;$Row = mysql_fetch_assoc($Query);$x++){
			$Data = $Function->SelectOne('students','StudentIDNumber',$Row['StudentIDNumber']);
			$Function->StudentX($Row['StudentIDNumber'],$x,$x,$Looper);
		}
		echo '</table>';
		$Number = mysql_num_rows($Query);
		return $Number;
	}

	function Semestral(){
		$Function = new self;
		$StudentCount = 0;
		$Data = $Functions->ReportCourse("MASTERAL");
		for($x=0;$x<count($Data[0]);$x++){
			$StudentCount += $Data[1][$x];
			echo '<tr><td><h6><div class="DataMarker" id="DataMarker'.$x.'"></div></h6></td><td><h6>'.$Data[0][$x].'</h6></td><td align="center"><h6><span id="ChartMasteral'.$x.'" class="badge">'.$Data[1][$x].'</span></h6></td></tr>';
		}
		echo '<input type="hidden" value="'.$x.'" id="Chart2Data1"/>';
	}
	
	
	function ReportSem(){
		$Function = new self;
		$Array = array(); $ArrayDoctoral = array(); $ArrayMasteral = array(); $Array1Sem = array(); $Array2Sem = array();
		$Query = mysql_query("SELECT DISTINCT YearSem FROM enrolledsubject ORDER BY YearSem");
		for($x=0;$Row = mysql_fetch_assoc($Query);$x++){
			$Data = explode('/',$Row['YearSem']);
			if(date('Y') == $Data[0]){
				if($x == 0){
					$YearSem = $Row['YearSem'];
					$Query2 = mysql_query("SELECT DISTINCT enrolledsubject.StudentIDNumber FROM enrolledsubject WHERE YearSem = '$YearSem'");
					while($Row2 = mysql_fetch_assoc($Query2)){
						$StudentIDNumber = $Row2['StudentIDNumber'];
						$Row3 = mysql_fetch_assoc(mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$StudentIDNumber' AND StudentProgram = 'MASTERAL'"));
						if(!empty($Row3['StudentIDNumber'])){
							$ArrayMasteral[] = $Row3['StudentIDNumber'];
						}
						$Row4 = mysql_fetch_assoc(mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$StudentIDNumber' AND StudentProgram = 'DOCTORAL'"));
						if(!empty($Row4['StudentIDNumber'])){
							$ArrayDoctoral[] = $Row4['StudentIDNumber'];
						}
					}
					//$Array1Sem[] = count($ArrayMasteral); $Array1Sem[] = count($ArrayDoctoral);
					$Array1Sem = array($ArrayMasteral,$ArrayDoctoral);
				}
				else if($x == 1){
					$YearSem = $Row['YearSem']; $ArrayMasteral = NULL; $ArrayDoctoral = NULL;
					$Query2 = mysql_query("SELECT DISTINCT enrolledsubject.StudentIDNumber FROM enrolledsubject WHERE YearSem = '$YearSem'");
	
					while($Row2 = mysql_fetch_assoc($Query2)){
						$StudentIDNumber = $Row2['StudentIDNumber'];
						$Row3 = mysql_fetch_assoc(mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$StudentIDNumber' AND StudentProgram = 'MASTERAL'"));
						if(!empty($Row3['StudentIDNumber'])){
							$ArrayMasteral[] = $Row3['StudentIDNumber'];
						}
						$Row4 = mysql_fetch_assoc(mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$StudentIDNumber' AND StudentProgram = 'DOCTORAL'"));
						if(!empty($Row4['StudentIDNumber'])){
							$ArrayDoctoral[] = $Row4['StudentIDNumber'];
						}
					}
					//$Array2Sem[] = count($ArrayMasteral); $Array2Sem[] = count($ArrayDoctoral);
					//$Array2Sem[] = count($ArrayMasteral); $Array2Sem[] = count($ArrayMasteral);
					$Array2Sem = array($ArrayMasteral,$ArrayMasteral);
				}
			}
		}
		$Array[] = $Array1Sem; $Array[] = $Array2Sem;
		return $Array;
	}

	function StudentX($StudentIDNumber, $Loop, $InnerLoop,$LoopVariable){
		$x = $Loop;
		$Functions = new self;
        $StudentsData = $Functions->SelectOne("students","StudentIDNumber",$StudentIDNumber);
        echo '
            <tr>
                <td>'.$StudentIDNumber.'</td>
                <td>'.$StudentsData[4].', '.$StudentsData[2].' '.$StudentsData[3].'</td>
                <td>
                    <button data-toggle="modal" data-target="#Modal'.$LoopVariable.$x.$InnerLoop.'" class="btn btn-sm btn-danger SInfo">View details</button>
                    <div class="modal fade" id="Modal'.$LoopVariable.$x.$InnerLoop.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Student\'s Information</h4>
                                </div>
                                <table class="table table-striped">
                                    <tr><td rowspan="6" width="20%" align="center" class="BorderRight">
                                        <span class="thumbnail">
                                            <img src="../StudentsPicture/'.$StudentsData[13].'" draggable="false"/>
                                        </span>
                                    </td><td width="20%">Name: </td><td>'.$StudentsData[4].', '.$StudentsData[2].' '.$StudentsData[3].'</td></tr>
                                    <tr><td>Student Number:</td><td>'.$StudentsData[1].'</td></tr>
                                    <tr><td>Address:</td><td>'.$StudentsData[6].'</td></tr>
                                    <tr><td>Date of birth: </td><td>'.$StudentsData[9].'</td></tr>
                                    <tr><td>Mobile: </td><td>'.$StudentsData[7].'</td></tr>
                                    <tr><td colspan="2">Person notify to incase of emergency: '.$StudentsData[11].' at #'.$StudentsData[12].'</td></tr>
                                </table>';
                                
                                    $DataCourse = $Functions->SelectOne("studentscourse","StudentIDNumber",$StudentsData[1]);
                                    $Units = 0;
                                    $DataStudent = $Functions->ShowAllIDWith("courses","CourseTitle",$DataCourse[2],"CourseNumber");
                                    echo '<table class="table table-striped panel" border="1" width="100%">';
                                    echo '<tr><td>Under Grad. course:</td><td colspan="5">'.$DataCourse[7].'</td></tr>';
                                    echo '<tr><td>GS Course:</td><td colspan="5">'.$DataCourse[2].'</td></tr>';
                                    echo '</table>';
                                    echo '<table class="table table-striped panel" border="0" width="100%"><tr><td width="10%" align="center">Course Code</td><td align="center" width="50%">Descriptive Title</td><td width="5%" align="center">Units</td><td width="5%" align="center">Rating</td><td align="center" width="14%">Semester and Year</td><td align="center">Professor</td></tr>';
                                    for($b=0;$b<count($DataStudent);$b++){
                                        $DataCourseCode = $Functions->SelectOne("courses","CourseNumber",$DataStudent[$b]);
                                        $EnrolledQuery = mysql_query("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$StudentsData[1]' AND CourseCode = '$DataCourseCode[1]'");
                                        $EnrolledRow = mysql_fetch_assoc($EnrolledQuery);
                                        if($EnrolledRow['CourseCode'] == $DataCourseCode[1]){
                                            $Units = $Units + $DataCourseCode[3];
                                            echo '
                                                <tr>
                                                    <td align="center">'.$DataCourseCode[1].'</td>
                                                    <td>'.$DataCourseCode[2].'</td>
                                                    <td align="center">'.$DataCourseCode[3].'</td>
                                                    <td align="center">'.$EnrolledRow['Rating'].'   </td>
                                                    <td align="center">'.$EnrolledRow['YearSem'].'</td>
                                                    <td align="center">'.$EnrolledRow['Professor'].'</td>
                                                </tr>';
                                        }
                                    }
                                    echo '
                                        <tr>
                                            <td align="right" colspan="2">Total units earned:</td>
                                            <td align="center">'.$Units.'</td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Documents</h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <span id="ORMessage"></span>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Reciept Number</span>
                                                            <input type="text" id="RecieptNumber'.$x.'" class="Left" maxlength="6"/>
                                                        </div>
                                                        <input type="hidden" id="Hdn_units'.$x.'" value="'.$Units.'">
                                                        <input type="hidden" id="Hdn_SNO'.$x.'" value="'.$StudentsData[1].'">
                                                        <input type="button" id="PrintUnits'.$x.'" value="Print Earned Units" class="btn btn-sm btn-success disabled"/>
                                                        <input type="button" id="PrintGoodMoral'.$x.'" value="Print Good Moral" class="btn btn-sm btn-success disabled"/>
                                                        <input type="button" id="PrintGrades'.$x.'" value="Print Grades" class="btn btn-sm btn-success disabled"/>
                                                        <input type="button" id="PrintOTR'.$x.'" value="Print OTR" class="btn btn-sm btn-success disabled"/>
                                                    </div>
                                                </div>                                              
                                            </td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                    </div>                  
                </td>
            </tr>
        ';
	}
	
	function ReportCourse($Program){
		$StudentCount = 0;
		$Array = array(); $ArrayCourses = array(); $ArrayStudent = array();
		$Query = mysql_query("SELECT DISTINCT CourseTitle FROM courses WHERE Program = '$Program'");
		while($Row = mysql_fetch_assoc($Query)){
			$ArrayCourses[] = $CourseTitle = $Row['CourseTitle'];
			$Query2 = mysql_query("SELECT DISTINCT studentscourse.StudentIDNumber FROM studentscourse INNER JOIN enrolledsubject WHERE studentscourse.StudentCourse = '$CourseTitle' AND studentscourse.StudentIDNumber = enrolledsubject.StudentIDNumber");
			while($Row2 = mysql_fetch_assoc($Query2)){
				$StudentCount += 1;
			}
			$ArrayStudent[] = $StudentCount;
			$StudentCount = 0;
		}
		$Array[] = $ArrayCourses; $Array[] = $ArrayStudent;
		return $Array;
	}
	
	function LogIn($UName,$PWord){
		session_start();
		$Username = mysql_real_escape_string($UName);
		$Password = mysql_real_escape_string($PWord);
		$Query = mysql_query("SELECT * FROM users WHERE UserName = '$Username' and UserPassword = '$Password' ");
		if(mysql_num_rows($Query) == 1)
		{
			$_SESSION['Username'] = $Username;
			$_SESSION['Password'] = $Password;
			$Row = mysql_fetch_assoc($Query);
			$UserNode = $Row['UserNode'];
			if($UserNode == "ADMIN")
				header("Location:Admin/");
			else if($UserNode == "REGISTRAR")
				header("Location:Registrar/?Dashboard");
			else if($UserNode == "CASHIER")
				header("Location:Cashier/");
			else if($UserNode == "ASSESSMENT")
				header("Location:Assessment/");
			else if($UserNode == "FACULTY")
				header("Location:Faculty/");
			else{
			}
		}
		else{
			return $Error = "<b>LOG IN ERROR:</b> Username and password didn't match.";
		}
	}
	function UserCheck($Username,$Password){
		$Query = mysql_query("SELECT * FROM users WHERE UserName = '$Username' and UserPassword = '$Password' ");
		return mysql_num_rows($Query);
	}
	function Students($Program){
		$Array = array();
		$Query = mysql_query("SELECT * FROM students INNER JOIN studentscourse ON students.StudentIDNumber = studentscourse.StudentIDNumber WHERE StudentProgram = '$Program' ORDER BY StudentSurname") or die(mysql_error());
		while($Row = mysql_fetch_assoc($Query)){
			$Array[] = $Row['StudentID'];
		}
		return $Array;
	}
	function AllStudents(){
		$Array = array();
		$Query = mysql_query("SELECT * FROM students ORDER BY StudentSurname") or die(mysql_error());
		while($Row = mysql_fetch_assoc($Query)){
			$Array[] = $Row['StudentID'];
		}
		return $Array;
	}

	function StudentIDNumberGenerator($Program){
		$Function = new self;
		$Data = $Function->YearSemGenerator();
		$DataProgram = substr($Program,0,1);
		$Data = explode('/',$Data); $Data = substr($Data[1],0,1);
		$Query = mysql_query("SELECT curdate() as Date"); $Row = mysql_fetch_assoc($Query);
		$Date = substr($Row['Date'],2,2); $Status = true;
		for($x=1;$Status == true;$x++){
			$Num = mysql_num_rows(mysql_query("SELECT * FROM students"))+$x;
			$LastFour = substr($Num*.001,2,4);
			if($Data == "S"){
				$Data = 3;
			}
			$TmpNumber = $Date.'-'.$Data.'GS-'.$DataProgram.'-'.$LastFour;
			$Query = mysql_query("SELECT * FROM students WHERE StudentIDNumber = '$TmpNumber'");
			if(mysql_num_rows($Query) == 0){
				$Status = false;
			}
		}
		return $TmpNumber;
	}

	function StudentInfo($StudentID){
		$Row = mysql_fetch_assoc($Query = mysql_query("SELECT * FROM students WHERE StudentID = '$StudentID'"));
		return array($Row['StudentIDNumber'],$Row['StudentFirstName'],$Row['StudentMiddleName'],$Row['StudentSurname'],$Row['StudentAddress'],$Row['StudentMobileNumber'],$Row['StudentDateOfBirth'],$Row['StudentGuardian'],$Row['StudentGuardianMobileNumber'],$Row['StudentPicture'],$Row['StudentIDNumber']);
	}
	function Courses($Program){
		$Array = array();
		$Query = mysql_query("SELECT DISTINCT CourseTitle FROM courses WHERE Program = '$Program'");
		while($Row = mysql_fetch_assoc($Query)){
			$Array[] = $Row['CourseTitle'];
		}
		return $Array;
	}
	function Courses2(){
		$Array = array();
		$Query = mysql_query("SELECT DISTINCT CourseTitle FROM courses");
		while($Row = mysql_fetch_assoc($Query)){
			$Array[] = $Row['CourseTitle'];
		}
		return $Array;
	}
	function Fee($NameOfFee){
		$Query = mysql_query("SELECT * FROM fee WHERE FeeName = '$NameOfFee'");
		$Row = mysql_fetch_assoc($Query);
		return $Row['FeePrice'];
	}
	function Accounts($TNO){
		$Query = mysql_query("SELECT * FROM cashier WHERE TNO = '$TNO'") or die(mysql_error());
		$Row = mysql_fetch_assoc($Query);
		return array($Row['StudentIDNumber'],$Row['DateOfPayment'],$Row['AmmountPaid'],$Row['RecieptNumber']);
	}
	function PaidAccounts($StudentIDNumber){
		$Array = array();
		$Query = mysql_query("SELECT * FROM cashier WHERE StudentIDNumber = '$StudentIDNumber'") or die(mysql_error());
		while($Row = mysql_fetch_assoc($Query)){
			$Array[] = $Row['TNO'];
		}
		return $Array;
	}

	function &backup_tables($host, $user, $pass, $name, $tables = '*'){
	  $data = '-- Host: '.$host.'
		-- Generation Time: Jun 12, 2014 at 02:04 PM
		-- Server version: 5.6.12-log
		-- PHP Version: 5.4.16
		
		SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
		SET time_zone = "+00:00";
		
		
		/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
		/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
		/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
		/*!40101 SET NAMES utf8 */;
		
		--
		-- Database: '.$name.'
		--
		CREATE DATABASE IF NOT EXISTS '.$name.' DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
		USE '.$name.';';
	  $link = mysql_connect($host,$user,$pass);
	  mysql_select_db($name,$link);
	  mysql_query( "SET NAMES `utf8` COLLATE `utf8_general_ci`" , $link ); // Unicode
	
	  if($tables == '*'){ //get all of the tables
		$tables = array();
		$result = mysql_query("SHOW TABLES") or die(mysql_error());
		while($row = mysql_fetch_row($result)){
		  $tables[] = $row[0];
		}
	  }else{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	  }
	
	  foreach($tables as $table){
		$data.= "\n/*---------------------------------------------------------------".
            "\n  TABLE: `{$table}`".
            "\n  ---------------------------------------------------------------*/\n";           
		$data.= "DROP TABLE IF EXISTS `{$table}`;\n";
		$res = mysql_query("SHOW CREATE TABLE `{$table}`", $link);
		$row = mysql_fetch_row($res);
		$data.= $row[1].";\n";
	
		$result = mysql_query("SELECT * FROM `{$table}`", $link);
		$num_rows = mysql_num_rows($result);    
	
		if($num_rows>0){
		  $vals = Array(); $z=0;
		  for($i=0; $i<$num_rows; $i++){
			$items = mysql_fetch_row($result);
			$vals[$z]="(";
			for($j=0; $j<count($items); $j++){
			  if (isset($items[$j])) { $vals[$z].= "'".mysql_real_escape_string( $items[$j], $link )."'"; } else { $vals[$z].= "NULL"; }
			  if ($j<(count($items)-1)){ $vals[$z].= ","; }
			}
			$vals[$z].= ")"; $z++;
		  }
		  $data.= "INSERT INTO `{$table}` VALUES ";      
		  $data .= "  ".implode(";\nINSERT INTO `{$table}` VALUES ", $vals).";\n";
		}
	  }
	  mysql_close( $link );
	  return $data;
	  /*
		$backup_file = '../DBFiles/DB_BACKUP.sql'; //file
		$mybackup = $Functions->backup_tables("localhost","root","","enrolmentsystem","*");
		$handle = fopen($backup_file,'w+');
		fwrite($handle,$mybackup);
		fclose($handle);
	  
	  */
	  
	}
	function OldStudent($StudentID){
		$Units = 0;
		$Functions = new self;
		$Data = $Functions->SelectOne("students","StudentID","$StudentID");
		if(!empty($Data[1])){
			echo '
				<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  class="Box-shadow">
					<tr><td rowspan="6" width="20%" align="center" class="BorderRight"><span><img src="../StudentsPicture/Default.png" draggable="false"/></span></td><td width="20%">&nbsp;Name: </td><td>'.$Data[4].', '.$Data[2].' '.$Data[3].'</td></tr>
					<tr><td>&nbsp;Student Number:</td><td>'.$Data[1].'</td></tr>
					<tr><td>&nbsp;Address:</td><td>'.$Data[6].'</td></tr>
					<tr><td>&nbsp;Date of birth: </td><td>'.$Data[9].'</td></tr>
					<tr><td>&nbsp;Mobile: </td><td>'.$Data[7].'</td></tr>
					<tr><td colspan="2">&nbsp;Person notify to incase of emergency: '.$Data[11].' #'.$Data[12].'</td></tr>
				</table><br/><br/>
			';
		}
		else{
			echo 0;
		}
		$CourseQuery = mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$Data[1]'");
		$CourseRow = mysql_fetch_assoc($CourseQuery);
		$CourseTitle = $CourseRow['StudentCourse'];
		$Query = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$CourseTitle'");
		echo '<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="Box-shadow"><tr><td width="10%" align="center">Course Code</td><td align="center" width="50%">Descriptive Title</td><td width="5%" align="center">Units</td><td width="5%" align="center">Rating</td><td align="center" width="14%">Semester and Year</td><td align="center">Professor</td></tr>';
		while($Row = mysql_fetch_assoc($Query)){
			$CourseCode = $Row['CourseCode'];
			$EnrolledQuery = mysql_query("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$Data[1]' AND CourseCode = '$CourseCode'");
			$EnrolledRow = mysql_fetch_assoc($EnrolledQuery);
			if($EnrolledRow['CourseCode'] == $Row['CourseCode']){
				$Units = $Units + $Row['Units'];
				echo '
						<tr>
							<td align="center">'.$Row['CourseCode'].'</td>
							<td>'.$Row['DescriptiveTitle'].'</td>
							<td align="center">'.$Row['Units'].'</td>
							<td align="center">'.$EnrolledRow['Rating'].'	</td>
							<td align="center">'.$EnrolledRow['YearSem'].'</td>
							<td align="center">'.$EnrolledRow['Professor'].'</td>
						</tr>
				';
			}
		}
		echo '
				<tr>
					<td align="center"></td>
					<td align="right"><br/>Total units earned:</td>
					<td align="center"><br/><span id="StudentTotalUnits">'.$Units.'</span></td>
					<td align="center"></td>
					<td align="center"></td>
					<td align="center"></td>
				</tr>
		';
		echo '
				<tr>
					<td colspan="6">
						<button id="PrintUnits">Print Earned Units</button>
						<button id="PrintGoodMoral">Print Good Moral</button>
						<button id="PrintGrades">Print Grades</button>
						<button id="PrintOTR">Print OTR</button>
					</td>
				</tr>
		';
		echo '</table>';
		
	}
	function CrossEnrolleAndTransferee($StudentID){
		$Units = 0;
		$Functions = new self;
		$Data = $Functions->SelectOne("students","StudentID","$StudentID");
		if(!empty($Data[1])){
			echo '
				<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  class="Box-shadow">
					<tr><td rowspan="6" width="20%" align="center" class="BorderRight"><span><img src="../StudentsPicture/Default.png" draggable="false"/></span></td><td width="20%">&nbsp;Name: </td><td>'.$Data[4].', '.$Data[2].' '.$Data[3].'</td></tr>
					<tr><td>&nbsp;Student Number:</td><td>'.$Data[1].'</td></tr>
					<tr><td>&nbsp;Address:</td><td>'.$Data[6].'</td></tr>
					<tr><td>&nbsp;Date of birth: </td><td>'.$Data[9].'</td></tr>
					<tr><td>&nbsp;Mobile: </td><td>'.$Data[7].'</td></tr>
					<tr><td colspan="2">&nbsp;Person notify to incase of emergency: '.$Data[11].' #'.$Data[12].'</td></tr>
				</table><br/><br/>
			';
		}
		else{
			echo 0;
		}
		$CourseQuery = mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$Data[1]'");
		$CourseRow = mysql_fetch_assoc($CourseQuery);
		$CourseTitle = $CourseRow['StudentCourse']; $Rating;
		$Query = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$CourseTitle'");
		echo '<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="Box-shadow"><tr><td width="10%" align="center">Course Code</td><td align="center" width="50%">Descriptive Title</td><td width="10%" align="center">Units</td><td width="10%" align="center">Rating</td></tr>';
		for($x=0;$Row = mysql_fetch_assoc($Query);$x++){
			$CourseCoder = $Row['CourseCode'];
			$Data[1];
			$Query2 = mysql_query("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$Data[1]' AND CourseCode = '$CourseCoder'");
			$Row2 = mysql_fetch_assoc($Query2);
			$Rating = $Row2['Rating'];
			if(empty($Rating)){$Rating = 'Add Rating';}
			echo '
				<tr>
					<td align="center"><span id="RatingSubject'.$x.'">'.$Row['CourseCode'].'</span></td>
					<td>'.$Row['DescriptiveTitle'].'</td>
					<td colspan="2" align="right">
						<table border="0" width="100%" class="EnterRating" id="Ratingx'.$x.'">
							<tr>
								<td align="center" width="50%">'.$Row['Units'].'</td>
								<td align="center"><span id="Rated'.$x.'">'.$Rating.'</span></td>
							</tr>
						</table>
						<input type="hidden" value="'.$Functions->CodeGenerator().'" id="RatingCode">
						<input type="hidden" value="'.$Data[1].'" id="RatingStudentIDNumber">
						<input type="hidden" value="'.$CourseTitle.'" id="RatingCourseTitle">
						<span id="Rating'.$x.'" class="RatingChoices"><select id="RatingChoice'.$x.'">';
							$y=1;
							echo '<option>'.($y).'</option>';
							for($a=1;$a<9;$a++){
								echo '<option>'.($y=$y+0.25).'</option>';
							}
							echo '<option>4</option>';
							echo '<option>5</option>';
							echo '</select>
							<input type="button" value="Ok" id="BTN_Rating'.$x.'"/>
							<input type="button" value="Cancel" id="BTN_RatingCancel'.$x.'"/>
						</span>						
					</td>
				</tr>
			
			';
		}
		echo '</table>';
		
	}
}
?>