<?php
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
include("../PHPFiles2/Functions.php"); 
$Functions2 = new DatabaseClasses;
$Functions = new FunctionsExt;

if(isset($_GET['ReportQuery'])){
    $Total = 0; $Collection = "";
    $SummarySubTotal = 0; $SummaryTotal = 0; $SummeryOfCollection = "";
    $Data = $_POST['DataReport'];

    $Date = "{$Data[0]}-01-{$Data[1]}";
    $GetMonth = date("m",strtotime($Date));
    $Date = date("m-d",strtotime($Date));
    $Date1 = "{$Data[1]}-{$Date}";
    $Date2 = $Functions2->PDO_SQL("SELECT LAST_DAY('$Date1')");
    $Date2 = $Date2[0][0];

    $Q1 = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE DateOfPayment BETWEEN '$Date1' AND '$Date2' ORDER BY DateOfPayment ASC");
    foreach ($Q1 as $a => $b) {
    	$Total = $Total + $b[3];
	    $QStudent = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$b[1]}'");
    	$Collection .= "
    		<tr>
    			<td align='center'>
		    		{$b[4]}
    			</td>
    			<td>
		    		{$QStudent[0][4]} {$QStudent[0][2]}, {$QStudent[0][3]} 
    			</td>
    			<td align='center'>
		    		{$b[3]}
    			</td>
    			<td align='center'>
		    		{$b[2]}
    			</td>
    		</tr>
    	";
    }

    $QDateDiff = $Functions2->PDO_SQL("SELECT DATEDIFF('$Date2','$Date1')");

    for($x=1;$x<=($QDateDiff[0][0]+1);$x++){
    	if($x<=9)
		    $DateX = "{$Data[1]}-{$GetMonth}-0{$x}";
		else
		    $DateX = "{$Data[1]}-{$GetMonth}-{$x}";

	    $Q2 = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE DateOfPayment = '{$DateX}' ORDER BY DateOfPayment ASC");
	    if(count($Q2)>0){
	    	$SummarySubTotal = 0;
	    	foreach ($Q2 as $a => $b) {
			    $SummarySubTotal = $SummarySubTotal + $b[3];
	    	}
		    $SummeryOfCollection .= "
		    	<tr>
		    		<td width='10%'>{$x}</td>
		    		<td>{$SummarySubTotal}</td>
		    	</tr>
		    ";
		    $SummaryTotal = $SummaryTotal + $SummarySubTotal;
	    }
    }

    echo "
    		<tr>
    			<td>
    				<div class='col-md-7'>
    					Collection Report
        				<table class='table table-bordered'>
                    		<tr>
                    			<td class='text-center' width='10%'>OR Number</td>
                    			<td width='30%'>Name</td>
                    			<td class='text-center' width='10%'>Amount Paid</td>
                    			<td class='text-center' width='10%'>Date of Payment</td>
                    		</tr>
	                    	{$Collection}
                    		<tr>
                    			<th colspan='2'><span class='pull-right'>Total: </span></th>
                    			<th class='text-center'>{$Total}</th>
                    			<th></th>
                    		</tr>
        				</table>
		            </div>
    				<div class='col-md-5'>
    					Summary
        				<table class='table table-bordered'>
                        	<tr>
				        		<td colspan='2'>{$Data[0]} {$Data[1]}</td>
                        	</tr>
                        	{$SummeryOfCollection}
                        	<tr>
                        		<th><span class='pull-right'>Total: </span></td>
                        		<th>{$SummaryTotal}</td>
                        	</tr>
        				</table>
		            </div>
    			</td>
    		</tr>
    ";
}

