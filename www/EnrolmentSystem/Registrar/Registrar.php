<?php
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
include("../PhpFiles2/Functions.php"); 
$Functions2 = new DatabaseClasses;
$Functions = new FunctionsExt;
session_start();

if(isset($_GET['ChartYear'])){
	$Data = $_POST['Data'];
	$SemNow = $Functions2->YearSemNow(); $Course = []; $Course2 = []; $Students = []; $Count = 0;                                
	$SemNow = "{$SemNow[0]}/{$Data}";
    $Q1 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse, studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' ORDER BY studentscourse.StudentCourse"); 
    foreach ($Q1 as $Loop1 => $Value1){
    	$Course[] = $Value1[2];
    }
    $CourseDistinct = array_unique($Course);
    foreach ($CourseDistinct as $Loop2 => $Value2) {
    	$Count++;
	    $Q2 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse,studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' AND studentscourse.StudentProgram = '{$Value2}'"); 
    	$Course2[] = array("tag"=>"{$Count}","name"=>"{$Value2}","y"=>count($Q2));
    }
    $JSON = json_encode($Course2);
    echo "{$SemNow}<x>{$JSON}";
}

if(isset($_GET['ChartSemester'])){
	$SemNow = $Functions2->YearSemNow(); $Course = []; $Course2 = []; $Students = []; $Count = 0;                                
	$SemNow = "{$SemNow[0]}/{$SemNow[1]}";

    $Q1 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse, studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' ORDER BY studentscourse.StudentCourse"); 
    foreach ($Q1 as $Loop1 => $Value1){
    	$Course[] = $Value1[2];
    }
    $CourseDistinct = array_unique($Course);
    foreach ($CourseDistinct as $Loop2 => $Value2) {
    	$Count++;
	    $Q2 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse,studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' AND studentscourse.StudentProgram = '{$Value2}'"); 
    	$Course2[] = array("tag"=>"{$Count}","name"=>"{$Value2}","y"=>count($Q2));
    }
    $JSON = json_encode($Course2);
    echo "{$SemNow}<x>{$JSON}";
}

if(isset($_GET['ChartCourse'])){
	$Data = $_POST['Data']; $SemNow = $Functions2->YearSemNow(); $Course = []; $Course2 = []; $Students = []; $Count = 0;                                
	$SemNow = "{$SemNow[0]}/{$SemNow[1]}";

    $Q1 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse, studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' AND studentscourse.StudentProgram = '{$Data}' ORDER BY studentscourse.StudentCourse"); 
    foreach ($Q1 as $Loop1 => $Value1){
    	$Course[] = $Value1[1];
    }

    $QCourses = $Functions2->PDO_SQL("SELECT DISTINCT CourseTitle,Program FROM courses WHERE Program = '{$Data}'");
    foreach ($QCourses as $Loop3 => $Value3) {
    	if(!in_array($Value3[0],$Course))
	    	$Course[] = $Value3[0];
    }

    $CourseDistinct = array_unique($Course);
    foreach ($CourseDistinct as $Loop2 => $Value2) {
    	$Count++; $TotalStudent = 0;
	    $Q2 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' AND studentscourse.StudentCourse = '{$Value2}'"); 
    	if(count($Q2)==0)
    		$TotalStudent = 0.0001;
	    else
	    	$TotalStudent = count($Q2);

	    	$Course2[] = array("tag"=>$Count,"visible"=>true,"name"=>"{$Value2}","y"=>$TotalStudent);
    }

	echo json_encode($Course2);
}

if(isset($_GET['ListSemester'])){
	$SemNow = $Functions2->YearSemNow(); $Course = []; $Course2 = []; $Students = []; $Count = 0;                                
	$SemNow = "{$SemNow[0]}/{$SemNow[1]}";

    $Q1 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse, studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' ORDER BY studentscourse.StudentCourse"); 
    foreach ($Q1 as $Loop1 => $Value1){
    	$Course[] = $Value1[2];
    }
    $CourseDistinct = array_unique($Course);
    foreach ($CourseDistinct as $Loop2 => $Value2) {
    	$Count++; $Students=[];
	    $Q2 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse,studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' AND studentscourse.StudentProgram = '{$Value2}'"); 
    	$TotalStudent = count($Q2);
    	if($TotalStudent>0){
    		foreach ($Q2 as $Loop4 => $Value4) {
    			$Students[] = $Value4[0];

    		}
    	}
    	$Course2[] = array("Course"=>"{$Value2}","Total"=>$TotalStudent,"Students"=>$Students);
    }
    if(count($Course2)>0){
	    echo "
	    	<table class='table table-striped table-bordered' id='accordion'>
	    ";
	    $Total = 0;
	    foreach ($Course2 as $Loop5 => $Value5) {
	    	$Total = $Total + $Value5['Total'];

	    	$StudentDiv = "";
	    	if(count($Value5['Students'])>0){
				$StudentDiv .= "
					<table class='table table-bordered'>
				";
	    		foreach ($Value5['Students'] as $Loop6 => $Value6) {
				    $Q6 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Value6}'"); 
	    			$StudentDiv .= "
	    				<tr>
	    					<td>
	    						<div class='col-md-2 thumbnail'>
	    							<img src='../StudentsPicture/{$Q6[0][13]}' draggable='false'>
	    						</div>
	    						<div class='col-md-10'>
	    							<small>
			    						{$Q6[0][4]} {$Q6[0][2]}, {$Q6[0][3]}<br/>
			    						{$Q6[0][1]}
		    						</small>
	    						</div>
	    					</td>
	    					<td><a class='btn btn-sm btn-success pull-right' href='#ViewProfile#{$Q6[0][1]}'>Details</a></td>
	    				</tr>
	    			";
	    		}
				$StudentDiv .= "
					</table>
				";
	    	}
	    	else{
	    		$StudentDiv .= "<small>No Student enrolled in this course.</small>";
	    	}

	    	echo "
	    		<tr>
	    			<td>
	    				<div class='col-md-11'>
			            	<a data-toggle='collapse' data-parent='#accordion' href='#ListCourse{$Loop5}' class='collapsed'>
		    					<small>{$Value5['Course']}</small>
			        		</a>
	    				</div>
	    				<div class='col-md-1'>
	    					<span class=''>{$Value5['Total']}</span>
	    				</div>
		                <div id='ListCourse{$Loop5}' class='col-md-12 panel-collapse collapse'>
							{$StudentDiv}
		                </div>
	    			</td>
	    		</tr>
	    	";
	    }

	    echo "
	    	<tr>
	    		<td>
	    				<div class='col-md-11'>
		    					<small class='pull-right'>Total</small>
	    				</div>
	    				<div class='col-md-1'>
	    					<small class='pull-left'>$Total</small>
	    				</div>
	    		</td>
	    	</tr>
	    	</table>
	    ";
    }
    else{
    	echo "
    	<div class='panel-default panel'>
    		<div class='panel-body'>
    			No Students retrieved for this course.
    		</div>
		</div>
    	";
    }
}

if(isset($_GET['ListYear'])){
	$Data = $_POST['Data'];
	$SemNow = $Functions2->YearSemNow(); $Course = []; $Course2 = []; $Students = []; $Count = 0;                                
	$SemNow = "{$SemNow[0]}/{$Data}";
    $Q1 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse, studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' ORDER BY studentscourse.StudentCourse"); 
    foreach ($Q1 as $Loop1 => $Value1){
    	$Course[] = $Value1[2];
    }
    $CourseDistinct = array_unique($Course);
    foreach ($CourseDistinct as $Loop2 => $Value2) {
    	$Count++;$Students=[];
	    $Q2 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse,studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' AND studentscourse.StudentProgram = '{$Value2}'"); 
    	$TotalStudent = count($Q2);
    	if($TotalStudent>0){
    		foreach ($Q2 as $Loop4 => $Value4) {
    			$Students[] = $Value4[0];
    		}
    	}
    	$Course2[] = array("Course"=>"{$Value2}","Total"=>$TotalStudent,"Students"=>$Students);
    }

    if(count($Course2)>0){
	    echo "
	    	<table class='table table-striped table-bordered' id='accordion'>
	    ";
	    $Total = 0;
	    foreach ($Course2 as $Loop5 => $Value5) {
	    	$Total = $Total + $Value5['Total'];

	    	$StudentDiv = "";
	    	if(count($Value5['Students'])>0){
				$StudentDiv .= "
					<table class='table table-bordered'>
				";
	    		foreach ($Value5['Students'] as $Loop6 => $Value6) {
				    $Q6 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Value6}'"); 
	    			$StudentDiv .= "
	    				<tr>
	    					<td>
	    						<div class='col-md-2 thumbnail'>
	    							<img src='../StudentsPicture/{$Q6[0][13]}' draggable='false'>
	    						</div>
	    						<div class='col-md-10'>
		    						{$Q6[0][4]} {$Q6[0][2]}, {$Q6[0][3]}<br/>
		    						{$Q6[0][1]}
	    						</div>
	    					</td>
	    					<td><a class='btn btn-sm btn-success pull-right' href='#ViewProfile#{$Q6[0][1]}'>Details</a></td>
	    				</tr>
	    			";
	    		}
				$StudentDiv .= "
					</table>
				";
	    	}
	    	else{
	    		$StudentDiv .= "No Student enrolled in this course.";
	    	}

	    	if($Data == "1st Sem")
	    		$Identifier = "x";
	    	else
	    		$Identifier = "y";
	    	echo "
	    		<tr>
	    			<td>
	    				<div class='col-md-11'>
			            	<a data-toggle='collapse' data-parent='#accordion' href='#ListCourse{$Identifier}{$Loop5}' class='collapsed'>
		    					<small>{$Value5['Course']}</small>
			        		</a>
	    				</div>
	    				<div class='col-md-1'>
	    					<span class=''>{$Value5['Total']}</span>
	    				</div>
		                <div id='ListCourse{$Identifier}{$Loop5}' class='col-md-12 panel-collapse collapse'>
							{$StudentDiv}
		                </div>
	    			</td>
	    		</tr>
	    	";
	    }

	    echo "
	    	<tr>
	    		<td>
	    				<div class='col-md-11'>
		    					<small class='pull-right'>Total</small>
	    				</div>
	    				<div class='col-md-1'>
	    					<small class='pull-left'>$Total</small>
	    				</div>
	    		</td>
	    	</tr>
	    	</table>
	    ";
    }
    else{
    	echo "
    	<div class='panel-default panel'>
    		<div class='panel-body'>
    			No Students retrieved for this course.
    		</div>
		</div>
    	";
    }
}

