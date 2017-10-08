<?php
include("../PhpFiles2/Functions.php"); 
include("../PHPFiles/Functions.php");
$Functions = new FunctionsExt;
$Functions2 = new DatabaseClasses;
session_start();

if(isset($_GET['ValidateFee'])){
	@$Input = $_POST['DataInput'];
	if($Functions->Number($Input,4) == 1)
		echo 1;
	else
		echo 0;
}

if(isset($_GET['AlphaNumeric'])){
	@$Input = $_POST['DataInput'];
	if($Functions->AlphaNumeric($Input,50) == 1)
		echo 1;
	else
		echo 0;
}

if(isset($_GET['StudentFamilyName'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidateNames($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> It doesn\'t look like a family name.</span>';
	else
		echo 0;
}

if(isset($_GET['StudentGivenName'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidateNames($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> It doesn\'t look like a given name.</span>';
	else
		echo 0;
}

if(isset($_GET['StudentMiddleName'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidateNames($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> It doesn\'t look like a middle name.</span>';
	else
		echo 0;
}

if(isset($_GET['StudentDOB'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidationDOB($Input,1950,2000) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid date of birth format [MON-DAY-YEAR]</span>';
	else
		echo 0;
}

if(isset($_GET['StudentMobileNumber'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidationMobile($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid mobile number format.</span>';
	else
		echo 0;
}

if(isset($_GET['StudentAddress'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidationAddress($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid address format.</span>';
	else
		echo 0;
}

if(isset($_GET['StudentEmailAddress'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidationEmail($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid email address format.</span>';
	else
		echo 0;
}

if(isset($_GET['StudentGuardian'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidateNames($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> It doesn\'t look like a name.</span>';
	else
		echo 0;
}

if(isset($_GET['StudentGuardianContactNumber'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidationMobile($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid mobile number format.</span>';
	else
		echo 0;
}

if(isset($_GET['StudentCourseGraduated'])){
	@$Input = $_POST['DataInput'];
	if($Functions->ValidateCourse($Input) == 1)
		echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid course format.</span>';
	else
		echo 0;
}

if(isset($_GET['Image'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		$Data = explode('\\',$Input);
		$Data1 = explode('.',@$Data[2]);
		if(@$Data1[1] != 'jpg' && @$Data1[1] != 'jpeg' && @$Data1[1] != 'gif' && @$Data1[1] != 'png')
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid image format.</span></span>';
	}
	else
		return 0;

}

if(isset($_GET['StudentIDValidation'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidationOUSStudentID($Input) == 1)
			echo '<h5><span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid OUS ID format.</span></span></h5>';
		else
			echo 0;
	}
	else
		echo '<h5><span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter a valid student ID.</span></span></h5>';
}

//adding of courses

if(isset($_GET['CourseTitleX'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidationCourseTitle($Input) == 1)
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid course title format.</span></span>';
	}
	else
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter a course title.</span></span>';
}

if(isset($_GET['CourseCodeX'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidationCourseCode($Input) == 1)
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid course code format.</span></span>';
	}
	else
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter a course code.</span></span>';
}

if(isset($_GET['DescriptiveTitleX'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidationCourseTitle($Input) == 1)
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid descriptive title format.</span></span>';
	}
	else
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter a descriptive title.</span></span>';
}

//end of adding courses


/* Assessment */
if(isset($_GET['AssessmentCode'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidationAssessmentCode($Input) == 1)
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid assessment code format.</span></span>';
	}
	else
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter a assessment code.</span></span>';
}
/* End Assessment */

/* Cashier */
if(isset($_GET['AmountPaid'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidationPayment($Input) == 1)
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid input.</span></span>';
	}
	else
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter the amount paid.</span></span>';
}

if(isset($_GET['ReceiptNumber'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidationReciept($Input) == 1)
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Invalid receipt format.</span></span>';
	}
	else
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter a receipt number.</span></span>';
}
/* End Cashier */

/*Add Faculty*/
if(isset($_GET['FacultyName'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidateNames($Input) == 1)
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Doesn\'t look like a name .</span></span>';
	}
	else
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter the faculty\s name.</span></span>';
}

if(isset($_GET['FacultyPassword'])){
	@$Input = $_POST['DataInput'];
	if(!empty($Input)){
		if($Functions->ValidationPassword($Input) == 1)
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Please try other password.</span></span>';
	}
	else
			echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Enter the faculty\'s name.</span></span>';
}

/*End Add Faculty*/

?>