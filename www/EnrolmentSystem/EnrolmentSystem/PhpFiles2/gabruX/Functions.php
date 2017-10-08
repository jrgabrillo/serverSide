<?php
class DataClasses{

    function SemReader($Date){
        $Data = explode('-',$Date); $ReturnVal = '';
        if($Data[0] >= 6 && $Data[0] <= 10)
            $ReturnVal = '1st Semester';
        else if($Data[0] >= 4 && $Data[0] <= 5)
            $ReturnVal = 'Summer';
        else
            $ReturnVal = '2nd Semester';
        return $ReturnVal;
    }

    function SemesterYearReader($Date){
        $Data = explode('-',$Date); $ReturnVal = '';
        if($Data[0] >= 1 && $Data[0] <= 3)
            $ReturnVal = ($Data[2]-1).'-'.$Data[2];
        else if($Data[0] >= 11 && $Data[0] <= 12)
            $ReturnVal = $Data[2].'-'.($Data[2]+1);
        else
            $ReturnVal = $Data[2].'-'.($Data[2]+1);
        return $ReturnVal;
    }

	function Number($Input,$InputLength){
		if(!preg_match("#^[0-9]{1,".$InputLength."}$#", $Input))
			return 1;
	}

	function AlphaNumeric($Input,$InputLength){
		if(!preg_match("#^[a-zA-Z0-9]{1,".$InputLength."}$#", $Input))
			return 1;
	}

	function AlphaNumeric2($Input,$InputLength){
		if(!preg_match("#^[a-zA-Z0-9\s\-]{1,".$InputLength."}$#", $Input))
			return 1;
	}
	
	function Letters($Input){
		if(!preg_match("#^[a-zA-Z]{1,}$#", $Input))
			return 1;
	}
	function HashText($Input){
		$String = "";$RetString = "";
		$Hash = '\/';
 		for($x=0;$x<strlen($Input);$x++){
			if(substr($Input, $x,1) == "'"){
				$RetString .= $Hash."'";
			}
			if(substr($Input, $x,1) == '"'){
				$RetString .= $Hash.'"';
			}
			else if(substr($Input, $x,1) == ";"){
				$RetString .= $Hash.';';
			}
			else{
				$RetString .= substr($Input, $x,1);
			}
		}
		return $RetString;
	}

	function DehashText($Input){
		$Hash = '\/';$String = "";$RetString = "";
		$String = explode($Hash,$Input);
		foreach ($String as $key => $value) {
		    $RetString .= $value;
		}
		return $RetString;
	}

	function String($Input){
		if(!preg_match("#^[a-zA-Z]{1,200}$#", $Input))
			return 1;
	}

	function Money($Input){
		if(!preg_match("#^([0-9]{1,}|[0-9]{1,}[\.]{1}[0-9]{1,2})$#", $Input))
			return 1;
	}