if(isset($_GET['CollectionReportForm'])){
    $Total = 0; $SummarySubTotal = 0; $SummaryTotal = 0; $Collection = ""; $SummeryOfCollection = ""; $Year = "<option>Year</option>"; $Month = "<option>Month</option>"; $YearArray = []; 
	$MonthArray = ['January','February','March','April','May','June','July','August','September','October','November','December'];

    $Date = $Functions2->PDO_DateNow();
    $GetMonth = date("F",strtotime($Date));
    $GetYear = date("Y",strtotime($Date));
    $Date1 = date("Y-m-",strtotime($Date))."01";
    $Date2 = date("Y-m-d",strtotime($Date));    	

    $Qa = $Functions2->PDO_SQL("SELECT DISTINCT DateOfPayment FROM cashier");
    foreach ($Qa as $a => $b) {
    	$YearExtract = explode("-",$b[0]);
    	$NeedleYear = $YearExtract[0];
    	if(!in_array($NeedleYear,$YearArray)){
    		$YearArray[] = $YearExtract[0];
    	}
    }

    foreach ($YearArray as $a => $b){
    	if($b == $GetYear)
	    	$Year .= "<option selected>{$b}</option>";
	    else
	    	$Year .= "<option>{$b}</option>";
    }

    foreach ($MonthArray as $a => $b){
    	if($b == $GetMonth)
	    	$Month .= "<option selected>{$b}</option>";
	    else
	    	$Month .= "<option>{$b}</option>";
    }

    $Q1 = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE DateOfPayment BETWEEN '$Date1' AND '$Date2'");
    foreach ($Q1 as $a => $b) {
    	$Total = $Total + $b[3];
	    $QStudent = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$b[1]}'");
    	$Collection .= "
    		<tr>
    			<td align='center'>
		    		{$b[4]}
    			</td>
    			<td>
		    		{$QStudent[0][4]} {$QStudent[0][2]}, {$QStudent[0][3]}
    			</td>
    			<td align='center'>
		    		{$b[3]}
    			</td>
    			<td align='center'>
		    		{$b[2]}
    			</td>
    		</tr>
    	";
    }

    $QDateDiff = $Functions2->PDO_SQL("SELECT DATEDIFF('$Date2','$Date1')");
    for($x=1;$x<=($QDateDiff[0][0]+1);$x++){
    	if($x<=9)
		    $DateX = date("Y-m-",strtotime($Date))."0{$x}";
		else
		    $DateX = date("Y-m-",strtotime($Date))."{$x}";

	    $Q2 = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE DateOfPayment = '{$DateX}'");
	    if(count($Q2)>0){
	    	$SummarySubTotal = 0;
	    	foreach ($Q2 as $a => $b) {
			    $SummarySubTotal = $SummarySubTotal + $b[3];
	    	}
		    $SummeryOfCollection .= "
		    	<tr>
		    		<td width='10%'>{$x}</td>
		    		<td>{$SummarySubTotal}</td>
		    	</tr>
		    ";
		    $SummaryTotal = $SummaryTotal + $SummarySubTotal;
	    }
    }

	echo "
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h4>
					Collection Report
					<span class='col-md-4 pull-right'>
						<input type='button' class='btn btn-sm btn-warning pull-right' value='Print' id='ButtonPrintReport'>
					</span>
				</h4>
			</div> 	
			<div class='panel-body'>
				<span class='col-md-4 pull-right'>
            		<select class='btn btn-sm btn-default' id='SelectReportMonth'>
            			{$Month}
            		</select>
            		<select class='btn btn-sm btn-default' id='SelectReportYear'>
            			{$Year}
            		</select>
            		<input type='button' class='btn btn-sm btn-primary' value='Show report' id='ButtonReport'>
				</span>
            </div>
        	<table class='table' id='QueriedCollectionReport'></table>
		</div>
	";
}

if(isset($_GET['OtherFeeForm'])){
	echo "
		<div class='panel panel-default'>
			<div class='panel-heading'><h4>Other Fee</h4></div>
			<div class='panel-body'>
				<div class='col-md-3'>
					Student ID:
					<input type='text' class='form-control' data-mask='99-OUS-9999' placeholder='Student ID' id='OtherFeeStudentID'>
				</div>
				<div class='col-md-3'>
					Receipt Number:
					<input type='text' class='form-control' data-mask='9999999' placeholder='Official Receipt' id='OtherFeeOR'>
				</div>
			</div>
			<div id='OtherFeeHolder'></div>

		</div>
	";
}