if(isset($_GET['ListCourse'])){
	$Data = $_POST['Data']; $SemNow = $Functions2->YearSemNow(); $Course = []; $Course2 = []; $Students = []; $Count = 0;                                
	$SemNow = "{$SemNow[0]}/{$SemNow[1]}";

    $Q1 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse, studentscourse.StudentProgram FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' AND studentscourse.StudentProgram = '{$Data}' ORDER BY studentscourse.StudentCourse"); 
    foreach ($Q1 as $Loop1 => $Value1){
    	$Course[] = $Value1[1];
    }

    $QCourses = $Functions2->PDO_SQL("SELECT DISTINCT CourseTitle,Program FROM courses WHERE Program = '{$Data}'");
    foreach ($QCourses as $Loop3 => $Value3) {
    	if(!in_array($Value3[0],$Course))
	    	$Course[] = $Value3[0];
    }

    $CourseDistinct = array_unique($Course);
    foreach ($CourseDistinct as $Loop2 => $Value2) {
    	$Count++; $TotalStudent = 0; $Students = [];
	    $Q2 = $Functions2->PDO_SQL("SELECT DISTINCT enrolledsubject.StudentIDNumber,studentscourse.StudentCourse FROM enrolledsubject INNER JOIN studentscourse ON enrolledsubject.StudentIDNumber = studentscourse.StudentIDNumber WHERE enrolledsubject.YearSem = '{$SemNow}' AND studentscourse.StudentCourse = '{$Value2}'"); 
    	$TotalStudent = count($Q2);
    	if($TotalStudent>0){
    		foreach ($Q2 as $Loop4 => $Value4) {
    			$Students[] = $Value4[0];
    		}
    	}

    	$Course2[] = array("Course"=>"{$Value2}","Total"=>$TotalStudent,"Students"=>$Students);
    }

    echo "
    	<table class='table table-striped table-bordered' id='accordion'>
    ";
    $Total = 0;
    foreach ($Course2 as $Loop5 => $Value5) {
    	$Total = $Total + $Value5['Total'];

    	$StudentDiv = "";
    	if(count($Value5['Students'])>0){
			$StudentDiv .= "
				<table class='table table-bordered'>
			";
    		foreach ($Value5['Students'] as $Loop6 => $Value6) {
			    $Q6 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Value6}'"); 
    			$StudentDiv .= "
    				<tr>
    					<td>
    						<div class='col-md-2 thumbnail'>
    							<img src='../StudentsPicture/{$Q6[0][13]}' draggable='false'>
    						</div>
    						<div class='col-md-10'>
	    						{$Q6[0][4]} {$Q6[0][2]}, {$Q6[0][3]}<br/>
	    						{$Q6[0][1]}
    						</div>
    					</td>
    					<td><a class='btn btn-sm btn-success pull-right' href='#ViewProfile#{$Q6[0][1]}'>Details</a></td>
    				</tr>
    			";
    		}
			$StudentDiv .= "
				</table>
			";
    	}
    	else{
    		$StudentDiv .= "No Student enrolled in this course.";
    	}

    	echo "
    		<tr>
    			<td>
    				<div class='col-md-11'>
		            	<a data-toggle='collapse' data-parent='#accordion' href='#ListCourse{$Data}{$Loop5}' class='collapsed'>
	    					<small>{$Value5['Course']}</small>
		        		</a>
    				</div>
    				<div class='col-md-1'>
    					<span class=''>{$Value5['Total']}</span>
    				</div>
	                <div id='ListCourse{$Data}{$Loop5}' class='col-md-12 panel-collapse collapse'>
						{$StudentDiv}
	                </div>
    			</td>
    		</tr>
    	";
    }
    echo "
    	<tr>
    		<td>
    				<div class='col-md-11'>
	    					<small class='pull-right'>Total</small>
    				</div>
    				<div class='col-md-1'>
    					<small class='pull-left'>$Total</small>
    				</div>
    		</td>
    	</tr>
    	</table>
    ";
}


if(isset($_GET['Time'])){
	$Query = mysql_query("SELECT NOW( ) AS Clock");
	$Row = mysql_fetch_assoc($Query);
	print_r($Row['Clock']);
}

if(isset($_GET['Validation'])){
	if($_GET['Validation'] == 'OR'){
		$OR = $_POST['OR'];
		if(preg_match("#^[0-9]{6}$#",$OR))
			echo 0;
		else
			echo 1;
	}
}

if(isset($_GET['GenerateRandomStudentID'])){
	$Data = $_POST['Data'];
    $StudentIDNumber = $Functions2->OUSStudentIDNumberGenerator();                                
	echo "
	    <span id='ErrorStudentIDInput'></span>
	    <input type='text' class='form-control disabled hidden' id='IDNumber' placeholder='Student ID' data-mask='99-OUS-9999' value='DefaultID'/>
	    <label><input type='checkbox' id='IDNumberSettings'><small><i>Enter Student ID manually</i></small></label>
	";
}

if(isset($_GET['GetGenerateRandomStudentID'])){
    $StudentIDNumber = $Functions2->OUSStudentIDNumberGenerator();
}


if(isset($_GET['ProgramX'])){
	$URL = $_GET['ProgramX'];
	$Data = explode('?',$URL);
	echo strtoupper($Data[1]);
}

if(isset($_GET['Doctoral'])){
	$Data = $Functions->Students("DOCTORAL");
	for($x=0;$x<count($Data);$x++){
		$Query = mysql_query("SELECT * FROM students WHERE StudentID = '$Data[$x]'");
		while($Row = mysql_fetch_assoc($Query)){
			echo '<a href="?k='.$Data[$x].'">
				<ul>
					<img src="../StudentsPicture/'.$Row['StudentPicture'].'" draggable="false"/>
					<li><div class="SN">'.$Row['StudentSurname'].', '.$Row['StudentFirstName'].' '.$Row['StudentMiddleName'].'<br/>'.$Row['StudentIDNumber'].'</div></li>
				</ul></a>
			';
		}
	}
}

if(isset($_GET['Masteral'])){
	$IDNum = $Functions->StudentIDNumberGenerator();
	$Data = $Functions->Students("MASTERAL");
	for($x=0;$x<count($Data);$x++){
		$Query = mysql_query("SELECT * FROM students WHERE StudentID = '$Data[$x]'");
		while($Row = mysql_fetch_assoc($Query)){
			echo '<a href="?k='.$Data[$x].'">
				<ul id="SInfo">
					<img src="../StudentsPicture/'.$Row['StudentPicture'].'" draggable="false"/>
					<li><div class="SN">'.$Row['StudentSurname'].', '.$Row['StudentFirstName'].' '.$Row['StudentMiddleName'].'<br/>'.$Row['StudentIDNumber'].'</div></li>
				</ul></a>
			';
		}
	}
}

if(isset($_GET['SessionAdd'])){
	$_SESSION['AddStudent'] = "ON";
	$_SESSION['StudentProgram'] = $_POST['Program'];
}

if(isset($_GET['Course'])){
	$Program = $_POST['CourseProgram'];
	$Course = $_POST['Course'];
	$CourseCode = $_POST['CourseCode'];
	$DescriptiveTitle = $_POST['DescriptiveTitle'];
	$CourseUnits = $_POST['CourseUnits'];
	$Lab = $_POST['Lab'];
	$Query = mysql_query("INSERT INTO courses(CourseCode,DescriptiveTitle,Units,CourseTitle,Program,Lab) VALUES('$CourseCode','$DescriptiveTitle','$CourseUnits','$Course','$Program','$Lab')");
}

