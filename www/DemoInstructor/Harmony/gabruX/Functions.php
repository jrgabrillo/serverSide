<?php
class Functions{
	function Get_ReadableDate($Date){
        $Data = explode(" ", $Date); $DataDate = explode("-", $Data[0]);
        $Month = array('January','February','March','April','May','June','July','August','September','October','November','December');
        return $Month[$DataDate[1]-1].' '.$DataDate[2].', '.$DataDate[0];
	}

	function Get_ReadableTime($Date){
        $Data = explode(" ", $Date);
        return $Data[1];
	}

	function Context($MaxSize,$String){
		if(strlen($String) > $MaxSize){
			return Functions::DehashText(substr($String,0,($MaxSize))).'...';
		}
		else
			return Functions::DehashText($String);
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

	function AlphaNumeric($Input,$InputLength){
		if(!preg_match("#^[a-zA-Z0-9]{1,".$InputLength."}$#", $Input))
			return 1;
	}

	function PlateNumberFourWheels($Input){
		if(!preg_match("#^[A-Z]{3}[\s|-][0-9]{3,4}$#", $Input))
			return 1;
	}

	function String($Input){
		if(!preg_match("#^[a-zA-Z\s]{1,200}$#", $Input))
			return 1;
	}

	function Number($Input){
		if(!preg_match("#^[0-9]{1,}$#", $Input))
			return 1;
	}

	function GreaterThanZero($Input){
		if(!preg_match("#^[1-9]{1,}$#", $Input))
			return 1;
	}

	function Money($Input){
		if(!preg_match("#^([0-9]{1,}|[0-9]{1,}[\.]{1}[0-9]{1,2})$#", $Input))
			return 1;
	}

	function Cheque($Input){
		if(!preg_match("#^[0-9]{1,12}$#", $Input))
			return 1;
	}

	function ValidStatement($Input){
		if(!preg_match("#^[a-zA-Z0-9\s]{1,1000}$#", $Input))
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
		if(!preg_match("#^[0-9]{6}$#", $Input))
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
}
?>