if(isset($_GET['OtherFee'])){
	$Fee = ""; $Fee2 = "";
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM fee WHERE Required = '2'");
    $QStudent = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$_POST['Data']}'");
    if(count($QStudent)>0){
	    if($QStudent[0][11] === "International"){
		    foreach ($Q1 as $a => $b) {
		    	$Fee .= "
		    		<tr>
		    			<td>
		    				<div class='col-md-5'>
			    				{$b[1]}
		    				</div>
		    				<div class='col-md-3 pull-right'>
			    				<button class='btn btn-xs btn-danger pull-right glyphicon glyphicon-plus AddOtherFee'></button>
		    				</div>
		    				<div class='col-md-2 pull-right'>
			    				<span class=''>P {$b[3]}</span>
		    				</div>
		    			</td>
		    		</tr>
		    	";
		    	$Fee2 .= "
		    		<input type='text' value='{$b[3]}<x>{$b[1]}' class='hidden OtherFeeValue'>
		    		<tr class='hidden'>
		    			<td>
		    				<div class='col-md-5'>
			    				{$b[1]}
		    				</div>
		    				<div class='col-md-3 pull-right'>
			    				<button class='btn btn-xs btn-danger pull-right glyphicon glyphicon-remove RemoveOtherFee'></button>
		    				</div>
		    				<div class='col-md-2 pull-right'>
			    				<span class=''>P {$b[3]}</span>
		    				</div>
		    			</td>
		    		</tr>
		    	";
		    }
		}
		else{
		    foreach ($Q1 as $a => $b) {
		    	$Fee .= "
		    		<tr>
		    			<td>
		    				<div class='col-md-5'>
			    				{$b[1]}
		    				</div>
		    				<div class='col-md-3 pull-right'>
			    				<button class='btn btn-xs btn-danger pull-right glyphicon glyphicon-plus AddOtherFee'></button>
		    				</div>
		    				<div class='col-md-2 pull-right'>
			    				<span class=''>P {$b[2]}</span>
		    				</div>
		    			</td>
		    		</tr>
		    	";
		    	$Fee2 .= "
		    		<input type='text' value='{$b[2]}<x>{$b[1]}' class='hidden OtherFeeValue'>
		    		<tr class='hidden'>
		    			<td>
		    				<div class='col-md-5'>
			    				{$b[1]}
		    				</div>
		    				<div class='col-md-3 pull-right'>
			    				<button class='btn btn-xs btn-danger pull-right glyphicon glyphicon-remove RemoveOtherFee'></button>
		    				</div>
		    				<div class='col-md-2 pull-right'>
			    				<span class=''>P {$b[2]}</span>
		    				</div>
		    			</td>
		    		</tr>
		    	";
		    }
		}
		echo "
			<table class='table'>
				<tr>
					<td width='50%'>
						<div class='panel panel-default'>
							<div class='panel-heading'>Fee</div>
							<table class='table' id='TableOtherFeeList'>
							{$Fee}
							</table>
						</div>
					</td>
					<td>
						<div class='panel panel-default'>
							<div class='panel-heading'>Payers Fee</div>
							<table class='table' id='TableOtherFeeListChosen'>
							{$Fee2}
							<tr>
								<td>
				    				<div class='col-md-7'>
				    					<span class='pull-right'>Total: </span>
				    				</div>
				    				<div class='col-md-3 pull-right'>
				    				</div>
				    				<div class='col-md-2 pull-right'>
				    					P <span id='OtherFeeTotal'>0</span>
				    				</div>
								</td>
							</tr>
							<tr>
								<td>
									<input type='button' class='btn btn-sm btn-block btn-success' value='Submit' id='OtherFeeSubmit'>
								</td>
							</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
		";
    }
}

if(isset($_GET['OtherFeePaid'])){
	$Data = $_POST['Data'];

    $Q1 = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE RecieptNumber = '{$Data[1]}'");
    if(count($Q1)==0){
		$Date = $Functions->DateNow();
	    $Query = $Functions2->PDO_Query2("INSERT INTO cashier(StudentIDNumber,DateOfPayment,AmountPaid,RecieptNumber) VALUES('{$Data[0]}','{$Date}','{$Data[2]}','{$Data[1]}')");
		if($Query == 1)
			echo 1;
		else
			echo 0;    	
    }
}

