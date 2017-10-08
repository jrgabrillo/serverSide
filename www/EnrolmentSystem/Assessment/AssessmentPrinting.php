<link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap.css" type="text/css"/>
<style>
.col-md-6{
	width:500px;
}
small{
	font-size: 5px;
}
</style>
<?php
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
include("../PHPFiles2/Functions.php"); 
$Functions2 = new DatabaseClasses;
$Functions = new FunctionsExt;
if(isset($_GET['PrintAssessment'])){
	echo "<small>";
	$Units = 0; $AllMiscFee = ""; $TotalMiscFee = 0; $TotalLab = 0; $UnitCount = 0; $CompLabSubject = "";
	$AssessmentCode = $_POST['AssessmentCode'];
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE RegistrationCode = '{$AssessmentCode}'");
    $Date = $Functions2->PDO_DateNow();
    $Term = $Functions2->YearSemNow();
    $Settings = $Functions2->PDO_SQL("SELECT * FROM settings WHERE SettingsLabel = 'EnrolmentCutOffDate'");
    $Date1 = date("F j, Y",strtotime($Date)); 
    $Date2 = date("F j, Y",strtotime($Settings[0][2]));

	if(strlen($AssessmentCode) == 6){
		if(!empty($Q1[0][1])){
		    $QStudent = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$Q1[0][1]}'");
		    $QStudent2 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Q1[0][1]}'");
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
							<td colspan='5'><label>{$QFee[5][1]}</label></td>
							<td><span class='pull-right'>{$QFee[5][3]}<span></td>
						</tr>
			    	";
			    	$TotalMiscFee = $TotalMiscFee + $QFee[5][3];
			    }

			    if($Date2 < $Date1){
			    	$AllMiscFee .= "
						<tr>
							<td colspan='5'><label>{$QFee[12][1]}</label></td>
							<td><span class='pull-right'>{$QFee[12][3]}<span></td>
						</tr>
			    	";
			    	$TotalMiscFee = $TotalMiscFee + $QFee[12][3];
			    }
			    $LabFee = $QFee[4][3];

			    foreach ($QEnrolmentFee as $a => $b) {
			    	$AllMiscFee .= "
						<tr id='FeeListRow_{$a}'>
							<td colspan='5'><label>{$b[1]}</label></td>
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
							<td colspan='5'><label>{$QFee[5][1]}</label></td>
							<td><span class='pull-right'>{$QFee[5][2]}<span></td>
						</tr>
			    	";
			    	$TotalMiscFee = $TotalMiscFee + $QFee[5][2];
			    }

			    if($Date2 < $Date1){
			    	$AllMiscFee .= "
						<tr>
							<td colspan='5'><label>{$QFee[12][1]}</label></td>
							<td><span class='pull-right'>{$QFee[12][2]}<span></td>
						</tr>
			    	";
			    	$TotalMiscFee = $TotalMiscFee + $QFee[12][2];
			    }
			    $LabFee = $QFee[4][2];

			    foreach ($QEnrolmentFee as $a => $b) {
			    	$AllMiscFee .= "
						<tr id='FeeListRow_{$a}'>
							<td colspan='5'><label>{$b[1]}</label></td>
							<td><span class='pull-right'>{$b[2]}<span></td>
						</tr>
			    	";
				    $TotalMiscFee = $TotalMiscFee + $b[2];
			    }
			}			
			foreach ($Q1 as $key => $value) {
			    $Q2 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseCode = '{$value[2]}'");
			    $UnitCount = $UnitCount + $Q2[0][3];
			}
			foreach ($Q1 as $key => $value) {
			    $Q2 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseCode = '{$value[2]}'");
				if($Q2[0][4] == "1"){
					$CompLabSubject .= "
						<tr>
							<td colspan='5'>Computer Laboratory for {$value[2]}</td>
							<td><span class='pull-right'>{$LabFee}</span></td>
						</tr>
					";
					$TotalLab = $TotalLab + $LabFee;
				}	
			}
			$TotalTuition = ($UnitCount*$Unit);
			$subjectCount = count($Q1);
			$TotalMiscFee = $TotalMiscFee + $TotalLab;
			$TuitionFee = $TotalTuition + $TotalMiscFee + $TotalLab;
			echo "
				<div class='panel panel-default'>
					<div class='panel-heading text-center'>
						<h4>
							Pangasinan State University<br/>
							<small>
								<strong>Open University System</strong><br/>
								Lingayen Campus
							</small>
						</h4>
						<u><strong>Assessment of Fees</strong></u>
					</div>
					<table class='table'>
						<tr>
							<td>
								<div class='col-md-6'>
									<table class='table table-bordered'>
										<tr>
											<td>
												<strong>Name: </strong><u>{$QStudent2[0][4]}, {$QStudent2[0][2]} {$QStudent2[0][3]}</u><br/>
												<strong>Student ID Number: </strong><u>{$QStudent[0][3]}</u><br/>
												<strong>Program: </strong><u>{$QStudent[0][1]}<br/></u>
												<strong>Course: </strong><u>{$QStudent[0][2]}</u><br/>
												<strong>Term: </strong><u>{$Term[0]}/{$Term[1]}</u><br/>
												<strong>Date: </strong><u>{$Date}</u><br/>
											</td>
										</tr>
									</table>

									<table class='table table-bordered'>
										<tr>
											<td colspan='5' width='90%'>Tuition Fee <span id='TotalTuitionFeeNotice2' class='pull-right'></span></td>
											<td><span id='TotalTuitionFee2' class='pull-right'>{$TotalTuition}</span></td>
										</tr>
										<tr>
											<td colspan='5'>Miscellaneous Fee</td>
											<td><span id='TotalMiscFee2' class='pull-right'>{$TotalMiscFee}</span></td>
										</tr>
										<tr>
											<td colspan='5'><span class='pull-right'>Total</span></td>
											<td><span id='TmpTotalFee2' class='pull-right'>{$TuitionFee}</span></td>
										</tr>
									</table>

									<table class='table table-bordered'>
										<tr>
											<td align='center'>Amount Paid</td>
											<td align='center'>Receipt Number</td>
											<td align='center'>Date</td>
										</tr>
										<tr>
											<td><br/></td><td><br/></td><td><br/></td>
										</tr>
										<tr>
											<td><br/></td><td><br/></td><td><br/></td>
										</tr>
										<tr>
											<td><br/></td><td><br/></td><td><br/></td>
										</tr>
										<tr>
											<td><br/></td><td><br/></td><td><br/></td>
										</tr>
										<tr>
											<td><br/></td><td><br/></td><td><br/></td>
										</tr>
									</table>
								</div>
							</td>
							<td>
								<div class='col-md-6 '>
									<div class='panel panel-default'>
									<div class='panel-heading'>Tuition fee</div>
									<table class='table'>
										<tr>
											<td align='center'>Total no. of subject</td>
											<td align='center'>Total no. of units</td>
											<td></td>
											<td align='center'>Per unit</td>
											<td></td>
											<td align='center'>Total</td>
										</tr>
										<tr>
											<td align='center'>{$subjectCount} </td>
											<td align='center'>{$UnitCount}</td>
											<td align='center'>x</td>
											<td align='center'>{$Unit}</td>
											<td align='center'>=</td>
											<td align='center'><span id='TmpTuitionFee'>{$TotalTuition}</span></td>
										</tr>
										<tr>
											<td colspan='6'><br/></td>
										</tr>
										<tr>
											<td colspan='5'>Miscellaneous Fee</td>
											<td width='5%' align='center'>Amount</td>
										</tr>
											{$CompLabSubject}
											{$AllMiscFee}
										<tr>
											<td colspan='5' align='right'>Total</td>
											<td><span class='pull-right' id='TmpMiscFee2'>{$TotalMiscFee}</span></td>
										</tr>
									</table>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
		</small>";
		}
	}
}
?>