<?php
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
include("../PHPFiles2/Functions.php"); 
$Functions2 = new DatabaseClasses;
$Functions = new FunctionsExt;
if(isset($_GET['StudentInfo'])){
	$Default = "<table class='table Box-shadow'>
	                <tr>
	                    <td rowspan='6' width='15%' align='center' class='BorderRight'>
	                    <span id='PictureProfile'><div class='thumbnail'><img src='../StudentsPicture/Default.png' draggable='false'/></div></span></td>
	                    <td width='%'><strong>Name:</strong> <u></u></td>
	                </tr>
					<tr><td>Student Number:</td></tr>
					<tr><td>Address:</td></tr>
					<tr><td>Date of birth: </td></tr>
					<tr><td>Mobile: </td></tr>
					<tr><td>Person notify to incase of emergency: </td></tr>
                </table>";
	$AssessmentCode = $_POST['AssessmentCode'];
	if(!empty($AssessmentCode)){
		if(strlen($AssessmentCode) == 6){
		    $Q1 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE RegistrationCode = '{$AssessmentCode}'");
		    $Q2 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Q1[0][1]}'");
			if(count($Q2) == 1){
				echo "
					<table class='table Box-shadow'>
		                <tr>
		                    <td rowspan='6' width='15%' align='center' class='BorderRight'>
		                    <span id='PictureProfile'><div class='thumbnail'><img src='../StudentsPicture/{$Q2[0][13]}' draggable='false'/></div></span></td>
		                    <td width='%'><strong>Name:</strong> <u>{$Q2[0][4]}, {$Q2[0][2]} {$Q2[0][3]}</u></td>
		                </tr>
		                <tr>
		                    <td><strong>Student Number:</strong> <u>{$Q2[0][1]}</u></td>
		                </tr>
		                <tr>
		                    <td><strong>Address:</strong> <u>{$Q2[0][6]}</u></td>
		                </tr>
		                <tr>
		                    <td><strong>Date of birth:</strong> <u>{$Q2[0][9]}</u></td>
		                </tr>
		                <tr>
		                    <td><strong>Mobile:</strong> <u>{$Q2[0][7]}</u></td>
		                </tr>
		                <tr>
		                    <td><strong>Person notify to incase of emergency:</strong> <u>{$Q2[0][11]} #{$Q2[0][12]}</u></td>
		                </tr>
		            </table>
                ";						 
			}
			else
				echo $Default;
		}
		else
			echo $Default;
	}
	else
		echo $Default;
}