	function ValidChars($Input){
		if(!preg_match("#^[a-zA-Z0-9\.\,\'/\"]{1,}$#", $Input))
			return 1;
	}
	function ValidateTitle($Input){
		if(!preg_match("#^[a-zA-Z0-9\.\,\-\/\[\]\(\)\s\'\"]{2,100}$#", $Input))
			return 1;		
	}	
	function InvalidCombination($Input){
		if(!preg_match("#^['\'\;']{2}$#", $Input))
			return 1;		
	}
	function UserChecker($SESSION,$RedirectLink){
		if(!isset($SESSION))
			header('location:'.$RedirectLink);
	}
	function ValidationReciept($Input){
		if(!preg_match("#^[0-9]{7}$#", $Input))
			return 1;
	}
	function ValidationPayment($Input){
		if(!preg_match("#^[0-9]{1,4}$#", $Input))
			return 1;
	}
	function ValidationCourseTitle($Input){
		if(!preg_match("#^[A-Z]{1}[a-zA-Z0-9\.\s\,\/\()\*\&\-]{1,}$#", $Input))
			return 1;
	}
	function ValidationAssessmentCode($Input){
		if(!preg_match("#^[a-zA-Z0-9]{6}$#", $Input))
			return 1;
	}		
	function ValidationCourseCode($Input){
		if(!preg_match("#^[A-Z]{1}[a-zA-Z\.\-\s]{1,9}\s[0-9]{1,3}$#", $Input))
			return 1;  
	}
	function ValidationPSUGSID($Input){
		if(!preg_match("#^[0-9]{2}\-[1-3]{1}GS\-[M|D]{1}\-[0-9]{3}$#", $Input))
			return 1;
	}
	function ValidationPSUStudentID($Input){
		if(!preg_match("#^[0|1][0-9]\-LN-[0-9]{4,5}$#", $Input))
			return 1;
	}
	function ValidationOUSStudentID($Input){
		if(!preg_match("#^[0|1][0-9]\-OUS-[0-9]{4,5}$#", $Input))
			return 1;
	}
	function ValidationImage($Input){
		if($Input != 'image/jpg' || $Input != 'image/jpeg' || $Input != 'image/gif' || $Input != 'image/png')
			return 1;
	}
	function ValidateCourse($Input){
		if(!preg_match("#^[A-Z][a-zA-Z\s\,\.\(\)\-]{1,}$#", $Input))
			return 1;
	}
	function ValidateNames($Input){
		if(!preg_match("#^[A-Z][a-zA-Z\s\-\.]{1,}$#", $Input))
			return 1;
	}
	function ValidateNumbers($Input){
		if($this->CheckEmpty($Input) == 1 || $this->CheckInteger($Input) == 1)
			return 1;
	}
	function CheckEmpty($Input){
		if(empty($Input))
			return 1;
	}
	function CheckInteger($Input){
		if(!is_numeric($Input))
			return 1;
	}
	function CheckMatch($Input1,$Input2){
		if($Input1 !== $Input2)
			return 1;
	}
	function ValidationEmpty($Input){
		if(empty($Input))
			return 1;
	}
	function ValidationStings($Input){
		if(!preg_match("#^[a-zA-Z\s\-\.]{1,}$#",$Input))
			return 1;
	}
	function ValidationExceed($Input,$Number = 20){
		if(strlen($Input) > $Number)
			return 1;
	}
	function ValidationEmail($Input){
		$Function = new Functions;
		$Data = $Function->ShowTable('account_info','email',$Input);
		if(!preg_match("#^[a-zA-Z0-9\-\_]{1,}\@[a-zA-Z0-9\-\.\_]{1,}\.[a-zA-Z]{2,6}$#",$Input))
			return 1;
		else{
			if(!empty($Data[3]))
					return 1;
		}
	}
	function ValidationMobile($Input){
		if(!preg_match("#^(0|\+63)[0-9]{10}$#",$Input))
			return 1;
	}
	function ValidationAddress($Input){
		if(!preg_match("#^[0-9\#]{1,6}\s[A-Z][a-zA-Z0-9\.\,\-\s]{1,}\s[A-Z][a-zA-Z]{1,}[\,\s|\s]{0,2}[A-Z][a-zA-Z]{1,}$#",$Input))
			return 1;
	}	
	function ValidationDOB($Input,$Range1,$Range2){
		if(!preg_match("#^(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)\-\d{1,2}\-\d{4}$#",$Input))
			return 1;
		$Data = explode('-',$Input);
		if($Data[1]>=32)
			return 1;
		if(is_numeric($Range1)&&is_numeric($Range2)){
			if($Data[2]<$Range1||$Data[2]>$Range2)
				return 1;
		}
		else
			return 1;
	}
	function ValidationZip($Input){
		if(!preg_match("#^\d{4}$#",$Input))
			return 1;		
	}
	function ValidationPassword($Input){
		if(strlen($Input) < 6 )
			return 1;
	}
	function ValidateGSID($Input){
		if(!preg_match("#^[0-9]{2}\-[0-9]{1}GS[M|D]{1}\-[0-9]{3}$#", $Input))
			return 1;
	}
	function ConfirmPassword($Input1,$Input2){
		if($Input != $Input2)
			return 1;
	}
	function DBConnection($Server,$Username,$Password,$Database){
		mysql_connect($Server,$Username,$Password) or die(mysql_error());
		mysql_select_db($Database) or die(mysql_error());
	}
	function Author(){
		return 'Author: Rufo N. Gabrillo Jr.<br/>Date: July 6, 2014<br/>Description: This is my library (of PHP and Javascript). I allow usage and modifiations of this library as long as you have my permission.<br/>Address: Macabito Calasiao Pangasinan<br/>
			Contact:<ul><li>Email: rufongabrillojr93@yahoo.com.ph</li><li>Phone: 09465040804</li><li>Facebook: www.facebook.com/ruforocks</li></ul>';
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
		}
		else{
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
						if (isset($items[$j])){$vals[$z].= "'".mysql_real_escape_string( $items[$j], $link )."'"; }
						else{$vals[$z].= "NULL";}
						if ($j<(count($items)-1)){$vals[$z].= ",";}
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
			DIY: How to use.
			$backup_file = '../DBFiles/DB_BACKUP.sql';
			$mybackup = $Functions->backup_tables("localhost","root","","enrolmentsystem","*");
			$handle = fopen($backup_file,'w+');
			fwrite($handle,$mybackup);
			fclose($handle);
		*/		
	}
}

?>