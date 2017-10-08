<?php
include("../PHPFiles2/Functions.php"); 
include("../PHPFiles/DBConnection.php");
include("../PHPFiles/Functions.php"); 
$Functions = new FunctionsExt;
$Functions2 = new DatabaseClasses;

if(isset($_POST['?ProgramView']) && $_POST['?ProgramView'] == "Doctoral"){
    if(isset($_GET['StudentsList'])){
        $RetVal = '{"Students":[';
	    $Query = $Functions2->PDO_SQL("SELECT * FROM students INNER JOIN studentscourse ON students.StudentIDNumber = studentscourse.StudentIDNumber WHERE studentscourse.StudentProgram = 'Doctoral' ORDER BY students.StudentIDNumber DESC");

        foreach ($Query as $x => $data) {
        	if(empty($data[16]))
        		$data[16] = 'Not enrolled';
            if(count($Query) == ($x+1))
                $RetVal .= '{"Option":"<a class=\'btn btn-sm btn-success\' href=\'#ViewProfile#'.$data[1].'\'>Details</a>","Picture":"<span><img src=\'../StudentsPicture/'.$data[13].'\' draggable=\'false\'/></span>","Name":"'.$data[4].', '.$data[2].' '.$data[3].'<br/><small>'.$data[1].'</small>","Course":"'.$data[16].'"}';
            else
                $RetVal .= '{"Option":"<a class=\'btn btn-sm btn-success\' href=\'#ViewProfile#'.$data[1].'\'>Details</a>","Picture":"<span><img src=\'../StudentsPicture/'.$data[13].'\' draggable=\'false\'/></span>","Name":"'.$data[4].', '.$data[2].' '.$data[3].'<br/><small>'.$data[1].'</small>","Course":"'.$data[16].'"},';
        }
        $RetVal .= "]}";
        echo $RetVal;
    }
}
else{
    if(isset($_GET['StudentsList'])){
        $RetVal = '{"Students":[';
	    $Query = $Functions2->PDO_SQL("SELECT * FROM students INNER JOIN studentscourse ON students.StudentIDNumber = studentscourse.StudentIDNumber WHERE studentscourse.StudentProgram = 'Masteral' ORDER BY students.StudentIDNumber DESC");

        foreach ($Query as $x => $data) {
        	if(empty($data[16]))
        		$data[16] = 'Not enrolled';
            if(count($Query) == ($x+1))
                $RetVal .= '{"Option":"<a class=\'btn btn-sm btn-success\' href=\'#ViewProfile#'.$data[1].'\'>Details</a>","Picture":"<span><img src=\'../StudentsPicture/'.$data[13].'\' draggable=\'false\'/></span>","Name":"'.$data[4].', '.$data[2].' '.$data[3].'<br/><small>'.$data[1].'</small>","Course":"'.$data[16].'"}';
            else
                $RetVal .= '{"Option":"<a class=\'btn btn-sm btn-success\' href=\'#ViewProfile#'.$data[1].'\'>Details</a>","Picture":"<span><img src=\'../StudentsPicture/'.$data[13].'\' draggable=\'false\'/></span>","Name":"'.$data[4].', '.$data[2].' '.$data[3].'<br/><small>'.$data[1].'</small>","Course":"'.$data[16].'"},';
        }
        $RetVal .= "]}";
        echo $RetVal;
    }
}

if(isset($_GET['AddWorkHistory'])){
	$Data = $_POST['Data'];
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$Data[3]}'");
	$WorkHistory = "{$Q1[0][14]}{$Data[0]}<x>{$Data[1]}<x>{$Data[2]}</>";
    $Query = $Functions2->PDO_SQLQuery("UPDATE students SET StudentWorkHistory = '{$WorkHistory}' WHERE StudentIDNumber = '{$Data[3]}'");
    if($Query->execute())
    	echo "1";
    else
    	echo "0";
}