if(isset($_GET['RetrieveAssessment'])){
	$UnitCount = 0; $SubBalance = 0; $Balance = 0;
    $QFee = $Functions2->PDO_SQL("SELECT * FROM fee ORDER BY FeeNumber ASC");
	$Q2 = $Functions2->PDO_SQL("SELECT * FROM assessmentoffee WHERE RegistrationCode = '{$_POST['Data']}'");
	if(count($Q2)>0){
	    $QStudent = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$Q2[0][4]}'");
		$Q1 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Q2[0][4]}'");

		$Subjects = ""; $TotalTuitionFee = 0; $Total = 0; $PaymentView = ""; $PaidAmmount = 0;
		$Q3 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE RegistrationCode = '{$_POST['Data']}'");
		$QAssessmentFee = $Functions2->PDO_SQL("SELECT * FROM assessmentoffee WHERE RegistrationCode = '{$_POST['Data']}'");
		$QCashier = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE RegistrationCode = '{$_POST['Data']}'");

	    if($QStudent[0][11] === "International"){
		    if($QStudent[0][1] === "Doctoral")
		    	$Unit = $QFee[1][3];
		    else
		    	$Unit = $QFee[2][3];
		    $LabFee = $QFee[4][3];
		}
		else{
		    if($QStudent[0][1] === "Doctoral")
		    	$Unit = $QFee[1][2];
		    else
		    	$Unit = $QFee[2][2];
		    $LabFee = $QFee[4][2];
		}

		foreach ($Q3 as $c => $d) {
		    $Q4 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseCode = '{$d[2]}'");
		    $UnitCount = $UnitCount + $Q4[0][3];
			$Subjects .= "
				<tr>
					<td align='center'>{$d[2]}</td>
					<td>{$Q4[0][2]}</td>
					<td align='center'>{$Q4[0][3]}</td>
				</tr>
			";
		}

		foreach ($QCashier as $e => $f) {
			$PaidAmmount = $PaidAmmount + $f[3];
			$PaymentView .= "
				<tr>
					<td align='center'>{$f[2]}</td>
					<td align='center'>{$f[3]}</td>
					<td align='center'>{$f[4]}</td>
				</tr>
			";
		}
		$SubBalance = (($QAssessmentFee[0][3]+$QAssessmentFee[0][2])-$PaidAmmount);
		$Balance = $Balance + $SubBalance;

		$GetPercentageDiscount = 100-(($QAssessmentFee[0][3]*100)/($UnitCount*$Unit));
		$Total = $QAssessmentFee[0][3]+$QAssessmentFee[0][2];

		if($GetPercentageDiscount == 0){
			$TotalTuitionFee = ($UnitCount*$Unit);
			$Note = "";
		}
		else{
			$TotalTuitionFee = ($UnitCount*$Unit)*($GetPercentageDiscount*0.01);
			$Note = "{$GetPercentageDiscount}% discount on scholarship";

		}
		echo "
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <h4 class='panel-title'>
                        <a data-toggle='collapse' data-parent='#accordion' href='#collapseOne'>Show Assessment of fee</a>
                    </h4>
                </div>
                <div id='collapseOne' class='panel-collapse collapse'>
                	<div class='panel-body'>
	                	<div class='col-lg-6'>
	                		Enrolled Subjects
		               		<table class='table table-bordered'>
								<tr>
									<td align='center' width='20%'>Course Code</td>
									<td align='center' width='60%'>Descriptive Title</td>
									<td align='center' width='20%'>Unit</td>
								</tr>
		               			{$Subjects}
								<tr>
									<td align='center' colspan='2'>Total Unit</td>
									<td align='center'>{$UnitCount}</td>
								</tr>
		               		</table>
	                	</div>
	                	<div class='col-lg-6'>
	                		Tuition Fee Computation
	                		<table class='table table-bordered'>
	                			<tr>
	                				<td colspan='2'></td>
	                				<td width='20'>Total</td>
	                			</tr>
	                			<tr>
	                				<td width='20%'>Tuition Fee </td>
	                				<td width='60%'>{$Note}</td>
	                				<td width='20'>{$TotalTuitionFee}</td>
	                			</tr>
	                			<tr>
	                				<td>Miscellaneous Fee</td>
	                				<td></td>
	                				<td>{$QAssessmentFee[0][2]}</td>
	                			</tr>
	                			<tr>
	                				<td colspan='2'><span class='pull-right'>Total</span></td>
	                				<td width='20'>{$Total}</td>
	                			</tr>
	                		</table>
	                	</div>
                	</div>
                </div>
            </div>
		";
	}
}