if(isset($_GET['RetrieveSubjectStudentData'])){
	$Units = 0; $AllMiscFee = ""; $TotalMiscFee = 0; $TotalLab = 0; $UnitCount = 0;
	$AssessmentCode = $_POST['AssessmentCode'];
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE RegistrationCode = '{$AssessmentCode}'");
    $Settings = $Functions2->PDO_SQL("SELECT * FROM settings WHERE SettingsLabel = 'EnrolmentCutOffDate'");
    $Date = $Functions2->PDO_DateNow();
    $Date1 = date("F j, Y",strtotime($Date)); 
    $Date2 = date("F j, Y",strtotime($Settings[0][2]));
	if(strlen($AssessmentCode) == 6){
		if(!empty($Q1[0][1])){
		    $QStudent = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$Q1[0][1]}'");
		    $QFee = $Functions2->PDO_SQL("SELECT * FROM fee ORDER BY FeeNumber ASC");
		    $QEnrolmentFee = $Functions2->PDO_SQL("SELECT * FROM fee WHERE Required = '1' ORDER BY FeeNumber ASC");
		    if($QStudent[0][11] === "International"){
			    if($QStudent[0][1] === "Doctoral")
			    	$Unit = $QFee[1][3];
			    else
			    	$Unit = $QFee[2][3];

			    if($QStudent[0][6] === "New"){
			    	$AllMiscFee .= "
						<tr>
							<td colspan='6'><label>{$QFee[5][1]}</label></td>
							<td><span class='pull-right'>{$QFee[5][3]}<span></td>
						</tr>
			    	";
			    	$TotalMiscFee = $TotalMiscFee + $QFee[5][3];
			    }

			    if($Date2 < $Date1){
			    	$AllMiscFee .= "
						<tr>
							<td colspan='6'><label>{$QFee[12][1]}</label></td>
							<td><span class='pull-right'>{$QFee[12][3]}<span></td>
						</tr>
			    	";
			    	$TotalMiscFee = $TotalMiscFee + $QFee[12][3];
			    }

			    $LabFee = $QFee[4][3];

			    foreach ($QEnrolmentFee as $a => $b) {
			    	$AllMiscFee .= "
						<tr>
							<td colspan='6'><label><input type='checkbox' value='{$b[3]}' checked id='FeeListValue_{$a}'> {$b[1]}</label></td>
							<td><span class='pull-right'>{$b[3]}<span></td>
						</tr>
			    	";
				    $TotalMiscFee = $TotalMiscFee + $b[3];
			    }
			}
			else{
			    if($QStudent[0][1] === "Doctoral")
			    	$Unit = $QFee[1][2];
			    else
			    	$Unit = $QFee[2][2];

			    if($QStudent[0][6] === "New"){
			    	$AllMiscFee .= "
						<tr>
							<td colspan='6'><label>{$QFee[5][1]}</label></td>
							<td><span class='pull-right'>{$QFee[5][2]}<span></td>
						</tr>
			    	";
			    	$TotalMiscFee = $TotalMiscFee + $QFee[5][2];
			    }

			    if($Date2 < $Date1){
			    	$AllMiscFee .= "
						<tr>
							<td colspan='6'><label>{$QFee[12][1]}</label></td>
							<td><span class='pull-right'>{$QFee[12][2]}<span></td>
						</tr>
			    	";
			    	$TotalMiscFee = $TotalMiscFee + $QFee[12][2];
			    }

			    $LabFee = $QFee[4][2];

			    foreach ($QEnrolmentFee as $a => $b) {
			    	$AllMiscFee .= "
						<tr>
							<td colspan='6'><label><input type='checkbox' value='{$b[2]}' checked id='FeeListValue_{$a}'> {$b[1]}</label></td>
							<td><span class='pull-right'>{$b[2]}<span></td>
						</tr>
			    	";
				    $TotalMiscFee = $TotalMiscFee + $b[2];
			    }
			}
			echo "
			<div class='panel panel-default'>
			<div class='panel-heading'>Assessment of fees</div>
			<table class='table'>
				<tr>
					<td colspan='7'>Tuition fee</td>
				</tr>
				<tr>
					<td align='center' width='20%'>Course Code</td>
					<td align='center'>Descriptive Title</td>
					<td align='center' width='5%'>Units</td>
					<td colspan='4'></td>
				</tr>
			";

			foreach ($Q1 as $key => $value) {
			    $Q2 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseCode = '{$value[2]}'");
			    $UnitCount = $UnitCount + $Q2[0][3];
				echo "
					<tr>
						<td align='center'>{$value[2]}</td>
						<td>{$Q2[0][2]}</td>
						<td align='center'>{$Q2[0][3]}</td>
						<td align='center' colspan='4'></td>
					</tr>
				";
			}
			$TotalTuition = ($UnitCount*$Unit);
			echo "
				<tr>
					<td colspan='2' align='right'>Total</td>
					<td align='center' width='3%'>{$UnitCount}</td>
					<td align='center'>x</td>
					<td align='center'>{$Unit}</td>
					<td align='center'width='5%'>=</td>
					<td align='center'><span id='TmpTuitionFee'>{$TotalTuition}</span></td>
				</tr>
				<tr>
					<td colspan='7'><br/><br/></td>
				</tr>
				<tr>
					<td colspan='6'>Miscellaneous Fee</td>
					<td width='5%' align='center'>Amount</td>
				</tr>
				";
			foreach ($Q1 as $key => $value) {
			    $Q2 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseCode = '{$value[2]}'");
				if($Q2[0][4] == "1"){
					echo "
						<tr>
							<td colspan='6'>Computer Laboratory for {$value[2]}</td>
							<td><span class='pull-right'>{$LabFee}</span></td>
						</tr>
					";
					$TotalLab = $TotalLab + $LabFee;
				}	
			}
			$TotalMiscFee = $TotalMiscFee + $TotalLab;
			$TuitionFee = $TotalTuition + $TotalMiscFee + $TotalLab;
			echo "
					{$AllMiscFee}
					<tr>
						<td colspan='6' align='right'>Total</td>
						<td><span class='pull-right' id='TmpMiscFee'>{$TotalMiscFee}</span></td>
					</tr>
					<tr>
						<td colspan='7'><br/><br/></td>
					</tr>
					<tr>
						<td>Tuition Fee</td>
						<td colspan='5'><span id='TotalTuitionFeeNotice' class='pull-right'></span></td>
						<td><span id='TotalTuitionFee' class='pull-right'>{$TotalTuition}</span></td>
					</tr>
					<tr>
						<td>Miscellaneous Fee</td>
						<td colspan='6'><span id='TotalMiscFee' class='pull-right'>{$TotalMiscFee}</span></td>
					</tr>
					<tr>
						<td colspan='6'><span class='pull-right'>Total</span></td>
						<td><span id='TmpTotalFee' class='pull-right'>{$TuitionFee}</span></td>
					</tr>
					<tr>
						<td colspan='7'><input type='button' value='Print and Save' id='PrintAssessed' class='btn btn-sm btn-success' /></td>
					</tr>
				  </table>
			</div>
			";
		//<td colspan='3'><input type='button' value='Print and Save'  id='PrintMe' class='btn btn-sm btn-success' /></td>
		}
	}
}