if(isset($_GET['CourseList'])){
	$CourseTitle = @$_POST['CourseTitle'];
	echo '<br/><table width="98%" class="panel-group" id="accordion" id="Course" border="0">';
	$Query = mysql_query("SELECT DISTINCT CourseTitle FROM courses ORDER BY CourseTitle DESC");
	for($x=0;$Row = mysql_fetch_assoc($Query);$x++){
		$Query2 = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$CourseTitle'");
		$CourseTitle = $Row['CourseTitle'];
		echo '
			<tr>
				<td width="150px" align="center">
					<div class="panel panel-default">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$x.'">
							<div class="panel-default panel-heading" align="left">
								<h4 class="panel-title">
									<span class="label label-default pull-right">'.mysql_num_rows($Query2).'</span>
									'.$Row['CourseTitle'].'
								</h4>
							</div>
						</a>
						<div id="collapse'.$x.'" class="panel-collapse collapse">
							<table class="table table-striped">
	                            <tr>
	                                <th width="100px">Course Code</th>
	                                <th width="500px">Descriptive Title</th>
	                                <th width="100px">Units</th>
	                            </tr>
	                            ';
								while($Row2 = mysql_fetch_assoc($Query2)){
									echo '
										<tr>
											<td>'.$Row2['CourseCode'].'</td>
											<td>'.$Row2['DescriptiveTitle'].'</td>
											<td>'.$Row2['Units'].'</td>
										</tr>';
								}
							echo '
							</table>
						</div>
					</div>
					<br/>
				</td>
			</tr>';
	}
	echo '</table>';
}

if(isset($_GET['CourseSession'])){
	$_SESSION['Session'] = $_POST['Session'];
	echo $_SESSION['Session'];
}

if(isset($_GET['CourseCloseSession'])){
	$_SESSION['Session'] = "";
	echo $_SESSION['Session'];
}

