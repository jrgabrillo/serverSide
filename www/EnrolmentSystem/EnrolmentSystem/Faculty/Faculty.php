<?php
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 

include("../PHPFiles2/Functions.php"); 
$Functions = new FunctionsExt;
$Functions2 = new DatabaseClasses;
session_start();

if(isset($_GET['SubjectList'])){
	$Course = $_POST['CourseTitle'];
	$QueryCourses = mysql_query("SELECT * FROM courses WHERE CourseTitle = '$Course'") or die(mysql_error());
	echo '<select class="SelectLong" id="SubjectSelect">';
	while($Row = mysql_fetch_assoc($QueryCourses)){
		$CourseCode = $Row['CourseCode'];
		$QueryEnrolled = mysql_query("SELECT * FROM enrolledsubject WHERE CourseCode = '$CourseCode' and StudentIDNumber = '$StudentIDNumber'") or die(mysql_error());
		$RowEnrolled = mysql_fetch_assoc($QueryEnrolled);
		if($Row['CourseCode'] != $RowEnrolled['CourseCode'])
			echo '<option>'.$Row['CourseCode'].'</option>';
	}
	echo '</select>';
}
if(isset($_GET['UpdateSubject'])){
	$Professor = $_POST['Professor'];
	$CourseCode = $_POST['CourseCode'];
	$CourseTitle = $_POST['CourseTitle'];
	$Query = mysql_query("SELECT * FROM courses WHERE CourseCode = '$CourseCode' AND CourseTitle = '$CourseTitle'");
	$Row = mysql_fetch_assoc($Query);
	echo 'You are currently teaching '.$CourseCode.' ['.$Row['DescriptiveTitle'].']';
	$SubjectID = $Row['CourseNumber'];
	$ProfNum = mysql_num_rows(mysql_query("SELECT * FROM faculty WHERE ProfessorName = '$Professor'"));
	if($ProfNum == 0){
		//insert
		$Query = mysql_query("INSERT INTO faculty(ProfessorName,SubjectCode) VALUES('$Professor','$SubjectID')");
	}
	else{
		//update
		$Query = mysql_query("UPDATE faculty SET SubjectCode = '$SubjectID' WHERE ProfessorName = '$Professor'") or die(mysql_error());
	}

}
if(isset($_GET['AddGrade'])){
	$Grade = $_POST['Grade'];
	$StudentID = $_POST['StudentID'];
	$Professor = $_POST['Professor'];
	$CourseCode = $_POST['CourseCode'];
	$Query = mysql_query("INSERT INTO studentsgrades(StudentID,Subject,SubjectRating,Instructor) VALUES('$StudentID','$CourseCode','$Grade','$Professor')");
	header("Location:?StudentList&ID");		
}

if(isset($_GET['StudentRating'])){
	$Rating = $_POST['Rating'];
	$TNO = $_POST['TNO'];
	mysql_query("UPDATE enrolledsubject SET Rating = '$Rating' WHERE TNO = '$TNO'");
}

if(isset($_GET['StudentReExamRating'])){
    $data = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE TNO = '{$_POST['TNO']}'");
    $NewRating = "{$data[0][4]}/{$_POST['Rating']}";
	$TNO = $_POST['TNO'];
	mysql_query("UPDATE enrolledsubject SET Rating = '{$NewRating}' WHERE TNO = '$TNO'");
}

if(isset($_GET['StudentNoRatingList'])){
	$User = $_SESSION['Username'];
	$RatingsArray = array("1.00","1.25","1.50","1.75","2.00","2.25","2.50","2.75","3.00","4.00","5.00","INC","DRP"); $RatingSelect = ""; $ReExam = "";
	echo "
		<table class='table table-striped'>
	";
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE Professor = '{$User}' AND (Rating = '' || Rating = 'INC') AND DateOfEnrolment <> '' ORDER BY DateOfEnrolment DESC");
    if(count($Q1)>0){
		foreach ($Q1 as $x => $v) {
			$StudentID = $v[1];
		    $Q2 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$StudentID}'");
			$Rating = $v[4];
			if(empty($Rating)){
				$RatingMark = "<input type='button' value='Give Rating' id='Input{$x}' class='btn btn-sm btn-success Input'/>";
			}
			else{
				$Ratings = explode("/",$Rating);
				$RatingMark = "<input type='button' value='Update Rating' id='Input{$x}' class='btn btn-sm btn-success Input'/>";
				if($Rating === "INC")
					$ReExam = "<input type='button' value='Re-Exam' id='ReExam{$x}' class='btn btn-sm btn-success ReExam'/>";

				if(count($Ratings)>1)
					$RatingMark = "";
			}
	        $RatingOptions = "";
			foreach ($RatingsArray as $a => $b) {
				$RatingOptions .= "<option>{$b}</option>";
			}
			echo "
				<tr>
					<td width='40px'>
						<span id='StudentsList'>
							<img src='../StudentsPicture/{$Q2[0][13]}' draggable='false'/>
						</span>
					</td>
					<td width='25%'>
						<div class='SN'>{$Q2[0][4]}, {$Q2[0][2]} {$Q2[0][3]}<br/><span id='StudentIDNumberRating'>{$StudentID}</span></div>
					</td>
					<td width='40%'> 
						Rating:&emsp;<strong><span id='Rating{$x}'>{$Rating}</span><span id='ReExamNote{$x}' class='ReExamNote'></span></strong>
						<span id='RatingInput{$x}' class='RatingInput'>
							<select id='RatingChoices{$x}' class='btn btn-sm btn-default'>{$RatingOptions}</select>
							<input type='hidden' id='StudentsSubject{$x}' value='{$v[0]}'/>
							<input type='button' class='btn btn-sm btn-success' value='Ok' id='RateMe{$x}'/>
							<input type='button' class='btn btn-sm btn-success' value='Cancel' id='RateCancel{$x}'/>
						</span>
					</td>
					<td><span class='pull-right'>{$ReExam} {$RatingMark}</span></td>
				</tr>";
		}
		echo "</table><input type='hidden' id='TotalStudents' value='{$x}'>";
    }
    else{
    	echo "<br/><div class='col-md-12'><div class='alert alert-danger'>All your student's got grades/ratings.</div></div>";
    }

	echo "
		</table>
	";
}

