<?php
//include("gabruX/Functions.php");
//$Function = new DataClasses;
class DatabaseClasses{

	public $Data;
	public $Row;
	public $Key;
	public $Value;

	function OUSStudentIDNumberGenerator(){
		$Flag = true;
		$Q1 = DatabaseClasses::PDO_SQL("SELECT NOW()");
		$YearNow = date("y",strtotime($Q1[0][0]));

		for($Loop=1;$Flag == true;$Loop++){
			if(strlen($Loop)==1)
				$x = "000{$Loop}";
			else if(strlen($Loop)==2)
				$x = "00{$Loop}";
			else if(strlen($Loop)==3)
				$x = "0{$Loop}";
			else
				$x = "{$Loop}";

			$TempID = "{$YearNow}-OUS-{$x}";
			$Q2 = DatabaseClasses::PDO_SQL("SELECT DISTINCT StudentIDNumber FROM students WHERE StudentIDNumber = '{$TempID}'");
			if(count($Q2)==0)
				$Flag = false;
		}
		return "{$TempID}";
	}

    function Capitalize($String){
    	$String = strtolower($String);
    	$FirstChar = strtoupper(substr($String,0,1));
    	$String = substr($String,1,strlen($String));
        return "{$FirstChar}{$String}";
    }

	function YearSemNow(){
		$FirstSem = array('June','July','August','September','October');
		$SecondSem = array('November','December','January','February','March');
		$Summer = array('April','May'); $Sem = "";
		$Query = DatabaseClasses::PDO_SQL("SELECT DATE_FORMAT(NOW(),'%M')");
		$Month = $Query[0][0];
		if(in_array($Month, $FirstSem))
			$Sem = '1st Sem';
		else if(in_array($Month, $SecondSem))
			$Sem = '2nd Sem';
		else
			$Sem = 'Summer';
		$Query = DatabaseClasses::PDO_SQL("SELECT NOW()");
		$Year = date("Y",strtotime($Query[0][0]));
		return array($Year,$Sem);
	}

	function DBCon($Host,$DataBase,$User,$Password){
		try{
			$PDO = new PDO('mysql:host='.$Host.';dbname='.$DataBase, $User, $Password);
			return $PDO; $PDO = null;
		}
		catch(PDOExcemption $e){
			echo 'There was an error connecting to your database.<br/>';
			echo 'Error:'.$e->getMessage();
		}
	}

	function PDO_DateAndTime(){
		$Query = DatabaseClasses::PDO_Query("SELECT NOW() AS DateAndTime");
		foreach ($Query as $key => $value) {
			return $value[0];
		}
	}

	function PDO_Queried_RowCount($String){
		$Query = DatabaseClasses::PDO_Query($String);
		return $Query->rowCount();
	} 

	function PDO_Query($QueryString){
		$Data = DatabaseClasses::DBCon('localhost','enrolmentsystem','root','');
		$Query = $Data->prepare($QueryString);
		$Query->execute();
		return $Query;
	}

	function PDO_Query2($QueryString){
		$Data = DatabaseClasses::DBCon('localhost','enrolmentsystem','root','');
		$Query = $Data->prepare($QueryString);
		return $Query->execute();
	}

	function PDO_SQLQuery($QueryString){
		$Data = DatabaseClasses::DBCon('localhost','enrolmentsystem','root','');
		$Query = $Data->prepare($QueryString);
		return $Query;
	}

	function PDO_ShowTable($Table,$Column = "*",$Condition = "*"){
		if($Column == '*' || $Condition == "*"){
			$Array = array();
			$Query = DatabaseClasses::PDO_Query("SELECT * FROM $Table");
			foreach ($Query->fetchAll(PDO::FETCH_NUM) as $key) {
				$Array[] = $key;
			}
			return $Array;
		}
		else{
			$Array = array();
			$Query = DatabaseClasses::PDO_Query("SELECT * FROM $Table WHERE $Column = '$Condition'");
			foreach ($Query->fetchAll(PDO::FETCH_NUM) as $key) {
				$Array[] = $key;
			}
			return $Array;
		}
	}