if(isset($_GET['RetrieveSubjectStudentData'])){
	$StudentIDNumber = $_POST['StudentIDNumber'];
	echo '<ul><div align="center" class="div1">Course Code</div> <div align="center" class="div2">Descriptive Title</div><div class="div4" align="center">Rating</div><div align="center" class="div3">Units</div></ul>';
	$Query = mysql_query("SELECT * FROM enrolledsubject INNER JOIN students ON enrolledsubject.StudentIDNumber = students.StudentIDNumber AND enrolledsubject.StudentIDNumber = '$StudentIDNumber'");
	while($Row = mysql_fetch_assoc($Query)){
		$CourseCodeQuery = $Row['CourseCode'];
		$Row2 = mysql_fetch_assoc(mysql_query("SELECT * FROM courses WHERE CourseCode = '$CourseCodeQuery'"));
		$ID = $Row['StudentID'];
		$Row4 = mysql_fetch_assoc(mysql_query("SELECT * FROM studentsgrades WHERE StudentID = '$ID' AND Subject = '$CourseCodeQuery'"));
		echo '<ul><div align="center" class="div1">'.$Row['CourseCode'].'</div> <div class="div2">'.$Row2['DescriptiveTitle'].'</div><div class="div4" align="center">'.$Row4['SubjectRating'].'</div><div align="center" class="div3">'.$Row2['Units'].'</div></ul>';
	}
	
}
if(isset($_GET['GetStudentInformation'])){
	$StudentIDNumber = $_POST['StudentIDNumber'];
	$Data = explode(' ',$StudentIDNumber);
	$Units = 0;
	$StudentIDNumber = trim($Data[count($Data)-1]);
	$Data = $Functions->SelectOne("students","StudentIDNumber","$StudentIDNumber");
	if(!empty($Data[1])){
		echo '
			<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  class="Box-shadow">
				<tr><td rowspan="6" width="20%" align="center" class="BorderRight"><span><img src="../StudentsPicture/Default.png" draggable="false"/></span></td><td width="20%">Name: </td><td>'.$Data[4].', '.$Data[2].' '.$Data[3].'</td></tr>
				<tr><td>Student Number:</td><td>'.$Data[1].'</td></tr>
				<tr><td>Address:</td><td>'.$Data[6].'</td></tr>
				<tr><td>Date of birth: </td><td>'.$Data[9].'</td></tr>
				<tr><td>Mobile: </td><td>'.$Data[7].'</td></tr>
				<tr><td colspan="2">Person notify to incase of emergency: '.$Data[11].' #'.$Data[12].'</td></tr>
			</table><br/><br/>
		';
	}
	else{
		echo 0;
	}
	$CourseQuery = mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$StudentIDNumber'");
	$CourseRow = mysql_fetch_assoc($CourseQuery);
	$CourseTitle = $CourseRow['StudentCourse'];
	$Query = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$CourseTitle'");
	echo '<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="Box-shadow"><tr><td width="10%" align="center">Course Code</td><td align="center" width="50%">Descriptive Title</td><td width="5%" align="center">Units</td><td width="5%" align="center">Rating</td><td align="center" width="14%">Semester and Year</td><td align="center">Professor</td></tr>';
	while($Row = mysql_fetch_assoc($Query)){
		$CourseCode = $Row['CourseCode'];
		$EnrolledQuery = mysql_query("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$StudentIDNumber' AND CourseCode = '$CourseCode'");
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
							<input type="button" id="PrintUnits" value="Print Earned Units">
							<input type="button" id="PrintGoodMoral" value="Print Good Moral">
							<input type="button" id="PrintGrades" value="Print Grades">
							<input type="button" id="PrintOTR" value="Print OTR">
						</td>
					</tr>
			';
	echo '</table>';
}

if(isset($_GET['FacultyLoading'])){
	$CourseTitle = $_POST['CourseTitle'];
	$Subject = $_POST['Subject'];
	$TNO = $_POST['TNO'];
	$Query = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$CourseTitle' AND CourseCode = '$Subject'");
	$Row = mysql_fetch_assoc($Query);
	$SubjectNumber = $Row['CourseNumber'];

	$Query = mysql_query("UPDATE faculty SET SubjectNumber = '$SubjectNumber' WHERE TNO = '$TNO'");
	
	$Data = $Functions->SelectOne("courses","CourseNumber","$SubjectNumber");
	echo $Data[1].':'.$Data[2];
}

if(isset($_GET['ConfirmToRegistrar'])){
	$Data = $_POST['Data']; 
	$Password = sha1($Data);
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM users WHERE UserName = 'registrar' AND UserPassword = '{$Password}'");
    echo count($Q1);
}

if(isset($_GET['FacultyReport'])){
    $QSettings = $Functions2->PDO_SQL("SELECT * FROM settings WHERE SettingsLabel = 'CutOffDate'");
    $QCurrentDate = $Functions2->PDO_SQL("SELECT NOW()");
    $Date1 = date("F j, Y",strtotime($QCurrentDate[0][0])); 
    $Date2 = date("F j, Y",strtotime($QSettings[0][2]));

	$Data = $_POST['Data'];
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject INNER JOIN students ON students.StudentIDNumber = enrolledsubject.StudentIDNumber WHERE YearSem = '{$Data[0]}' AND Professor = '{$Data[1]}'");
	echo "
	<table class='table table-striped table-bordered'>
		<tr>
			<th colspan='2'>Name</th>
			<th align='center'>Subject</th>
			<th align='center'>Rating</th>
		</tr>
	";
    foreach ($Q1 as $a => $b) {
    	$Q2 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseCode = '{$b[2]}'");
//    	$Q2 = $Functions2->PDO_SQL("SELECT * FROM studentscourse INNER JOIN courses ON studentscourse.StudentCourse = courses.CourseTitle WHERE courses.CourseCode = '{$b[2]}' AND studentscourse.StudentIDNumber = '{$b[1]}'");
        if($Date2 > $Date1)
        	$Rating = $b[4];
        else{
        	if(empty($b[4]))
				$Rating = "-";
    		else
        		$Rating = $b[4];
        }

	echo "
		<tr>
			<td width='40px'>
				<span id='StudentsList'>
					<img src='../StudentsPicture/{$b[22]}' draggable='false'/>
				</span>
			</td>
			<td>
				<div class='SN'>{$b[13]}, {$b[11]} {$b[12]}<br/><span id='StudentIDNumberRating'>{$b[10]}</span></div>
			</td>
			<td>{$Q2[0][1]}</td>
			<td>$Rating</td>
		</tr>
	";
	}
	echo "

	</table>
	<input type='hidden' id='TotalStudents' value='".($a+13)."'>
	</div>
	";
}

if(isset($_GET['SubjectListFaculty'])){

	$Course = @$_POST['CourseTitle'];
	@$StudentIDNumber = $_POST['StudentIDNumber'];

    //$Q2 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseTitle = '{$Course}'");
	$QueryCourses = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$Course'");
	echo '<select id="SubjectSelect" class="form-control">';
	while($Row = mysql_fetch_assoc($QueryCourses)){
		$CourseCode = $Row['CourseCode']; $SubjectNumber = $Row['CourseNumber'];
		$QueryEnrolled = mysql_query("SELECT * FROM faculty WHERE SubjectNumber = '$SubjectNumber'") or die(mysql_error());
		$RowEnrolled = mysql_fetch_assoc($QueryEnrolled);
		
		$Data = $Functions->SelectOne("faculty","SubjectNumber","$SubjectNumber");
		if($Row['CourseNumber'] != $Data[2]){
			echo '<option>'.$CourseCode.'</option>';
		}
	}
	echo '</select>';
}

if(isset($_GET['StudentNumber'])){
	$Program = $_POST['Program'];
	echo $Functions->StudentIDNumberGenerator($Program);
}

if(isset($_GET['ShifterCourseSelection'])){
	$CurrentCourse = $_POST['CurrentCourse'];
	echo '<select id="ShifterSelectedCourse" class="form-control">';
	echo '<option>New Course</option>';
	$Data = $Functions->Courses2();
	for($x=0;$x<count($Data);$x++){
		if($CurrentCourse != $Data[$x]){
			echo '<option>'.$Data[$x].'</option>';
		}
	}
	echo '</select>';
}

if(isset($_GET['ShifterSubjects'])){
	$StudentNumber = @$_POST['StudentIDNumber'];
	$CourseTitle = @$_POST['CurrentCourse'];
	echo '<table border="0" width="100%" cellspacing="0" id="Course"><tr>';
	echo '<td width="15%" align="center">Course Code</td> <td>Descriptive Title</td><td width="8%" align="center">Units</td><td width="20%">Instructor</td><td width="3%"></td></tr>';
	$Query = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$CourseTitle'");
	for($x=0;$Row = mysql_fetch_assoc($Query);$x++){
		$SubjectNumber = $Row['CourseNumber'];
		$Data = $Functions->SelectOne("faculty","SubjectNumber","$SubjectNumber");
		echo '<input type="hidden" value="$x" id="ShifterSubjetcs"/>';
		if(!empty($Row['CourseCode']))
			if(!empty($Data[1]))
				echo '<tr><td align="center">'.$Row['CourseCode'].'</td> <td>'.$Row['DescriptiveTitle'].'</td><td align="center">'.$Row['Units'].'</td><td>'.$Data[1].'</td><td><input type="checkbox" checked value="'.$Row['CourseCode'].'" id="ShifterCheckBoxChoose'.$x.'" class="CheckBoxChoose"></td></tr>';
			else
				echo '<tr><td align="center">'.$Row['CourseCode'].'</td> <td>'.$Row['DescriptiveTitle'].'</td><td align="center">'.$Row['Units'].'</td><td>'.$Data[1].'</td><td><input type="checkbox" value="'.$Row['CourseCode'].'" id="ShifterCheckBoxChoose'.$x.'" class="CheckBoxChoose"></td></tr>';
		
	}
	echo '<input type="hidden" value="'.$x.'" id="ShifterSubjects"/>';
	echo '</table>';
}

if(isset($_GET['CourseSelection'])){
	$Course = $_POST['Course'];
	$Courses = $Functions->Courses($Course);
	echo '<select id="StudentCourse"><option>Select Course</option>';
	 for($x=0;$x < count($Courses);$x++){
			if(@$_SESSION['CourseTitle'] == $Courses[$x])
				echo '<option selected>'.$Courses[$x].'</option>';
			else
				echo '<option>'.$Courses[$x].'</option>';
	}
	echo '</select>';
}

if(isset($_GET['OldStudent'])){
	$CreditedSubjectButton = "";
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$_POST['StudentNumber']}'");
	if(count($Q1)>0){
		$StudentSem = $Functions->YearSemGenerator();
		$StudentIDNumber = $_POST['StudentNumber'];
	    $Q2 = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$_POST['StudentNumber']}'");
		echo "
			<table class='table Box-shadow'>
                <tr>
                    <td rowspan='6' width='10%' align='center' class='BorderRight'>
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
        ";			

		if(empty($Q2[0][2])){
			$CoursesArray = array();
		    $QCourses = $Functions2->PDO_SQL("SELECT * FROM courses WHERE Program = '{$Q2[0][1]}'");
		    $Courses = "<option>New Course</option>";
		    foreach ($QCourses as $a => $b) {
		    	if(!in_array($b[5],$CoursesArray))
		    		$CoursesArray[] = $b[5];
		    }

		    foreach ($CoursesArray as $a => $b) {
			    $Courses .= "<option>{$b}</option>";
		    }

			echo "
                <tr id='ShifterHolder'>
                    <td colspan='2'>
                        <div class='col-md-12'><strong>Enrol to a course:</strong></div>
                        <div class='form-group col-md-9'>
	                        <select class='form-control' id='ShifterSelectedCourse'>{$Courses}</select>
                        </div>
                        <div class='col-md-2'>
	                        <input type='button' class='btn btn-sm btn-success disabled' value='Submit' id='Button_Shift'/>
                        </div>
                    </td>
                </tr>
			";
		}
		else{
	        $Course = $Q2[0][2];
		    $QCourses = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseTitle = '{$Course}'");
		    $CourseOption = ""; $CourseOptionSelected = "";
		    foreach ($QCourses as $a => $b) {

			    $QFaculty = $Functions2->PDO_SQL("SELECT * FROM faculty WHERE SubjectNumber = '{$b[0]}'");
			    $QEnrolled = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '{$_POST['StudentNumber']}' AND CourseCode = '{$b[1]}'");

		    	if($Q2[0][6] == "Transferee" || $Q2[0][6] == "Shift"){
			    	$CreditedSubjectButton = "<a class='btn btn-xs btn-warning' href='#CreditedSubject#{$b[0]}#{$b[1]}#{$a}' id='EventCreditedSubject_{$a}'>Credited</a>";
		    	}

			    if(count($QEnrolled)>0){
			    	$CourseOptionSelected .= "
			    		<input type='text' value='{$b[1]}' id='AddSubjectToEnrol_{$a}' class='hidden InputSubject'>
			    		<tr class='hidden'>
			    			<td>
						    	<div class='col-md-9'>{$b[1]}<br/>{$b[2]}</div>
						    	<div class='col-md-3'>
							    	<button class='btn btn-xs btn-danger pull-right RemoveEnrolSubject'>Remove</button>
						    	</div>
			    			</td>
		    			</tr>
	    			"; 
			    	$CourseOption .= "
					    <tr class=''>
						    <td>
						    	<div class='col-md-8'>{$b[1]}<br/>{$b[2]}</div>
						    	<div class='col-md-4'>
							    	<button class='btn btn-xs btn-danger pull-right AddEnrolSubject hidden'>Enrol</button>
						    	</div>
						    </td>
					    </tr>
	    			";
			    }
			    else{
				    if(count($QFaculty)>0){
				    	$CourseOptionSelected .= "
				    		<input type='text' value='{$b[1]}' id='AddSubjectToEnrol_{$a}' class='hidden InputSubject AddSubjectToEnrol'>
				    		<tr>
				    			<td>
							    	<div class='col-md-9'>{$b[1]}<br/>{$b[2]}</div>
							    	<div class='col-md-3'>
								    	<button class='btn btn-xs btn-danger pull-right RemoveEnrolSubject'>Remove</button>
							    	</div>
				    			</td>
			    			</tr>
		    			"; 
				    	$CourseOption .= "
						    <tr class='hidden'>
							    <td>
							    	<div class='col-md-8'>{$b[1]}<br/>{$b[2]}</div>
							    	<div class='col-md-4'>
								    	<button class='btn btn-xs btn-danger AddEnrolSubject'>Enrol</button>
								    	{$CreditedSubjectButton}
							    	</div>
							    </td>
						    </tr>
					    ";			    	

				    }
				    else{
				    	$CourseOptionSelected .= "
				    		<input type='text' value='{$b[1]}' id='AddSubjectToEnrol_{$a}' class='hidden InputSubject'>
				    		<tr class='hidden'>
				    			<td>
							    	<div class='col-md-9'>{$b[1]}<br/>{$b[2]}</div>
							    	<div class='col-md-3'>
								    	<button class='btn btn-xs btn-danger pull-right RemoveEnrolSubject'>Remove</button>
							    	</div>
				    			</td>
			    			</tr>
		    			"; 

				    	$CourseOption .= "
						    <tr>
							    <td>
							    	<div class='col-md-8'>{$b[1]}<br/>{$b[2]}</div>
							    	<div class='col-md-4'>
								    	<button class='btn btn-xs btn-danger AddEnrolSubject'>Enrol</button>
								    	{$CreditedSubjectButton}
							    	</div>
							    </td>
						    </tr>
					    ";			    	
				    }			    	
			    }
		    }

		    if($CourseOptionSelected == "")
	            $EnrolButton = "<input type='button' value='Enrol' id='ButtonEnrol' class='btn btn-success btn-sm btn-block disabled pull-right'>";
		    else
	            $EnrolButton = "<input type='button' value='Enrol' id='ButtonEnrol' class='btn btn-success btn-sm btn-block pull-right'>";

			echo "
				</table>

				<table id='OldCourseInputs' class='table table-striped Box-shadow'>
				    <tr>
				        <td>Course: {$Course}</td>
				    </tr>
				    <tr>
				        <td>
							<div class='col-md-6'>
								<div class='panel panel-default'>
									<div class='panel-heading'>Subjects</div>
									<table class='table table-striped' id='SubjectsList'>
							            {$CourseOption}
						            </table>
					            </div>
							</div>
							<div class='col-md-6'>
								<div class='panel panel-default'>
									<div class='panel-heading'>Subjects to enrol</div>
									<table class='table table-striped' id='SuggestedSubjectsList'>
							            {$CourseOptionSelected}
							            <tr>
							            	<td>
							            	{$EnrolButton}
							            	</td>
							            </tr>
						            </table>
					            </div>
							</div>
				        </td>
				    </tr>
				</table>
			";
		}
	}
	else
		echo "
	<div class='col-md-12'>
		<div class='alert alert-danger'>
			There is no student with the STUDENT ID of <strong><u>{$_POST['StudentNumber']}</u></strong>
		</div>
	</div>
	";
}