if(isset($_GET['SaveAssessed'])){
    $Date = $Functions2->PDO_DateNow();
	$Data = $_POST['Data'];
	$Scholarship = $Data[3];
	$ScholarDiscount = $Data[4];
	if($Scholarship === "No Scholarship")
		$Scholarship = "";

    $Q1 = $Functions2->PDO_SQL("SELECT * FROM assessmentoffee WHERE RegistrationCode = '{$Data[2]}'");
    $QEnrolled = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE RegistrationCode = '{$Data[2]}'");
    $QUpdateScholar = $Functions2->PDO_Query2("UPDATE studentscourse SET Scholarship = '{$Scholarship}', ScholarDiscount = '{$ScholarDiscount}' WHERE StudentIDNumber = '{$QEnrolled[0][1]}'");
    if(count($Q1)>0)
	    $Q2 = $Functions2->PDO_Query2("UPDATE assessmentoffee SET DateOfAssessment = '{$Date}', MiscFee = '{$Data[1]}', TuitionFee = '{$Data[0]}' WHERE RegistrationCode = '{$Data[2]}'");
    else
	    $Q2 = $Functions2->PDO_Query2("INSERT INTO assessmentoffee(DateOfAssessment,MiscFee,TuitionFee,StudentIDNumber,RegistrationCode) VALUES('{$Date}','{$Data[1]}','{$Data[0]}','{$QEnrolled[0][1]}','{$Data[2]}')");

	if($Q2 == 1 && $QUpdateScholar == 1)
		echo 1;
	else
		echo 0;
}

if(isset($_GET['StudentScholarshipForm'])){
	echo "
	<div class='panel panel-default'>
		<table class='table'>
			<tr>
				<td width='30%'>
                	Scholarship:<br>
					<select id='Scholarship' class='form-control'>
						<option>No Scholarship</option>
						<option>PSU-Faculty</option>
						<option>EHRDP</option>
						<option>Others</option>
					</select>
				</td>
				<td width='30%'><span id='PercentageSelect'>
                	Discount in percentage:<br/>
					<select id='Percentage' class='form-control'>
						<option>0</option>
						<option>25</option>
						<option>50</option>
						<option>75</option>
						<option>100</option>
						<option>Others</option>
					</select></span>
				</td>
                <td>
                </td>
			</tr>
			<tr>
				<td>
                    <div id='ScholarshipOther'class=' hidden'>
                    	<input type='text' placeholder='Other Scholarship' class='form-control' id='ScholarshipOtherInput'>
                    </div>
				</td>
				<td>
                    <div id='PercentageOther' class=' hidden'>
                    	<input type='text' placeholder='Percentage' class='form-control'  data-mask='99?.99' id='PercentageOtherInput'>
                    </div>
				</td>
                <td>
                </td>
			</tr>
			<tr>
				<td colspan='3'>
					<input type='button' class='btn btn-success btn-sm' value='Submit' id='StudentScholarship'>
				</td>
			</tr>                            
		</table>
	</div>
	";

}

?>