if(isset($_GET['StudentProfile'])){
	$Subjects = "";
    $data = $Functions2->PDO_SQL("SELECT * FROM students INNER JOIN studentscourse ON students.StudentIDNumber = studentscourse.StudentIDNumber WHERE studentscourse.StudentIDNumber = '{$_POST['Data']}'");
   	$RowWorkHistory = explode('</>',$data[0][14]); $DisplayWorkHistory = "";
   	foreach ($RowWorkHistory as $a => $b) {
   		$WorkHistory = explode('<x>',$b);
   		if((count($RowWorkHistory)-1) != $a)
	   		$DisplayWorkHistory .= "<tr><td>{$WorkHistory[0]}</td><td>{$WorkHistory[1]}</td><td>{$WorkHistory[2]}</td></tr>";
   	}
	echo "
		<table class='table Box-shadow'>
	        <tr>
	            <td rowspan='6' width='15%' align='center' class='BorderRight'>
	            <span id='PictureProfile'><div class='thumbnail'><img src='../StudentsPicture/{$data[0][13]}' draggable='false'/></div></span></td>
	            <td width='%'><strong>Name:</strong> <u>{$data[0][4]}, {$data[0][2]} {$data[0][3]}</u></td>
	        </tr>
	        <tr>
	            <td><strong>Student Number:</strong> <u>{$data[0][1]}</u></td>
	        </tr>
	        <tr>
	            <td><strong>Address:</strong> <u>{$data[0][6]}</u></td>
	        </tr>
	        <tr>
	            <td><strong>Date of birth:</strong> <u>{$data[0][9]}</u></td>
	        </tr>
	        <tr>
	            <td><strong>Mobile:</strong> <u>{$data[0][7]}</u></td>
	        </tr>
	        <tr>
	            <td><strong>Person notify to incase of emergency:</strong> <u>{$data[0][11]} #{$data[0][12]}</u></td>
	        </tr>
			<tr><td colspan='2'>
				<div class='col-md-12'>
					<input type='button' class='btn btn-sm btn-success' value='Add work history' id='AddStudentWorkHistory'>
					<div id='WorkHistoryInput' class='panel panel-default hidden'>
						<div class='panel-body'>
							<input type='text' class='hidden' value='{$data[0][1]}' id='StudentHistory'>
							<div class='col-md-4'>Position:<input type='text' class='form-control' id='PositionHistory'></div>
							<div class='col-md-7'>Work Address:<input type='text' class='form-control' id='WorkAddressHistory'></div>
							<div class='col-md-4'>Year/Semester:<input type='text' class='form-control' id='YearSemHistory'></div>
							<div class='col-md-4'><br/>
								<input type='button' class='btn btn-sm btn-default' value='Cancel' id='CancelAddingHistory'>
								<input type='button' class='btn btn-sm btn-warning' value='Add' id='ProceedAddingHistory'>
							</div>
							<div class='col-md-12'>
							<small class='text-danger'><i>*The information in Work History are <u>immutable</u>. Make sure that the information you provide are <u>verified reliable</u>.</i></small>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-12'><br/>
					<table class='table table-striped table-bordered' id='TableWorkHistory'>
						<tr><th>Position</th><th>Work Address</th><th>Year/Semester</th></tr>
						{$DisplayWorkHistory}
					</table>
				</div>
			</td></tr>
	    </table>
	";			

	$Units = 0; $RatingText = ""; $ProfessorText = ""; $SubjectsArray = [];
	$Q3 = $Functions2->PDO_SQL("SELECT * FROM enrolledsubject INNER JOIN courses ON enrolledsubject.CourseCode = courses.CourseCode WHERE enrolledsubject.StudentIDNumber  = '{$_POST['Data']}'");
		
	foreach ($Q3 as $c => $d) {
		if(!in_array($d[2], $SubjectsArray)){

			$SubjectsArray[] = $d[2];

			if(empty($d[4]))
				$RatingText = '-';
			else{
				$Units = $Units + $d[12];
				$RatingText = $d[4];		
			}

			if(empty($d[3]))
				$ProfessorText = "TBA";
			$Subjects .= "
				<tr>
					<td align='center'>{$d[2]}</td>
					<td>{$d[11]}</td>
					<td align='center'>{$d[12]}</td>
					<td align='center'>{$RatingText}</td>
					<td align='center'>{$d[5]}</td>
					<td align='center'>{$ProfessorText}{$d[3]}</td>
				</tr>
			";			
		}
	}
	echo "
		<table class='table table-bordered  Box-shadow'>
			<tr><td><strong>Under graduate course: </strong><u>{$data[0][22]}</td></tr>
			<tr><td><strong>OUS Course: </strong><u>{$data[0][17]}</u></td></tr>
		</table>
		<table class='table table-bordered  Box-shadow'><tr>
			<td width='10%' align='center'>Course Code</td>
			<td align='center' width='50%'>Descriptive Title</td>
			<td width='5%' align='center'>Units</td>
			<td width='5%' align='center'>Rating</td>
			<td align='center' width='14%'>Semester and Year</td>
			<td align='center'>Professor</td></tr>
			{$Subjects}
			<tr>
				<td align='right' colspan='2'>Total units earned:</td>
				<td align='center'>{$Units}</td>
				<td colspan='3'></td>
			</tr>
			<tr>
				<td colspan='6'>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h3 class='panel-title'>Documents</h3>
						</div>
						<div class='panel-body'>
							<div class='col-md-8'>
								<div class='col-md-12'>
									OTR Note on document (optional):
									<textarea class='form-control' id='ORTNote'></textarea>
								</div>
							</div>
							
							<div class='col-md-8'><br/>
								<div class='col-md-4'>
									Receipt Number(required):<span id='ORMessage'></span>
									<input type='text' id='RecieptNumber' class='form-control' maxlength='6'/>
								</div>
								<div class='col-md-4'>
									Date of payment(required):
									<input type='text' id='PaymentDate' class='form-control' maxlength='10' placeholder='MM/DD/YYYY'/>
								</div>
							</div>
							<div class='col-md-4'>
								<div class='col-md-4'>
									<br/>
									<input type='hidden' id='Hdn_units' value='{$Units}'>
									<input type='hidden' id='Hdn_SNO' value='{$data[0][1]}'>
									<input type='button' id='PrintUnits' value='Print Earned Units' class='btn btn-sm btn-success disabled'/>
									<input type='button' id='PrintGoodMoral' value='Print Good Moral' class='btn btn-sm btn-success hidden disabled'/>
									<input type='button' id='PrintGrades' value='Print Grades' class='btn btn-sm btn-success disabled'/>
									<input type='button' id='PrintOTR' value='Print OTR' class='btn btn-sm btn-success disabled'/>
								</div>
							</div>
						</div>
					</div>												
				</td>
			</tr>
		</table>
	";
}
?>