if(isset($_GET['StudentInfo'])){
	$Default = "<table class='table Box-shadow'>
	                <tr>
	                    <td rowspan='6' width='15%' align='center' class='BorderRight'>
	                    <span id='PictureProfile'><div class='thumbnail'><img src='../StudentsPicture/Default.png' draggable='false'/></div></span></td>
	                    <td width='%'><strong>Name:</strong> <u></u></td>
	                </tr>
					<tr><td><strong>Student Number: </strong></td></tr>
					<tr><td><strong>Address: </strong></td></tr>
					<tr><td><strong>Date of birth: </strong></td></tr>
					<tr><td><strong>Mobile: </strong></td></tr>
					<tr><td><strong>Person notify to incase of emergency: </strong></td></tr>
                </table>";
	$AssessmentCode = $_POST['AssessmentCode'];
	if(!empty($AssessmentCode)){
		if(strlen($AssessmentCode) == 6){
		    $Q1 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE RegistrationCode = '{$AssessmentCode}'");
			if(count($Q1)>=1){
			    $Q2 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Q1[0][1]}'");
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

if(isset($_GET['StudentFee'])){
	$UnitCount = 0; $SubBalance = 0; $Balance = 0;
    $QStudent = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$_POST['Data']}'");
    $QFee = $Functions2->PDO_SQL("SELECT * FROM fee ORDER BY FeeNumber ASC");
	$Q1 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$_POST['Data']}'");
	$Q2 = $Functions2->PDO_SQL("SELECT DISTINCT RegistrationCode FROM assessmentoffee WHERE StudentIDNumber = '{$_POST['Data']}'");
	if(count($Q1) == 1){
		echo "
			<table class='table Box-shadow'>
	            <tr>
	                <td rowspan='6' width='15%' align='center' class='BorderRight'>
	                <span id='PictureProfile'><div class='thumbnail'><img src='../StudentsPicture/{$Q1[0][13]}' draggable='false'/></div></span></td>
	                <td width='%'><strong>Name:</strong> <u>{$Q1[0][4]}, {$Q1[0][2]} {$Q1[0][3]}</u></td>
	            </tr>
	            <tr>
	                <td><strong>Student Number:</strong> <u>{$Q1[0][1]}</u></td>
	            </tr>
	            <tr>
	                <td><strong>Address:</strong> <u>{$Q1[0][6]}</u></td>
	            </tr>
	            <tr>
	                <td><strong>Date of birth:</strong> <u>{$Q1[0][9]}</u></td>
	            </tr>
	            <tr>
	                <td><strong>Mobile:</strong> <u>{$Q1[0][7]}</u></td>
	            </tr>
	            <tr>
	                <td><strong>Person notify to incase of emergency:</strong> <u>{$Q1[0][11]} #{$Q1[0][12]}</u></td>
	            </tr>
	        </table>
	    ";
		foreach ($Q2 as $a => $b) {
			$Subjects = ""; $TotalTuitionFee = 0; $Total = 0; $PaymentView = ""; $PaidAmmount = 0;
			$Q3 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE RegistrationCode = '{$b[0]}'");
			$QAssessmentFee = $Functions2->PDO_SQL("SELECT * FROM assessmentoffee WHERE RegistrationCode = '{$b[0]}'");
			$QCashier = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE RegistrationCode = '{$b[0]}'");

		    if($QStudent[0][11] === "International"){
			    if($QStudent[0][1] === "Doctoral")
			    	$Unit = $QFee[1][3];
			    else
			    	$Unit = $QFee[2][3];
			    $LabFee = $QFee[4][3];
			}
			else{
			    if($QStudent[0][1] === "Doctoral")
			    	$Unit = $QFee[1][2];
			    else
			    	$Unit = $QFee[2][2];
			    $LabFee = $QFee[4][2];
			}

			foreach ($Q3 as $c => $d) {
			    $Q4 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseCode = '{$d[2]}'");
			    $UnitCount = $UnitCount + $Q4[0][3];
				$Subjects .= "
					<tr>
						<td align='center'>{$d[2]}</td>
						<td>{$Q4[0][2]}</td>
						<td align='center'>{$Q4[0][3]}</td>
					</tr>
				";
			}

			foreach ($QCashier as $e => $f) {
				$PaidAmmount = $PaidAmmount + $f[3];
				$PaymentView .= "
					<tr>
						<td align='center'>{$f[2]}</td>
						<td align='center'>{$f[3]}</td>
						<td align='center'>{$f[4]}</td>
					</tr>
				";
			}
			$SubBalance = (($QAssessmentFee[0][3]+$QAssessmentFee[0][2])-$PaidAmmount);
			$Balance = $Balance + $SubBalance;

			$GetPercentageDiscount = 100-(($QAssessmentFee[0][3]*100)/($UnitCount*$Unit));
			$Total = $QAssessmentFee[0][3]+$QAssessmentFee[0][2];

			if($GetPercentageDiscount == 0){
				$TotalTuitionFee = ($UnitCount*$Unit);
				$Note = "";
			}
			else{
				$TotalTuitionFee = ($UnitCount*$Unit)*($GetPercentageDiscount*0.01);
				$Note = "{$GetPercentageDiscount}% discount on scholarship";

			}
			echo "
	            <div class='panel panel-default'>
	                <div class='panel-heading'>
	                    <h4 class='panel-title'>
	                        <a data-toggle='collapse' data-parent='#accordion' href='#collapseOne'>{$b[0]}</a>
	                    </h4>
	                </div>
	                <div id='collapseOne' class='panel-collapse collapse'>
	                	<div class='panel-body'>
		                	<div class='col-lg-6'>
		                		Enrolled Subjects
			               		<table class='table table-bordered'>
									<tr>
										<td align='center' width='20%'>Course Code</td>
										<td align='center' width='60%'>Descriptive Title</td>
										<td align='center' width='20%'>Unit</td>
									</tr>
			               			{$Subjects}
									<tr>
										<td align='center' colspan='2'>Total Unit</td>
										<td align='center'>{$UnitCount}</td>
									</tr>
			               		</table>
		                	</div>
		                	<div class='col-lg-6'>
		                		Tuition Fee Computation
		                		<table class='table table-bordered'>
		                			<tr>
		                				<td colspan='2'></td>
		                				<td width='20'>Total</td>
		                			</tr>
		                			<tr>
		                				<td width='20%'>Tuition Fee </td>
		                				<td width='60%'>{$Note}</td>
		                				<td width='20'>{$TotalTuitionFee}</td>
		                			</tr>
		                			<tr>
		                				<td>Miscellaneous Fee</td>
		                				<td></td>
		                				<td>{$QAssessmentFee[0][2]}</td>
		                			</tr>
		                			<tr>
		                				<td colspan='2'><span class='pull-right'>Total</span></td>
		                				<td width='20'>{$Total}</td>
		                			</tr>
		                		</table>
		                	</div>
		                	<hr/>
		                	<div class='col-lg-6'>
		                		Payment Records
			               		<table class='table table-bordered'>
									<tr>
										<td align='center' width='30%'>Date of payment</td>
										<td align='center' width='30%'>Amount</td>
										<td align='center' width='30%'>Receipt Number</td>
									</tr>
			               			{$PaymentView}
									<tr>
										<td align='right'>Total</td>
										<td align='center'>{$PaidAmmount}</td>
										<td align='center'></td>
									</tr>
			               		</table>
		                	</div>
		                	<div class='col-lg-6'>
		                		<br/>
			               		<table class='table table-bordered'>
									<tr>
										<td><strong>Tuition Fee: </strong><u>{$QAssessmentFee[0][3]}</u></td>
									</tr>
									<tr>
										<td><strong>Miscellaneous Fee: </strong><u>{$QAssessmentFee[0][2]}</u></td>
									</tr>
									<tr>
										<td><strong>Total: </strong><u>".($QAssessmentFee[0][3]+$QAssessmentFee[0][2])."</u></td>
									</tr>
									<tr>
										<td><strong>Balance: </strong><u>{$SubBalance}</u></td>
									</tr>
			               		</table>
		                	</div>
	                	</div>
	                </div>
                </div>
			";
		}
		echo "
    		<div class='alert alert-danger'>
        		<strong>Unpaid Fee: {$Balance}</strong>
    		</div>
        ";
	}
}

if(isset($_GET['Print'])){
	$Units = 0;
	$AssessmentCode = $_POST['AssessmentCode'];
	$Data = $Functions->SelectOne("enrolledsubject","RegistrationCode","$AssessmentCode");
	$StudentIDNumber = $Data[1]; $TNO = $Data[2];
	if(!empty($AssessmentCode)){
		if(strlen($AssessmentCode) == 6){
			$Data = $Functions->SelectOne("enrolledsubject","RegistrationCode","$AssessmentCode");
			$StudentIDNumber = $Data[1];
			$QueryStudent = mysql_query("SELECT * FROM students WHERE StudentIDNumber = '$StudentIDNumber'");
			$Row = mysql_fetch_assoc($QueryStudent);
			$Num = mysql_num_rows($QueryStudent);
			if($Num == 1){
				$StudentID = $Row['StudentID'];
				$StudentInfo = $Functions->StudentInfo($StudentID);
				echo '
						<table border="1" width="90%" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td rowspan="6" width="20%" align="center" class="BorderRight"><span><img src="../StudentsPicture/'.$StudentInfo[9].'" draggable="false"/></span></td>
                                <td width="20%">Name: </td>
                                <td>'.$StudentInfo[3].', '.$StudentInfo[1].' '.$StudentInfo[2].'</td>
                            </tr>
                            <tr>
                                <td>Student Number:</td>
                                <td>'.$StudentInfo[0].'</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>'.$StudentInfo[4].'</td>
                            </tr>
                            <tr>
                                <td>Date of birth: </td>
                                <td>'.$StudentInfo[6].'</td>
                            </tr>
                            <tr>
                                <td>Mobile: </td>
                                <td>'.$StudentInfo[5].'</td>
                            </tr>
                            <tr>
                                <td colspan="2">Person notify to incase of emergency: '.$StudentInfo[7].' #'.$StudentInfo[8].'</td>
                            </tr>
                         </table>';
			}

			echo '<br/><div class="TitleHr" align="center"><span>Assessment of fee</span></div>';
			echo '<table border="1" width="90%" align="center" cellspacing="0"><tr><td colspan="7">Tuition fee</td></tr>';
			echo '<tr><td align="center" width="20%">Course Code</td><td align="center">Descriptive Title</td><td align="center" width="5%">Units</td><td colspan="4"></td></tr>';
			$Query = mysql_query("SELECT * FROM enrolledsubject WHERE RegistrationCode = '$AssessmentCode'");
			$NumRow = mysql_num_rows($Query);
			$Data = $Functions->SelectOne("fee","FeeNumber",4);
			$LabFee = $Data[2];
			while($Row = mysql_fetch_assoc($Query)){
				$Data = $Functions->SelectOne("courses","CourseCode",$Row['CourseCode']);
				echo '<tr>
							<td align="center">'.$Row['CourseCode'].'</td>
							<td>'.$Data[2].'</td>
							<td align="center">'.$Data[3].'</td>
							<td align="center" colspan="4"></td>
						</tr>';
			}
			echo '<tr><td colspan="2" align="right">Total</td><td align="center" colspan="3" width="20%">'.($Data[3]*$NumRow).' x '.$LabFee.' = '.($Data[3]*$NumRow)*$LabFee.'</td></tr>';
			echo '</table><br/><br/>';
			$Data1 = $Functions->SelectOne("fee","FeeNumber",1); $LabFee2 = $Data1[2];
			$Data2 = $Functions->SelectOne("fee","FeeNumber",2); $Lib = $Data2[2];
			$Data3 = $Functions->SelectOne("fee","FeeNumber",3); $Reg = $Data3[2];
			$TotalLab = 0;
			echo '<table border="0" width="90%" align="center" cellspacing="0">';
			echo '<tr><td colspan="3">Miscellaneous Fee</td></tr>';
			echo '<tr><td width="20%" align="center">Miscellaneous</td><td width="50%"></td><td width="5%" align="center">Amount</td></tr>';
			$Query = mysql_query("SELECT * FROM enrolledsubject WHERE RegistrationCode = '$AssessmentCode'");
			while($Row = mysql_fetch_assoc($Query)){
				$CourseCode = $Row['CourseCode'];
				$Data4 = $Functions->SelectOne("courses","CourseCode",$CourseCode); $Lab = $Data4[4];
				if($Lab == 1){
					echo '<tr><td align="center">Computer Laboratory for '.$CourseCode.'</td><td></td><td align="center">'.$LabFee2.'</td></tr>';
					$TotalLab = $TotalLab + $LabFee2;
				}
			}
			echo '<tr><td align="center">Library</td><td></td><td align="center">'.$Lib.'</td></tr>';
			echo '<tr><td align="center">Registration</td><td></td><td align="center">'.$Reg.'</td></tr>';
			echo '<tr><td></td><td align="right">Total</td><td align="center">'.($Lib+$Reg+$TotalLab).'</td></tr>';
			echo '</table><br/><br/>'; $TuitionFee = ($Data[3]*$NumRow)*$LabFee; $MiscFee = ($Lib+$Reg+$TotalLab);
			
			$Scholarship = $Functions->SelectOne("studentscourse","StudentIDNumber",$StudentIDNumber);
			if(!empty($Scholarship[4])){
				$TuitionFee = $TuitionFee/2;
			}
			
			echo '<table border="1" width="90%" align="center" cellspacing="0">
					<tr><td>Tuition Fee</td><td align="right">'.$Scholarship[4].' 50% discount</td><td width="10%" align="center">'.($TuitionFee).'</td></tr>
					<tr><td>Miscellaneous Fee</td><td></td><td align="center">'.$MiscFee.'</td></tr>
					<tr><td></td><td align="right">Total Fee</td><td align="center">'.($TuitionFee+$MiscFee).'</td></tr>
				  </table><br/><br/>';
				}
	}
}

if(isset($_GET['BalanceCheck'])){
	$AssessmentCode = $_POST['AssessmentCode']; $Amount = 0;
	$Data = $Functions->SelectOne("assessmentoffee","RegistrationCode",$AssessmentCode);
	$Total = ($Data[2]+$Data[3]);
	$Query = mysql_query("SELECT * FROM cashier WHERE RegistrationCode = '$AssessmentCode'");
	while($Row = mysql_fetch_assoc($Query)){
		$Amount = $Amount+$Row['AmountPaid'];
	}
	if($Total == $Amount){
		echo 'Fully Paid';
		mysql_query("UPDATE assessmentoffee SET Status = 'Fully Paid' WHERE StudentIDNumber = '$Data[4]'");
	}
	else{
		echo $Amount.'='.$Total;
	}
}

if(isset($_GET['CashierFees'])){
	$AssessmentCode = $_POST['AssessmentCode']; $Amount = 0;$Amount3 = 0; $Total3 = 0;
	$Data = $Functions->SelectOne("assessmentoffee","RegistrationCode",$AssessmentCode);
	$Total = ($Data[2]+$Data[3]);
	$Query = mysql_query("SELECT * FROM cashier WHERE RegistrationCode = '$AssessmentCode'");
	while($Row = mysql_fetch_assoc($Query)){
		$Amount = @$Amount+$Row['AmountPaid'];
		$SIDN = @$Row['StudentIDNumber'];
	}
	//$Query2 = @mysql_query("SELECT * FROM cashier WHERE StudentIDNumber = '$SIDN'");
	$Query2 = mysql_query("SELECT * FROM assessmentoffee WHERE StudentIDNumber = '$Data[4]'") or die(mysql_error());
	while($Row2 = mysql_fetch_assoc($Query2)){
		$Code = $Row2['RegistrationCode'];
		if($Code != $AssessmentCode){
			$Data3 = $Functions->SelectOne("assessmentoffee","RegistrationCode",$Code);
			$Total3 = ($Data3[2]+$Data3[3]);
			$Query3 = mysql_query("SELECT * FROM cashier WHERE RegistrationCode = '$Code'") or die(mysql_error());
			while($Row3 = mysql_fetch_assoc($Query3)){
				$Amount3 = @$Amount3+$Row3['AmountPaid'];
			}
		}
	}
	echo '
		<table class="table Box-shadow">	
			<tr>
				<td colspan="4" width="15%">Balance: '.(($Total-$Amount)+($Total3-$Amount3)).'</td>
				<td colspan="4" width="20%">Previous Balance: '.($Total3-$Amount3).'</td>
				<td width="20%">Miscellaneous Fee: '.$Data[2].'</td>
				<td width="15%">Tuition Fee: '.$Data[3].'</td>
				<td width="15%">Total Fee: '.$Total.'</td>
			</tr>
		</table>
	';
}

if(isset($_GET['Cashier'])){
	$AssessmentCode = $_POST['AssessmentCode'];
	$Receipt = $_POST['Receipt'];
	$Amount = $_POST['Amount'];
	
	$Data = $Functions->SelectOne("assessmentoffee","RegistrationCode",$AssessmentCode);
	$StudentIDNumber = $Data[4];
	$Date = $Functions->DateNow();
	$Query = mysql_query("INSERT INTO cashier(StudentIDNumber,DateOfPayment,AmountPaid,RecieptNumber,RegistrationCode) VALUES('$StudentIDNumber','$Date','$Amount','$Receipt','$AssessmentCode')");
}

if(isset($_GET['CashierPaid'])){
	$AssessmentCode = $_POST['AssessmentCode']; $Amount = 0;
	$Query = mysql_query("SELECT * FROM cashier WHERE RegistrationCode = '$AssessmentCode'");
	echo '
		<table border="0" width="100%" align="center" cellspacing="0" >
		<tr>
			<td align="center" width="10%">Date</td><td align="center" width="20%"></td><td align="center" width="10%">Amount Paid</td><td align="center" width="10%">Receipt Number</td>
		</tr>
	';
	while($Row = mysql_fetch_assoc($Query)){
		$Amount = $Amount + $Row['AmountPaid'];
		echo '
			<tr>
				<td align="center" width="10%">'.$Row['DateOfPayment'].'</td><td align="center" width="20%"></td><td align="center" width="10%">'.$Row['AmountPaid'].'</td><td align="center" width="10%">'.$Row['RecieptNumber'].'</td>
			</tr>
		';
	}
	echo '<tr><td colspan="2" align="right">Total</td><td align="center">'.$Amount.'</td><td></td></tr>';
	echo '</table>';
}

if(isset($_GET['Time'])){
	$Query = mysql_query("SELECT NOW( ) AS Clock");
	$Row = mysql_fetch_assoc($Query);
	print_r($Row['Clock']);
}

?>