if(isset($_GET['StudentList'])){
	$User = $_SESSION['Username'];
    $QSettings = $Functions2->PDO_SQL("SELECT * FROM settings WHERE SettingsLabel = 'CutOffDate'");
    $QCurrentDate = $Functions2->PDO_SQL("SELECT NOW()");
    $Date1 = date("F j, Y",strtotime($QCurrentDate[0][0])); 
    $Date2 = date("F j, Y",strtotime($QSettings[0][2]));
	$RatingMark = "";

    if($Date1 > $Date2){
    	$CutOffStatus = "The submission of grades/ratings will be cut off on {$Date2}";
    }
    else{
    	$CutOffStatus = "The submission of grades/ratings has been cut off last {$Date2}";
    }

	$YearSemNow = $Functions->YearSemNow(); $ReExam = "";
	$RatingsArray = array("1.00","1.25","1.50","1.75","2.00","2.25","2.50","2.75","3.00","4.00","5.00","INC","DRP");

	$YearSemNow = "{$YearSemNow[0]}/{$YearSemNow[1]}";
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM faculty INNER JOIN courses ON faculty.SubjectNumber = courses.CourseNumber AND faculty.ProfessorName = '{$User}'");
	$CourseCode = $Q1[0][4];
	echo "
		<table class='table table-striped table-bordered'>
			<tr>
				<th colspan='4'>
					<h4>
						Currently enrolled students taking {$CourseCode}: {$Q1[0][5]}<br/>
						<small>{$CutOffStatus}</small>
					</h4>
				</th>
			</tr>
	";
    $Q2 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject INNER JOIN students ON students.StudentIDNumber = enrolledsubject.StudentIDNumber AND enrolledsubject.CourseCode = '$CourseCode' WHERE YearSem = '{$YearSemNow}'");
	foreach ($Q2 as $x => $v) {
		$StudentID = $v[1];
	    //$Q3 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$StudentID' AND CourseCode = '$CourseCode' AND DateOfEnrolment <> ''");
	    $Q3 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject WHERE StudentIDNumber = '$StudentID' AND CourseCode = '$CourseCode'");
		$StudentInfo = $Functions->StudentInfo($StudentID);
		if(count($Q3)>0){
			$Rating = $Q3[0][4];
	        if($Date1 > $Date2){
				if(empty($Rating)){
					$RatingMark = "<input type='button' value='Give Rating' id='Input{$x}' class='btn btn-sm btn-success Input'/>";
				}
				else{
					$Ratings = explode("/",$Rating);
					$RatingMark = "<input type='button' value='Update Rating' id='Input{$x}' class='btn btn-sm btn-success Input'/>";
					if($Rating === "INC")
						$ReExam = "<input type='button' value='Re-Exam' id='ReExam{$x}' class='btn btn-sm btn-success ReExam'/>";

					if(count($Ratings)>1)
						$RatingMark = "";
				}
	        }
	        else{
	        	if(empty($Rating))
					$Rating = "-";
	        }
	        $RatingOptions = "";
			foreach ($RatingsArray as $a => $b) {
				$RatingOptions .= "<option>{$b}</option>";
			}
			echo "
				<tr>
					<td width='40px'>
						<span id='StudentsList'>
							<img src='../StudentsPicture/{$v[22]}' draggable='false'/>
						</span>
					</td>
					<td width='25%'>
						<div class='SN'>{$v[13]}, {$v[11]} {$v[12]}<br/><span id='StudentIDNumberRating'>{$StudentID}</span></div>
					</td>
					<td width='40%'> 
						Rating:&emsp;<strong><span id='Rating{$x}'>{$Rating}</span><span id='ReExamNote{$x}' class='ReExamNote'></span></strong><span id='RatingInput{$x}' class='RatingInput'>
							<select id='RatingChoices{$x}' class='btn btn-sm btn-default'>{$RatingOptions}</select>
							<input type='hidden' id='StudentsSubject{$x}' value='{$Q3[0][0]}'/>
							<input type='button' class='btn btn-sm btn-success' value='Ok' id='RateMe{$x}'/>
							<input type='button' class='btn btn-sm btn-success' value='Cancel' id='RateCancel{$x}'/>
						</span>
					</td>
					<td><span class='pull-right'>{$ReExam} {$RatingMark}</span></td>
				</tr>";
		}
	}
	echo "</table><input type='hidden' id='TotalStudents' value='{$x}'>";
}

if(isset($_GET['SetSessionConfirm'])){
	$_SESSION['Registrar'] = $_POST['Data'];
}


?>