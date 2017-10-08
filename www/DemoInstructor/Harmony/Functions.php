<?php
include("gabruX/Functions.php");
$Function = new Functions;
class PDOFunctions extends Functions{
	function DBCon($Host = "localhost",$DataBase = "db_jpbagoong",$User = "root",$Password = ""){
		try{
			$PDO = new PDO('mysql:host='.$Host.';dbname='.$DataBase, $User, $Password);
			return $PDO; $PDO = null;
		}
		catch(PDOExcemption $e){
			echo 'There was an error connecting to your database.<br/>';
			echo 'Error:'.$e->getMessage();
		}
	}

	function PDO_Queried_RowCount($String){
		$Query = PDOFunctions::PDO_Query($String);
		return $Query->rowCount();
	} 

	function PDO_Query($QueryString){
		$Data = PDOFunctions::DBCon();
		$Query = $Data->prepare($QueryString);
		$Query->execute();
		return $Query;
	}

	function PDO_SQLQuery($QueryString){
		$Data = PDOFunctions::DBCon();
		$Query = $Data->prepare($QueryString);
		return $Query;
	}

	function PDO_SQL($SQLString){
		$Array = array();
		$Query = PDOFunctions::PDO_Query($SQLString);
		foreach ($Query->fetchAll(PDO::FETCH_NUM) as $key) {
			$Array[] = $key;
		}
		return $Array;
	}

	function PDO_RowCount($Table,$Column,$Condition){
		$Query = PDOFunctions::PDO_Query("SELECT * FROM $Table WHERE $Column = '$Condition'");
		return $Query->rowCount();
	}

	function PDO_TableCounter($Table){
		$Query = PDOFunctions::PDO_Query("SELECT * FROM $Table'");
		return $Query->rowCount();
	}

	function PDO_IDGenerator($Table,$ID){
		$Status = true;
		for($x=0;$Status == true;$x++){
			$TempID = sha1(PDOFunctions::PDO_TableCounter($Table)+$x);
			$Query = PDOFunctions::PDO_RowCount($Table,$ID,$TempID);
			if($Query == 0){
				$Status = false;
			}
		}
		return $TempID;
	}

	function PDO_DateNow(){
		$Query = PDOFunctions::PDO_SQLQuery("SELECT NOW()");
		$Query->execute();
		return $Query->fetch(PDO::FETCH_NUM)[0];
	}

	function Age($YearOfBirth){
		$YearOfBirth = explode('-',$YearOfBirth);
		$YearNow = explode('-', PDOFunctions::PDO_DateNow());
		return ($YearNow[0] - $YearOfBirth[2]);
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
        $ReturnString = FunctionsExt::SecureString($ReturnString);
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
        $ReturnString = FunctionsExt::SecureString($ReturnString);
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

	function Context($MaxSize,$String){
		$ReturnString = '';
		if(strlen($String) > $MaxSize)
			$ReturnString = FunctionsExt::CodeToChar2(FunctionsExt::CodeToChar(substr($String,0,($MaxSize)))).'...';
		else
			$ReturnString = FunctionsExt::CodeToChar2(FunctionsExt::CodeToChar(substr($String,0,($MaxSize))));

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