if(isset($_GET['ShiftStudent'])){
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$_POST['StudentNumber']}'");
	if(count($Q1)>0){
		$CoursesArray = array(); $Courses = "";
		$StudentSem = $Functions->YearSemGenerator();
		$StudentIDNumber = $_POST['StudentNumber'];
	    $Q2 = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$_POST['StudentNumber']}'");

	    $QCourses = $Functions2->PDO_SQL("SELECT * FROM courses WHERE Program = '{$Q2[0][1]}'");
	    foreach ($QCourses as $a => $b) {
	    	if(!in_array($b[5],$CoursesArray))
	    		$CoursesArray[] = $b[5];
	    }

	    $Courses = "<option>New Course</option>";
	    foreach ($CoursesArray as $a => $b) {
	    	if($b!=$Q2[0][2])
			    $Courses .= "<option>{$b}</option>";
	    }
		echo "
			<table class='table Box-shadow'>
                <tr>
                    <td rowspan='6' width='10%' align='center' class='BorderRight'>
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
		        <tr id='ShifterHolder'>
		            <td colspan='2'>
		                <div class='col-md-12'><strong>Currently enrolled in: </strong><u>{$Q2[0][2]}</u></div>	            	
		                <div class='col-md-12'><strong>Enrol to a course:</strong></div>
		                <div class='form-group col-md-9'>
		                    <select class='form-control' id='ShifterSelectedCourse'>{$Courses}</select>
		                </div>
		                <div class='col-md-2'>
		                    <input type='button' class='btn btn-sm btn-success disabled' value='Submit' id='Button_Shift'/>
		                </div>
		            </td>
		        </tr>
	        </table>
		";
	}
	else
		echo 0;
}

if(isset($_GET['EnrolSubjects'])){
	$Data = $_POST['Data']; 
    $QTest = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE RegistrationCode = '{$Data[1]}'");
    if(count($QTest)==0){
		$Faculty = ""; $Status = 0;
		$StudentIDNumber = $Data[0];
		$YearAndSemSem = $Functions->YearSemGenerator();
	    $Q1 = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$StudentIDNumber}'");
	    $Course = $Q1[0][2];
	    foreach ($Data[2] as $a => $b) {
		    $Q2 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseCode = '{$b}' AND CourseTitle = '{$Q1[0][2]}'");
		    $Q3 = $Functions2->PDO_SQL("SELECT * FROM faculty WHERE SubjectNumber = '{$Q2[0][0]}'");
		    if(count($Q3)>0)
		    	$Faculty = "{$Q3[0][1]}";

	        $Query = $Functions2->PDO_SQLQuery("INSERT INTO enrolledsubject(CourseCode,StudentIDNumber,YearSem,RegistrationCode,Professor) VALUES('{$b}','{$StudentIDNumber}','{$YearAndSemSem}','{$Data[1]}','{$Faculty}')");
	        if(!$Query->execute()){
	            $Status = 1;
	        }
	    }
	    echo $Status;
    }
}

if(isset($_GET['GeneratedCode'])){
	echo $Functions->CodeGenerator();
}

if(isset($_GET['Print'])){
	$ID = $Functions->IDGenerator('students','StudentID');
	$GivenName = $_POST['StudentGivenName'];
	$MiddleName = $_POST['StudentMiddleName'];
	$FamilyName = $_POST['StudentFamilyName'];
	$DOB = $_POST['StudentMonth'].'/'.$_POST['StudentDay'].'/'.$_POST['StudentYearOfBirth'];
	$Address = $_POST['StudentAddress'];
	$Mobile = $_POST['StudentMobileNumber'];
	$IDNum = $_POST['StudentIDNumber'];
	$Guardian = $_POST['StudentGuardian'];
	$GCN = $_POST['StudentGuardianContactNumber'];
	$StudentProgram = strtoupper($_POST['StudentProgram']);
	$CourseTitle = @$_POST['CourseTitle'];
	$StudentGender = $_POST['StudentGender'];
	$CodeGen = $_POST['CodeGen'];
	$EnrolledSubjects = $_POST['EnrolledSubjects'];
	$StudentType = $_POST['StudentType'];
	$Subjects = explode('/',$EnrolledSubjects);	
	$Data3 = $Functions->YearSemGenerator();
	$Data3 = explode('/',$Data3);
	echo '<table border="0" width="90%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left">Assessment Code: '.$CodeGen.'</td>
		</tr>
		<tr>
			<td align="center">
				PANGASINAN STATE UNIVERSITY<br/>
				GRADUATE SCHOOL<br/>
				Urdaneta City, Pangasinan<br/><br/>
				'.$Data3[1].'ester, School Year '.$Data3[0].'-'.($Data3[0]+1).'
			</td>
		</tr>
		<tr>
			<td align="center">
				Enrollment Form<br/>
			</td>
		</tr>
	</table><br/>';
	echo '<table border="0" width="90%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="20%">Name: </td>
			<td>'.$FamilyName.', '.$GivenName.' '.$MiddleName.'</td>
		</tr>
		<tr>
			<td>Student Number:</td>
			<td>'.$IDNum.'</td>
		</tr>
		<tr>
			<td>Course:</td>
			<td>'.$CourseTitle.'</td>
		</tr>
	 </table><br/>';
	echo '<table border="1" width="90%" align="center" cellpadding="0" cellspacing="0">
		<tr><td width="15%" align="center">Course Code</td><td align="center">Descriptive Title</td><td width="8%" align="center">Units</td><td width="30%" align="center">Instructor</td></tr>';
	for($x=0;$x<(count($Subjects)-1);$x++){
		if(!empty($Subjects)){
			$Query = mysql_query("Select * FROM courses WHERE CourseTitle = '$CourseTitle' AND CourseCode = '$Subjects[$x]'") or die(mysql_error());
			$Row = mysql_fetch_assoc($Query);
			$Data = $Functions->SelectOne("faculty","SubjectNumber",$Row['CourseNumber']);
			echo '
				<tr>
					<td align="center">'.$Subjects[$x].'</td><td>'.$Row['DescriptiveTitle'].'</td><td align="center">'.$Row['Units'].'</td><td>'.$Data[1].'</td>
				</tr>';
		}
	}
	echo '</table>';
}

if(isset($_GET['OldPrint'])){
	$StudentIDNumber = $_POST['StudentIDNumber'];
	$Subject = $_POST['StudentCourseCode'];
	$Subjects = explode('/',$Subject);
	$CodeGen = $Functions->CodeGenerator();	
	$Data = $Functions->SelectOne("studentscourse","StudentIDNumber","$StudentIDNumber");
	$Data2 = $Functions->SelectOne("students","StudentIDNumber","$StudentIDNumber");
	$Data3 = $Functions->YearSemGenerator();
	$Data3 = explode('/',$Data3);
	echo '<table border="0" width="90%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left">Assessment Code: '.$CodeGen.'</td>
		</tr>
		<tr>
			<td align="center">
				PANGASINAN STATE UNIVERSITY<br/>
				GRADUATE SCHOOL<br/>
				Urdaneta City, Pangasinan<br/>
				'.$Data3[1].'ester, School Year '.$Data3[0].'-'.($Data3[0]+1).'
			</td>
		</tr>
		<tr>
			<td align="center">
				Enrollment Form</td>
		</tr>
	</table><br/>';
	echo '<table border="0" width="90%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="20%">Name: </td>
			<td>'.$Data2[4].', '.$Data2[2].' '.$Data2[3].'</td>
		</tr>
		<tr>
			<td>Student Number:</td>
			<td>'.$Data2[1].'</td>
		</tr>
		<tr>
			<td>Course:</td>
			<td>'.$Data[2].'</td>
		</tr>
	 </table><br/>';
	 $Course = $Data[2];
	echo '<table border="1" width="90%" align="center" cellpadding="0" cellspacing="0">
		<tr><td width="15%" align="center">Course Code</td><td align="center">Descriptive Title</td><td width="8%" align="center">Units</td><td width="30%" align="center">Instructor</td></tr>';
	for($x=0;$x<(count($Subjects)-1);$x++){
		if(!empty($Subjects)){
			$Query = mysql_query("Select * FROM courses WHERE CourseTitle = '$Course' AND CourseCode = '$Subjects[$x]'") or die(mysql_error());
			$Row = mysql_fetch_assoc($Query);
			$Data = $Functions->SelectOne("faculty","SubjectNumber",$Row['CourseNumber']);
			echo '
				<tr>
					<td align="center">'.$Subjects[$x].'</td><td>'.$Row['DescriptiveTitle'].'</td><td align="center">'.$Row['Units'].'</td><td>'.$Data[1].'</td>
				</tr>';
		}
	}
	echo '</table>';
}

