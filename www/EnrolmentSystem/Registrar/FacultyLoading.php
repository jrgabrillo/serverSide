<div id="FacultyLoadingList" class="White Box-shadow">
	xx
	<?php
	$DataX = $Functions->ShowAllID("faculty","TNO");
	echo '<table class="table table-striped">';
	for($a=0;$a<count($DataX);$a++){
		$Data = $Functions->SelectOne("courses","CourseNumber",$DataX[$a]);
		print_r($Data);
		echo "<br/>";
		$DataFaculty = $Functions->SelectOne("faculty","TNO",$DataX[$a]);
		print_r($DataFaculty);

		echo '<tr><td width="30%">'.($a+1).'.&nbsp;'.$DataFaculty[1].' <span class="FacultyLoad btn btn-sm btn-warning" id="F'.$a.'">Load</span><span class="FacultySubject" id="FLoaded'.$a.'">'.$Data[1].': '.$Data[2].'</span>';
		$Courses = $Functions->Courses2();
		echo '<span class="Hidden" id="'.$a.'" ><div class="col-md-5"><select class="form-control" id="FacultyCourse'.$a.'"><option>Course</option>';
			for($x=0;$x < count($Courses);$x++){
				echo '<option>'.$Courses[$x].'</option>';
			}
		echo '</select></div>';
    
		echo '<input type="hidden" value="'.$DataX[0].'" id="FacultyID'.$a.'">
		<div class="FacultyList" id="FacultyList'.$a.'"><select class="form-control"><option>Subject</option></select></div>
		<button id="FacultySureLoad" class="btn btn-success btn-sm">Load</button> <button id="FacultyCancelLoad" class="btn btn-success btn-sm">Cancel</button></span>';
		echo '</td></tr>';		
	}
    echo '</table>';
    ?>
</div>