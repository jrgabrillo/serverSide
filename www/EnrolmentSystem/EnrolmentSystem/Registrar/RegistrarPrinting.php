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
if(isset($_GET['PrintRegistrar'])){
	$Data = $_POST['Data']; $Subjects = "";
	echo "
	<small>
	";
    $Date = $Functions2->PDO_DateNow();
    $Term = $Functions2->YearSemNow();
    $QStudent = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$Data[0]}'");
    $QStudent2 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Data[0]}'");
    foreach ($Data[2] as $a => $b) {
	    $QCourses = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseTitle = '{$QStudent[0][2]}' AND CourseCode = '{$b}'");
	    $QFaculty = $Functions2->PDO_SQL("SELECT * FROM faculty WHERE SubjectNumber = '{$QCourses[0][0]}'"); $Faculty = "-";
	    if(count($QFaculty)>0)
	    	$Faculty = "{$QFaculty[0][1]}";

	    $Subjects .= "
	    	<tr>
	    		<td><strong>{$b}</strong><br/>{$QCourses[0][2]}</td>
	    		<td align='center'>{$QCourses[0][3]}</td>
	    		<td align='center'>{$Faculty}</td>
	    	</tr>
	    ";
    }

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
										<strong>Reg. Code: </strong><u>{$Data[1]}</u><br/>
									</td>
								</tr>
							</table>
						</div>
					</td>
					<td>
						<div class='col-md-6 '>
							<div class='panel panel-default'>
							<div class='panel-heading'>Subjects</div>
							<table class='table table-bordered'>
								<tr>
									<td align='center' width='65%'>Course Code and Description</td>
									<td align='center' width='5%'>Units</td>
									<td align='center' width='30%'>Instructor</td>
								</tr>
								{$Subjects}
							</table>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</small>
	";
}
?>