	function PDO_SQL($SQLString){
		$Array = array();
		$Query = DatabaseClasses::PDO_Query($SQLString);
		foreach ($Query->fetchAll(PDO::FETCH_NUM) as $key) {
			$Array[] = $key;
		}
		return $Array;
	}

	function PDO_RowCount($Table,$Column,$Condition){
		$Query = DatabaseClasses::PDO_Query("SELECT * FROM $Table WHERE $Column = '$Condition'");
		return $Query->rowCount();
	}

	function PDO_ShowRow($Table,$Column,$Condition){
		$Array = array();
		$Query = DatabaseClasses::PDO_Query("SELECT * FROM $Table WHERE $Column = '$Condition'");
		if($Query->rowCount() > 0){
			foreach ($Query->fetch(PDO::FETCH_NUM) as $key => $value) {
				$Array[] = $value;
			}
			return $Array;
		}
	}

	function PDO_TableCounter($Table){
		$Query = DatabaseClasses::PDO_Query("SELECT * FROM $Table'");
		return $Query->rowCount();
	}

	function PDO_IDGenerator($Table,$ID){
		$Status = true;
		for($x=0;$Status == true;$x++){
			$TempID = sha1(DatabaseClasses::PDO_TableCounter($Table)+$x);
			$Query = DatabaseClasses::PDO_RowCount($Table,$ID,$TempID);
			if($Query == 0){
				$Status = false;
			}
		}
		return $TempID;
	}


	function CheckUserLog($Username,$Password){
		if(!isset($Username) && !isset($Password))
			return true;
	}

	function PDO_StudentIDNumberGenerator($Table,$ID){
		$Status = true; $RetString = ""; $Zero = '';
		$Query = DatabaseClasses::PDO_SQLQuery("SELECT * FROM $Table");
		$Query->execute(); $Num = $Query->rowCount();
		for($x=0;$x<5-strlen($Num);$x++){
			$Zero.="0";
		}
		$Year = substr(DatabaseClasses::PDO_DateNow(),2,2);
		$TempNum = $Zero.$Query->rowCount();

		return $Year.'-LN-'.$TempNum;
	}

	function PDO_DateNow(){
		$Query = DatabaseClasses::PDO_SQLQuery("SELECT NOW() as Date");
		$Query->execute();
		return $Query->fetch(PDO::FETCH_NUM)[0];
	}

	function Current_Age($YearOfBirth){
		$YearOfBirth = explode('-',$YearOfBirth);
		$YearNow = explode('-', DatabaseClasses::PDO_DateNow());
		return ($YearNow[0] - $YearOfBirth[2]);
	}

	function PSU_COURSES(){
		return $Array = array(
				"Bachelor of Arts in English (ABEng)",
				"Bachelor of Arts Economics (ABEcon)",
				"Bachelor of Arts Public Administration (BAPA)",
				"Bachelor of Science in Mathematics major in Pure Math (BSM)",
				"Bachelor of Science in Mathematics major in CIT (BSM)",
				"Bachelor of Science in Mathematics major in Statistics (BSM)",
				"Bachelor of Science in Computer Science (BSCS)",
				"Bachelor of Science in Computer and Information Technology (BSICT)",
				"Bachelor of Science in Hospitality Management (BSHM)",
				"Bachelor of Science in Nutrition and Dietetics (BSND)",
				"Bachelor of Secondary Education major in TLE (BSE)",
				"Bachelor of Secondary Education major in Social Studies (BSE)",
				"Bachelor of Secondary Education major in English (BSE)",
				"Bachelor of Secondary Education major in Physical Science (BSE)",
				"Bachelor of Secondary Education major in Filipino (BSE)",
				"Bachelor of Science in Business Administration (BSBM)",
				"Bachelor of Science in Social Work (BSSW)",
				"Bachelor of Technology in Teacher Education major in Automotive Technology (BSE)",
				"Bachelor of Technology in Teacher Education major in Civil Technology (BSE)",
				"Bachelor of Technology in Teacher Education major in Ceramics Technology (BSE)",
				"Bachelor of Technology in Teacher Education major in Clothing and Fashion Technology (BSE)",
				"Bachelor of Technology in Teacher Education major in Drafting and Graphic Design (BSE)",
				"Bachelor of Technology in Teacher Education major in Electrical Technology (BSE)",
				"Bachelor of Technology in Teacher Education major in Electronics Technology (BSE)",
				"Bachelor of Technology in Teacher Education major in Food Service Management (BSE)",
				"Bachelor of Technology in Teacher Education major in Mechanical Technology (BSE)",
				"Bachelor in Industrial Technology (BIT)"
				);
	}