if(isset($_GET['PrintUnits'])){
	?>
    <style type="text/css">
    	body{font-family:"ARIAL";font-size:12px;}
		h1{font-size:20px; font-weight:bold; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h2{font-size:15px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h3{font-size:12px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h4{font-size:10px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		hr{border:none; border-top:3px solid #000; border-bottom:1px solid #000; height:3px; margin-top:0px;}
    	.OldEnglish{font-family:"Old English Text MT";}
		.small{font-size:10px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		.SmallFont{font-size:10px;}
		.FloatLeft{float:left;}
		.UnderLine{ text-decoration:underline;}
		.DoubleLine{width:100%; height:5px; border:none; border-top:1px solid #000; border-bottom:1px solid #000; margin-top:10px; margin-bottom:10px;}
		.bordered{border:1px solid #ddd;}
		.Title{font-size:20px; font-family:"CENTURY GOTHIC";}
		.LetterBody{text-align:justify; font-family:"CENTURY GOTHIC";}
	</style>
    <?php
	$StudentIDNumber = $_POST['StudentIDNumber'];
	$Data = explode(' ',$StudentIDNumber);
	$StudentIDNumber = trim($Data[count($Data)-1]);
	$CourseQuery = mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$StudentIDNumber'");
	$CourseRow = mysql_fetch_assoc($CourseQuery);
	$Units = $_POST['Units'];$YearSem = '';
	$Month = array("January","February","March","April","May","June","July","August","September","October","November","December");
	$Date = mysql_query("SELECT CURDATE() as Date"); $Row = mysql_fetch_assoc($Date); $Dates = explode('-',$Row['Date']);
	for($x=0;$x<$Dates[1];$x++){ $MonthNow = $Month[$x]; }
	$Data = $Functions->SelectOne("students","StudentIDNumber","$StudentIDNumber");
	if($Data[5] == 'Male'){
		$Name = 'Mr. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Mr. '.$Data[4]; $Name3 = 'he'; $Name4 = 'He'; $Name5 = 'him';
	}
	else{
		if($Data[8] == 'Single'){
			$Name = 'Ms. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Ms. '.$Data[2];
		}
		else{
			$Name = 'Mrs. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Mrs. '.$Data[2];
		}
		$Name3 = 'she'; $Name4 = 'She'; $Name5 = 'her';
	}
	$Data2 = $Functions->SelectOne("studentscourse","StudentIDNumber","$StudentIDNumber");
	echo '
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" colspan="3">
					<h2><span class="small">Republic of the Philippines<br/></span>PANGASINAN STATE UNIVERSITY<br/><h3>OPEN UNIVERSITY SYSTEMS</h3></h2>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<h3>Lingayen, Pangasinan 2401</h3>
					<h3>
						Website:http://www.pus.edu.ph &bull; Telefax: (075) 542-4261 / 542-5047<br/>
						&emsp;&emsp;www.psu.ous.org &bull; Telefax: (075) 542-6103
					</h3>	
					<hr/>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<span class="Title"><br/><br/><strong>C E R T I F I C A T I O N</strong><br/><br/></span>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="3">
					&emsp;&emsp;This is to certify that <strong>'.$Name.'</strong>, a resident of '.$Data[6].' has earned '.$Units.' units leading to the degree of '.$Data2['2'].' to wit.<br/><br/>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="3">
					&emsp;&emsp;This certification is issued upon the request of '.$Name2.' for whatever legal purposes it may serve '.$Name5.'.<br/><br/>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="3">
					&emsp;&emsp;Issued this '.$Dates[2].'th day of '.$MonthNow.', '.$Dates[0].' .
				</td>
			</tr>
			<tr>
				<td align="center"><br/><br/>
					<strong>Mr. MICHAEL P. ARQUILLANO</strong><br/>
					OUS Registrar
				</td>
				<td width="30%">
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
				</td>
				<td align="center">
					<strong>ARMANDO D. JUNIO, Ph.D.</strong><br/>
					Executive Director
				</td>
			</tr>
			<tr>
				<td colspan="3">
				O.R. No.: '.$_POST['OR'].'<br/>
				Date Paid: '.$_POST['PaymentDate'].'<br/><br/>
				NOT VALID WITHOUT OUS SEAL
				</td>
			</tr>
		</table>
	';
}

if(isset($_GET['PrintMoral'])){
	?>
    <style type="text/css">
		h1{font-size:20px; font-weight:bold; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h2{font-size:15px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h3{font-size:12px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		.Title{font-size:20px; font-family:"CENTURY GOTHIC";}
		.LetterBody{text-align:justify; font-family:"CENTURY GOTHIC";}
	</style>
    <?php
	$StudentIDNumber = $_POST['StudentIDNumber'];
	$Data = explode(' ',$StudentIDNumber);
	$Units = $_POST['Units'];
	$YearSem = '';
	$StudentIDNumber = trim($Data[count($Data)-1]);
	$Month = array("January","February","March","April","May","June","July","August","September","October","November","December");
	
	$Query = mysql_query("SELECT DISTINCT YearSem FROM enrolledsubject WHERE StudentIDNumber = '$StudentIDNumber' ORDER BY YearSem");
	while($Row = mysql_fetch_assoc($Query)){
		$YearSem = $YearSem.$Row['YearSem'].'//';
	}
	$YearSem = explode("//",$YearSem); $YearSemCount = count($YearSem)-1;
	$First = explode('/',$YearSem[0]);
	$Last = explode('/',$YearSem[$YearSemCount-1]);	
	
	$Date = mysql_query("SELECT CURDATE() as Date"); $Row = mysql_fetch_assoc($Date); $Dates = explode('-',$Row['Date']);
	for($x=0;$x<$Dates[1];$x++){ $MonthNow = $Month[$x]; }
	$Data = $Functions->SelectOne("students","StudentIDNumber","$StudentIDNumber");
	if($Data[5] == 'Male'){
		$Name = 'Mr. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Mr. '.$Data[4]; $Name3 = 'he'; $Name4 = 'He';
	}
	else{
		if($Data[8] == 'Single'){
			$Name = 'Ms. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Ms. '.$Data[2];
		}
		else{
			$Name = 'Mrs. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Mrs. '.$Data[2];
		}
		$Name3 = 'she'; $Name4 = 'She';
	}
	$Data2 = $Functions->SelectOne("studentscourse","StudentIDNumber","$StudentIDNumber");
	
	echo '
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" colspan="2">
					<h2>Republic of the Philippines</h2>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<h1>PANGASINAN STATE UNIVERSITY<br/>
					GRADUATE SCHOOL</h1>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<h2><strong>Urdaneta City</strong></h2>
					<h3>Website:http://www.psu.edu.ph<br/>
					Telefax: (075) 568-2568</h3>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<span class="Title"><br/><br/><strong>CERTIFICATION OF GOOD MORAL CHARACTER</strong><br/><br/></span>
				</td>
			</tr>
			<tr>
				<td align="left" colspan="2">
					To Whom It May Concern:<br/><br/>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="2">
					&emsp;&emsp;This is to certify that <strong>'.$Name.'</strong> of '.$Data[6].' had been a student of the Pangasinan State University – Graduate School, Urdaneta City for the period of '.$First[1].'., '.$First[0].'-'.($First[0]+1).' to '.$Last[1].'.,'.$Last['0'].'-'.($Last['0']+1).'.<br/><br/>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="2">
					&emsp;&emsp;According to records kept in this office, '.$Name3.' has never been found guilty of violating the law or any school rules and regulations or subject to any disciplinary action or any form of misbehaviour. '.$Name4.' has known to be cooperative and conscientious student who possesses good moral character.<br/><br/>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="2">
					&emsp;&emsp;Issued this '.$Dates[2].'th day of '.$MonthNow.', '.$Dates[0].' .
				</td>
			</tr>
			<tr>
				<td width="70%">
				</td>
				<td align="center"><br/><br/><br/><br/>
					<strong>ZENAIDA U SUYAT, Ed. D.</strong>
					GS DEAN
				</td>
			</tr>
			<tr>
				<td colspan="2">
				O.R. No.:<span id="MoralX"></span><br/>
				Date Paid: '.date('m').'/'.date('d').'/'.date('Y').'<br/><br/><br/><br/>
				NOT VALID WITHOUT<br/>
				COLLEGE SEAL
				</td>
			</tr>
		</table>
	';
}

if(isset($_GET['PrintGrades'])){
	?>
    <style type="text/css">
    	body{font-family:"ARIAL";font-size:12px;}
		h1{font-size:20px; font-weight:bold; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h2{font-size:15px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h3{font-size:12px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h4{font-size:10px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		hr{border:none; border-top:3px solid #000; border-bottom:1px solid #000; height:3px; margin-top:0px;}
    	.OldEnglish{font-family:"Old English Text MT";}
		.small{font-size:10px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		.SmallFont{font-size:10px;}
		.FloatLeft{float:left;}
		.UnderLine{ text-decoration:underline;}
		.DoubleLine{width:100%; height:5px; border:none; border-top:1px solid #000; border-bottom:1px solid #000; margin-top:10px; margin-bottom:10px;}
		.bordered{border:1px solid #ddd;}
		.Title{font-size:20px; font-family:"CENTURY GOTHIC";}
		.LetterBody{text-align:justify; font-family:"CENTURY GOTHIC";}
	</style>
    <?php
	$StudentIDNumber = $_POST['StudentIDNumber'];
	$Data = explode(' ',$StudentIDNumber);
	$StudentIDNumber = trim($Data[count($Data)-1]);
	$CourseQuery = mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$StudentIDNumber'");
	$CourseRow = mysql_fetch_assoc($CourseQuery);
	$Units = $_POST['Units'];$YearSem = '';
	$Month = array("January","February","March","April","May","June","July","August","September","October","November","December");
	$Date = mysql_query("SELECT CURDATE() as Date"); $Row = mysql_fetch_assoc($Date); $Dates = explode('-',$Row['Date']);
	for($x=0;$x<$Dates[1];$x++){ $MonthNow = $Month[$x]; }
	$Data = $Functions->SelectOne("students","StudentIDNumber","$StudentIDNumber");
	if($Data[5] == 'Male'){
		$Name = 'Mr. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Mr. '.$Data[4]; $Name3 = 'he'; $Name4 = 'He'; $Name5 = 'him';
	}
	else{
		if($Data[8] == 'Single'){
			$Name = 'Ms. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Ms. '.$Data[2];
		}
		else{
			$Name = 'Mrs. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Mrs. '.$Data[2];
		}
		$Name3 = 'she'; $Name4 = 'She'; $Name5 = 'her';
	}
	$Data2 = $Functions->SelectOne("studentscourse","StudentIDNumber","$StudentIDNumber");
	echo '
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" colspan="3">
					<h2><span class="small">Republic of the Philippines<br/></span>PANGASINAN STATE UNIVERSITY<br/><h3>OPEN UNIVERSITY SYSTEMS</h3></h2>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<h3>Lingayen, Pangasinan 2401</h3>
					<h3>
						Website:http://www.pus.edu.ph &bull; Telefax: (075) 542-4261 / 542-5047<br/>
						&emsp;&emsp;www.psu.ous.org &bull; Telefax: (075) 542-6103
					</h3>	
					<hr/>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<span class="Title"><br/><br/><strong>C E R T I F I C A T I O N</strong><br/><br/></span>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="3">
					&emsp;&emsp;This is to certify that <strong>'.$Name.'</strong>, a resident of '.$Data[6].' has earned '.$Units.' units leading to the degree of '.$Data2['2'].' to wit:<br/><br/>
				</td>
			</tr>
			<tr>
				<td class="LetterBody" colspan="3">';
				
	$CourseTitle = $CourseRow['StudentCourse'];
	$Query = mysql_query("SELECT DISTINCT YearSem FROM enrolledsubject WHERE StudentIDNumber = '$StudentIDNumber' ORDER BY YearSem");
	echo '<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="Box-shadow"><tr><td width="10%" align="center">Course No.</td><td align="center" width="50%">Course Title</td><td width="5%" align="center">Rating</td><td width="5%" align="center">Unit</td></tr>';
	while($Row = mysql_fetch_assoc($Query)){
		$YS = $Row['YearSem'];
		$YearSem = explode('/',$YS);
		echo '
			<tr>
				<td colspan="4"><em><strong>'.$YearSem[1].'.,'.$YearSem[0].'-'.($YearSem[0]+1).'</strong></em></td>
			</tr>
		';
		$Query2 = mysql_query("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$StudentIDNumber' AND YearSem = '$YS'");
		while($Row2 = mysql_fetch_assoc($Query2)){
			$CourseCode = $Row2['CourseCode'];
			$CourseTitle = $CourseRow['StudentCourse'];
			$Query3 = mysql_query("SELECT * FROM courses WHERE CourseCode = '$CourseCode' AND CourseTitle = '$CourseTitle'");
			$Row3 = mysql_fetch_assoc($Query3);$Rating = "";
			if(!empty($Row2['Rating'])){
				$Grade = explode("/",$Row2['Rating']);
				$Rating = $Grade[0];
				if(count($Grade)==2)
					$Rating = $Grade[1];
			}
			else{
				$Rating = "On-going";
			}
			echo '
				<tr>
					<td align="center">'.$Row2['CourseCode'].'</td>
					<td>'.$Row3['DescriptiveTitle'].'</td>
					<td align="center">'.$Rating.'</td>
					<td align="center">'.$Row3['Units'].'</td>
				</tr>
			
			';
		}
	}
	echo '</table>';
	echo 
				'</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="3"><br/>
					&emsp;&emsp;This certification is issued upon the request of '.$Name2.' for whatever legal purposes it may serve '.$Name5.'.<br/><br/>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="3">
					&emsp;&emsp;Issued this '.$Dates[2].'th day of '.$MonthNow.', '.$Dates[0].' .
				</td>
			</tr>
			<tr>
				<td align="center"><br/><br/>
					<strong>Mr. MICHAEL P. ARQUILLANO</strong><br/>
					OUS Registrar
				</td>
				<td width="30%">
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
				</td>
				<td align="center">
					<strong>ARMANDO D. JUNIO, Ph.D.</strong><br/>
					Executive Director
				</td>
			</tr>
			<tr>
				<td colspan="3">
				O.R. No.: '.$_POST['OR'].'<br/>
				Date Paid: '.$_POST['PaymentDate'].'<br/><br/>
				NOT VALID WITHOUT OUS SEAL
				</td>
			</tr>
		</table>
	';
}

if(isset($_GET['PrintOTR'])){
	?>
    <style type="text/css">
    	body{font-family:"ARIAL";font-size:12px;}
    	.OldEnglish{font-family:"Old English Text MT";}
		h1{font-size:20px; font-weight:bold; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h2{font-size:15px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h3{font-size:12px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		h4{font-size:10px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		.small{font-size:10px; margin:0px; padding:0px; font-family:"CENTURY GOTHIC";}
		.Title{font-size:20px; font-family:"CENTURY GOTHIC";}
		.LetterBody{text-align:justify; font-family:"CENTURY GOTHIC"; font-size:12px;}
		hr{border:none; border-top:3px solid #000; border-bottom:1px solid #000; height:3px; margin-top:0px;}
		.SmallFont{font-size:10px;}
		.FloatLeft{float:left;}
		.UnderLine{ text-decoration:underline;}
		.DoubleLine{width:100%; height:5px; border:none; border-top:1px solid #000; border-bottom:1px solid #000; margin-top:10px; margin-bottom:10px;}
		.bordered{border:1px solid #ddd;}
	</style>
    <?php
    $PaymentDate = $_POST['PaymentDate'];
    $OTRNote = $_POST['OTRNote'];
	$StudentIDNumber = $_POST['StudentIDNumber'];
	$Data = explode(' ',$StudentIDNumber);
	$StudentIDNumber = trim($Data[count($Data)-1]);
	$CourseQuery = mysql_query("SELECT * FROM studentscourse WHERE StudentIDNumber = '$StudentIDNumber'");
	$CourseRow = mysql_fetch_assoc($CourseQuery);
	$Units = $_POST['Units'];$YearSem = '';
	$Month = array("January","February","March","April","May","June","July","August","September","October","November","December");
	$Date = mysql_query("SELECT CURDATE() as Date"); $Row = mysql_fetch_assoc($Date); $Dates = explode('-',$Row['Date']);
	for($x=0;$x<$Dates[1];$x++){ $MonthNow = $Month[$x]; }
	$Data = $Functions->SelectOne("students","StudentIDNumber","$StudentIDNumber");
	if($Data[5] == 'Male'){
		$Name = 'Mr. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Mr. '.$Data[4]; $Name3 = 'he'; $Name4 = 'He'; $Name5 = 'him';
	}
	else{
		if($Data[8] == 'Single'){
			$Name = 'Ms. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Ms. '.$Data[2];
		}
		else{
			$Name = 'Mrs. '.$Data[2].' '.$Data[3].' '.$Data[4]; $Name2 = 'Mrs. '.$Data[2];
		}
		$Name3 = 'she'; $Name4 = 'She'; $Name5 = 'her';
	}
	$Data2 = $Functions->SelectOne("studentscourse","StudentIDNumber","$StudentIDNumber");
	echo '
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" colspan="2">
					<h2><span class="small">Republic of the Philippines<br/></span>PANGASINAN STATE UNIVERSITY<br/><h3>OPEN UNIVERSITY SYSTEMS</h3></h2>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<h3>Lingayen, Pangasinan 2401</h3>
					<h3>
						Website:http://www.pus.edu.ph &bull; Telefax: (075) 542-4261 / 542-5047<br/>
						&emsp;&emsp;www.psu.ous.org &bull; Telefax: (075) 542-6103
					</h3>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<h2><strong>OFFICE OF THE REGISTRAR</strong></h2><hr/>
				</td>
			</tr>
			<tr>
				<td align="left" colspan="2">
					<strong class="OldEnglish">Official Transcript of Record</strong>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class=" small">
						<tr>
							<td align="left" width="50%">
								OF: <u><strong>'.$Data[4].', '.$Data[2].' '.substr($Data[3],0,1).'.</strong></u>
							</td>
							<td align="left">
								Date Admitted: <u>'.$Data2[9].'</u><br/>
							</td>
						</tr>
						<tr>
							<td align="left" width="50%">
								Address: <u>'.$Data[6].'</u><br/>
							</td>
							<td align="left" rowspan="2">
								Entrance Data: <u>Official Transcript of Records from Pangasinan State University - Lingayen Campus<br/>Lingayen, Pangasinan</u>
							</td>
						</tr>
						<tr>
							<td align="left" width="50%">
								Degree Program: <u>'.$CourseRow['StudentCourse'].'</u>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="LetterBody" colspan="2">';
				
	$CourseTitle = $CourseRow['StudentCourse'];
	$Query = mysql_query("SELECT DISTINCT YearSem FROM enrolledsubject WHERE StudentIDNumber = '$StudentIDNumber' ORDER BY YearSem");
	echo '
	<table border="0" class="SmallFont  bordered">
		<tr>
			<td width="20%" align="center" rowspan="2">Course Number</td>
			<td align="center" width="50%" rowspan="2">Course Title</td>
			<td width="5%" align="center" colspan="2">Grades</td>
			<td width="5%" align="center" rowspan="2">Credits</td>
		</tr>
		<tr>
			<td align="center">Final</td>
			<td align="center">Re-Exam</td>
		</tr>
	';

	echo '<tr>
		<td width="10%" align="center"></td>
		<td align="center">
			<strong>Entrance Data</strong>:Graduated with the degree of '.$Data2[7].' on '.$Data2[10].' as of per Board of Regents Resolution No. 14 (f) series of 2010
		</td>
		<td width="5%" align="center"></td>
		<td width="10%" align="center"></td>
		<td width="5%" align="center"></td>
	</tr>';
	while($Row = mysql_fetch_assoc($Query)){
		$YS = $Row['YearSem'];
		$YearSem = explode('/',$YS);
		echo '
			<tr>
				<td align="center" class="UnderLine"><em><strong>'.$YearSem[1].'.,'.$YearSem[0].'-'.($YearSem[0]+1).'</strong></em></td><td></td><td></td><td></td><td></td>
			</tr>
		';
		$Query2 = mysql_query("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$StudentIDNumber' AND YearSem = '$YS'");
		while($Row2 = mysql_fetch_assoc($Query2)){
			$CourseCode = $Row2['CourseCode'];
			$CourseTitle = $CourseRow['StudentCourse'];
			$Query3 = mysql_query("SELECT * FROM courses WHERE CourseCode = '$CourseCode' AND CourseTitle = '$CourseTitle'");
			$Row3 = mysql_fetch_assoc($Query3); $Rating = ""; $ReExam = "";
			if(!empty($Row2['Rating'])){
				$Grade = explode("/",$Row2['Rating']);
				$Rating = $Grade[0];
				if(count($Grade)==2)
					$ReExam = $Grade[1];
			}
			else{
				$Rating = "On-going";
			}
			echo '
				<tr>
					<td align="center">'.$Row2['CourseCode'].'</td>
					<td>'.$Row3['DescriptiveTitle'].'</td>
					<td align="center">'.$Rating.'</td>
					<td align="center">'.$ReExam.'</td>
					<td align="center">'.$Row3['Units'].'</td>
				</tr>
			
			';
		}
	}
	echo '<tr>
			<td align="center" colspan="5">'.$OTRNote.'</td>
		</tr>
	';
	echo '</table>';
	echo 
				'</td>
			</tr>
			<tr>
				<td align="left" colspan="2"><br/>
					
					<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="Box-shadow SmallFont">
						<tr>
							<td width="16%">Rating System:</td>
							<td>1.00 - 1.25 - Excellent</td>
							<td>2.00 - 2.25 - Good</td>
							<td>3.00 - Passed</td>
							<td>INC - Incomplete</td>
						</tr>
						<tr>
							<td></td>
							<td>1.50 - 1.75 - very Good</td>
							<td>2.50 - 2.75 - Satisfactory</td>
							<td>4.00 - Conditional</td>
							<td>Drp - Dropped</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>5.00 - Failed</td>
							<td></td>
						</tr>
						<tr>
							<td colspan="6">Remarks: <u><em>Not valid for transfer. For reference purpose only.</em></u></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="left" class="LetterBody" colspan="2"><br/>
					<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="Box-shadow SmallFont">
						<tr>
							<td>Not Valid Without<br/>University Seal<br/><br/><br/></td>
							<td>Prepared By:<br/><br/><span class="UnderLine">CHERRY C. ANCHETA<br/></td>
							<td>Checked by:<br/><br/><span class="UnderLine">MICHAEL P. ARQUILLANO</span><br/>&emsp;&emsp;Acting Registrar</td>
						</tr>
						<tr>
							<td><br/>Official Receipt No.:<span class="UnderLine"><span id="OTRX"></span></span><br/>Date: <span class="UnderLine">'.$PaymentDate.'</span></td>
							<td><br/><span class="UnderLine">ARMANDO D. JUNIO, Ph.D.</span><br/>&emsp;&emsp;Executive Director</td>
							<td>Date: <span class="UnderLine">'.date('m').'/'.date('d').'/'.date('Y').'</span><br/><br/></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	';
}

if(isset($_GET['BackUp'])){
	$backup_file = '../DBFiles/DB_BACKUP.sql';
	$mybackup = $Functions->backup_tables("localhost","root","","enrolmentsystem","*");
	$handle = fopen($backup_file,'w+');
	if(fwrite($handle,$mybackup)){
		fclose($handle);
		echo 1;
	}
	else
		echo 0;
}

if(isset($_GET['GetData'])){
	$Data = $_POST['Data'];
	if($Data == "MASTERAL"){
		echo mysql_num_rows(mysql_query("SELECT * FROM studentscourse WHERE StudentProgram = 'MASTERAL'"));
	}
	else{
		echo mysql_num_rows(mysql_query("SELECT * FROM studentscourse WHERE StudentProgram = 'DOCTORAL'"));
	}
}

if(isset($_GET['TmpRating'])){
	$ID = $Functions->IDGenerator('students','StudentID');
	$StudentSem = $Functions->YearSemGenerator();
	$Code = $_POST['Code'];
 	$StudentIDNumber = $_POST['StudentIDNumber'];
	$CourseTitle = $_POST['CourseTitle'];
 	$Subject = $_POST['Subject'];
 	$Rating = $_POST['Rating'];
	$Query = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$CourseTitle' AND CourseCode = '$Subject'") or die(mysql_error());
	$Row = mysql_fetch_assoc($Query);
	
	$Data = $Functions->SelectOne("faculty","SubjectNumber",$Row['CourseNumber']);
	$Professor = $Data[1];
	
	$Query2 = mysql_query("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$StudentIDNumber' AND CourseCode = '$Subject'");
	if(mysql_num_rows($Query2) == 0){
		if(mysql_query("INSERT INTO enrolledsubject(StudentIDNumber,CourseCode,Professor,Rating,YearSem,RegistrationCode) VALUES('$StudentIDNumber','$Subject','$Professor','$Rating','$StudentSem','$Code')"))
			echo 1;
	}
	else{
		if(mysql_query("UPDATE enrolledsubject SET Rating = '$Rating',YearSem = '$StudentSem' WHERE StudentIDNumber = '$StudentIDNumber' AND CourseCode = '$Subject'"))
			echo 1;
	}
}

if(isset($_GET['Shift'])){
	$Data = $_POST['Data'];

    $Query = $Functions2->PDO_SQLQuery("UPDATE studentscourse SET StudentCourse = '{$Data[0]}', StudentType = 'Shift' WHERE StudentIDNumber = '{$Data[1]}'");
    if($Query->execute()){
		echo 1;
    }
}

if(isset($_GET['CreditedSubject'])){
	$Data = $_POST['Data'];
	$YearAndSemSem = $Functions->YearSemGenerator();

    $QCheck = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '{$Data[0][2]}' AND CourseCode = '{$Data[0][1]}'");
    if(count($QCheck)==0){
	    $Query = $Functions2->PDO_SQLQuery("INSERT INTO enrolledsubject(Rating,Professor,StudentIDNumber,CourseCode,YearSem) VALUES('{$Data[1][0]}','{$Data[1][1]}','{$Data[0][2]}','{$Data[0][1]}','{$YearAndSemSem}')");
	    if($Query->execute()){
			echo 1;
	    }    	
    }
}
?>