	function PSU_ScholarType(){
		return $Array = array("Presidents Lister","Deans Lister","Athletic","Entrance","DOST","CHED","SK","Legal Dependents of Brgy. Officials","Private Sponsored","Others");
	}

	function DateNow(){
		$Row = mysql_fetch_assoc(mysql_query("SELECT curdate() as Date"));
		return $Row['Date'];
	}

	function TimeNow(){
		$Row = mysql_fetch_assoc(mysql_query("SELECT CURTIME() as Date"));
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

	function PasswordGenerator($Table,$ID){
		$Functions = new self;
		$Status = true;
		for($x=0;$Status == true;$x++){
			$TempID = substr(sha1($Functions->TableCounter($Table)+$x),0,10);
			$Query = mysql_query("SELECT * FROM $Table WHERE $ID = '$TempID'");
			if(mysql_num_rows($Query) == 0){
				$Status = false;
			}
		}
		return $TempID;
	}	

	function UserCheck($Username,$Password){
		$Query = mysql_query("SELECT * FROM tbl_members WHERE MembersStudentID = '$Username' and MembersPassword = '$Password' ");
		return mysql_num_rows($Query);
	}

	function StudentIDNumberGenerator($Table,$ID){
		$Function = new self; $a=''; $Status = true;
		$Query = mysql_query("SELECT curdate() as Date"); $Row = mysql_fetch_assoc($Query);
		$Date = substr($Row['Date'],2,2);
		for($x=1;$Status == true;$x++){
			$Num = mysql_num_rows(mysql_query("SELECT * FROM $Table"))+$x;
			for($x=0;$x<(5 - strlen($Num));$x++){
				$a .= "0";
			}
			$TmpNumber = $Date.'-'.'LN-'.$a.$Num;
			$Query = mysql_query("SELECT * FROM $Table WHERE $ID = '$TmpNumber'");
			if(mysql_num_rows($Query) == 0){
				$Status = false;
			}
		}
		return $TmpNumber;
	}

	function Message($Type,$Icon,$Message){
		if($Type == 'danger'){
			echo '<span class="label label-danger"><span class="'.$Icon.'"></span> '.$Message.'</span>';
		}
		else if($Type == 'warning'){
			echo '<span class="label label-warning"><span class="'.$Icon.'"></span> '.$Message.'</span>';
		}
		else if($Type == 'success'){
			echo '<span class="label label-success"><span class="'.$Icon.'"></span> '.$Message.'</span>';
		}
		else if($Type == 'primary'){
			echo '<span class="label label-primary"><span class="'.$Icon.'"></span> '.$Message.'</span>';
		}
		else{
			echo '<span class="label label-default"><span class="'.$Icon.'"></span> '.$Message.'</span>';
		}

	}
	function Age($Range1,$Range2){
		$Range = -($Range1 - $Range2); $ReturnData = "";
		for($x=0;$x<=$Range;$x++){
			$ReturnData .= "<option>".($Range1+$x)."</option>";
		}
		return $ReturnData;
		//return $Range;
	}

	function DescribeTable($TableName,$x,$y,$WhereClause = ''){
		$RetVal = '';
	    $Query = DatabaseClasses::PDO_SQL2("DESCRIBE {$TableName}");
	    $Query1 = DatabaseClasses::PDO_SQL2("SELECT * FROM $TableName $WhereClause LIMIT {$x},{$y}");
	    foreach ($Query1 as $key1 => $value1) {
            $RetVal .= "{";
		    foreach ($Query as $key => $value) {
		    	$v1 = $value[0];$v2 = DatabaseClasses::JSONCharToCode($value1[$key]);
		    	$RetVal .= "\"{$v1}\":\"{$v2}\"";
		        if(count($Query) != ($key+1))
		            $RetVal .= ",";
		    }
            $RetVal .= ',"Button":"<a href=\'#Options#'.DatabaseClasses::JSONCharToCode($value1[0]).'\' class=\'btn btn-sm btn-success\'>Details</a>"}';
	        if(count($Query1) != ($key1+1))
	            $RetVal .= ",";
	    }
	    return $RetVal;
	}


	function BackUpTable($TableName,$WhereClause = ''){
	    $RetVal = '{"'.$TableName.'":['; $loop = 0;
	    $Query = DatabaseClasses::PDO_SQL2("SELECT COUNT(*) FROM $TableName $WhereClause");
	    $LoopTotal = ceil($Query[0][0] / 50000);
	    for($x=0;$x<$Query[0][0];$x=$x+50000){
	    	$y=$x+50000; $loop++;
	    	if($loop == $LoopTotal){
		    	$RetVal .= DatabaseClasses::DescribeTable($TableName,$x,$y,$WhereClause);
	    	}
		    else{
		    	$RetVal .= DatabaseClasses::DescribeTable($TableName,$x,$y,$WhereClause).',';
		    }
	    }
	    $RetVal .= ']}';
	    return $RetVal;
	}

    function SecureString($String){
        $String = trim($String);
        $String = str_replace(PHP_EOL,"<33>  ",$String);
        $String = str_replace("\n","<33>  ",$String);
        $String = str_replace("\r","<33>  ",$String);
        return $String;
    }    

    function CodeToChar2($StringToConvert,$StringCount = 4){
        $Array1 = array('!','@','#','$','%','^','&','*','(',')','_','+','-','=','{','}','[',']','\\','|',';',"'",':','"',',','.','<','>','/','?','`','~','<br/>');
        $Array2 = array('<01>','<02>','<03>','<04>','<05>','<06>','<07>','<08>','<09>','<10>','<11>','<12>','<13>','<14>','<15>','<16>','<17>','<18>','<19>','<20>','<21>','<22>','<23>','<24>','<25>','<26>','<27>','<28>','<29>','<30>','<31>','<32>','<33>');
        $ReturnString = '';

        for($x=0;$x<strlen($StringToConvert);$x++){
            if(in_array(substr($StringToConvert,$x,6),$Array2)){
                foreach ($Array2 as $key => $value) {
                    if(substr($StringToConvert,$x,6) == $value){
                        $ReturnString .= $Array1[$key];
                    	$x=$x+$StringCount;
                    }
                }
            }
            else
                $ReturnString .= substr($StringToConvert,$x,1);
        }
        return $ReturnString;
    }

    function CodeToChar($StringToConvert,$StringCount = 4){
        $Array1 = array('!','@','#','$','%','^','&','*','(',')','_','+','-','=','{','}','[',']','\\','|',';',"'",':','"',',','.','<','>','/','?','`','~','<br/>');
        $Array2 = array('<01>  ','<02>  ','<03>  ','<04>  ','<05>  ','<06>  ','<07>  ','<08>  ','<09>  ','<10>  ','<11>  ','<12>  ','<13>  ','<14>  ','<15>  ','<16>  ','<17>  ','<18>  ','<19>  ','<20>  ','<21>  ','<22>  ','<23>  ','<24>  ','<25>  ','<26>  ','<27>  ','<28>  ','<29>  ','<30>  ','<31>  ','<32>  ','<33>  ');
        $ReturnString = '';

        for($x=0;$x<strlen($StringToConvert);$x++){
            if(in_array(substr($StringToConvert,$x,6),$Array2)){
                foreach ($Array2 as $key => $value) {
                    if(substr($StringToConvert,$x,6) == $value){
                        $ReturnString .= $Array1[$key];
                    	$x=$x+$StringCount;
                    }
                }
            }
            else
                $ReturnString .= substr($StringToConvert,$x,1);
        }
        return $ReturnString;
    }

    function CharToCode($StringToConvert){
        $Array1 = array('!','@','#','$','%','^','&','*','(',')','_','+','-','=','{','}','[',']','\\','|',';',"'",':','"',',','.','<','>','/','?','`','~','<br/>');
        $Array2 = array('<01>  ','<02>  ','<03>  ','<04>  ','<05>  ','<06>  ','<07>  ','<08>  ','<09>  ','<10>  ','<11>  ','<12>  ','<13>  ','<14>  ','<15>  ','<16>  ','<17>  ','<18>  ','<19>  ','<20>  ','<21>  ','<22>  ','<23>  ','<24>  ','<25>  ','<26>  ','<27>  ','<28>  ','<29>  ','<30>  ','<31>  ','<32>  ','<33>  ');
        $ReturnString = '';

        for($x=0;$x<strlen($StringToConvert);$x++){
            if(in_array(substr($StringToConvert,$x,1),$Array1)){
                foreach ($Array1 as $key => $value) {
                    if(substr($StringToConvert,$x,1) == $value)
                        $ReturnString .= $Array2[$key];
                }
            }
            else
                $ReturnString .= substr($StringToConvert,$x,1);
        }
        $ReturnString = DatabaseClasses::SecureString($ReturnString);
        return $ReturnString;
    }

    function JSONCharToCode($StringToConvert){
        $Array1 = array('{','}','[',']','\\',"'",'"',',');
        $Array2 = array('<01>','<02>','<03>','<04>','<05>','<06>','<07>','<08>');
        $ReturnString = '';
        for($x=0;$x<strlen($StringToConvert);$x++){
            if(in_array(substr($StringToConvert,$x,1),$Array1)){
                foreach ($Array1 as $key => $value) {
                    if(substr($StringToConvert,$x,1) == $value)
                        $ReturnString .= $Array2[$key];
                }
            }
            else
                $ReturnString .= substr($StringToConvert,$x,1);
        }
        $ReturnString = DatabaseClasses::SecureString($ReturnString);
        return $ReturnString;
    }

    function JSONCodeToChar($StringToConvert,$StringCount = 4){
        $Array1 = array('{','}','[',']','\\',"'",'"',',');
        $Array2 = array('<01>','<02>','<03>','<04>','<05>','<06>','<07>','<08>');
        $ReturnString = '';
        for($x=0;$x<strlen($StringToConvert);$x++){
            if(in_array(substr($StringToConvert,$x,6),$Array2)){
                foreach ($Array2 as $key => $value) {
                    if(substr($StringToConvert,$x,6) == $value){
                        $ReturnString .= $Array1[$key];
                    	$x=$x+$StringCount;
                    }
                }
            }
            else
                $ReturnString .= substr($StringToConvert,$x,1);
        }
        return $ReturnString;
    }

	function Get_ReadableDate($Date){
		$Date = DatabaseClasses::CodeToChar($Date,5);
        $Data = explode(" ", $Date); $DataDate = explode("-", $Data[0]);
        $Month = array('January','February','March','April','May','June','July','August','September','October','November','December');
        return $Month[$DataDate[1]-1].' '.$DataDate[2].', '.$DataDate[0];
	}

	function Get_ReadableTime($Date){
		$Date = DatabaseClasses::CodeToChar($Date,5);
        $Data = explode(" ", $Date);
        return $Data[1];
	}

	function Context($MaxSize,$String){
		$ReturnString = '';
		if(strlen($String) > $MaxSize)
			$ReturnString = DatabaseClasses::CodeToChar2(DatabaseClasses::CodeToChar(substr($String,0,($MaxSize)))).'...';
		else
			$ReturnString = DatabaseClasses::CodeToChar2(DatabaseClasses::CodeToChar(substr($String,0,($MaxSize))));

		return nl2br($ReturnString);
	}

	function TextPreview($String,$MaxSize){
		$ReturnString = '';
		if(strlen($String) > $MaxSize)
			$ReturnString = substr($String,0,($MaxSize)).'...';
		else
			$ReturnString = substr($String,0,($MaxSize));

		return $ReturnString;
	}

}
?>