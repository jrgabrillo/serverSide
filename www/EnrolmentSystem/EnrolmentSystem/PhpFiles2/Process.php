<?php
include("Functions.php");
$Functions = new DatabaseClasses;

	if(isset($_GET['Search'])){
        $Query = $Functions->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber LIKE '%{$_POST['Data']}%'");
        $Result = "
        	<div class='panel panel-default'>
        	<table class='table table-bordered table-compresed'>
	        	<tr><th class='text-center'>Name</th><th class='text-center'>Student ID</th><th class='text-center'>Option</th></tr>
        ";
        foreach($Query as $key => $value){
        	$Result .= "
        	<tr class='text-left'>
	        	<td>{$value[4]} {$value[2]}, {$value[3]}</td>
	        	<td>{$value[1]}</td>
	        	<td><a class='btn btn-sm btn-success' href='#ViewProfile#{$value[1]}'>Details</a></td>
        	</tr>
        ";

        }
        $Result .= "</table></div>";
        echo $Result;
	}

	if(isset($_GET['Form_Others'])){
		echo "
			{$_POST['Data']}
			<input type='text' class='form-control' id='OthersInput'/>
		";
	}

	if(isset($_GET['ValidateName'])){
		$Data = $_POST['Data'];
		if($Functions->ValidateNames($Data)!==1)
			echo 1;
		else
			echo 0;
	}

	if(isset($_GET['Number'])){
		$Data = $_POST['Data'];
		if($Functions->Number($Data,2)!==1)
			echo 1;
		else
			echo 0;
	}

	if (isset($_GET['ValidateDateOfBirth'])) {
		$Data = $_POST['Data'];
		if($Functions->ValidationDOB($Data,1934,2014)!==1)
			echo 1;
		else
			echo 0;
	}

	if (isset($_GET['ValidateAddress'])) {
		$Data = $_POST['Data'];
		if($Functions->ValidationAddress($Data)!==1)
			echo 1;
		else
			echo 0;
	}

	if (isset($_GET['ValidateStudentID'])) {
		$Data = $_POST['Data'];
		if($Functions->ValidationPSUStudentID($Data)!==1)
			echo 1;
		else
			echo 0;
	}

    if (isset($_GET['CheckStudentID'])) {
        $Data = $_POST['Data'];
        $Query = $Functions->PDO_SQL("SELECT * FROM tbl_scholars INNER JOIN tbl_scholaracademics ON tbl_scholars.ScholarID = tbl_scholaracademics.ScholarID WHERE tbl_scholaracademics.ScholarStudentID = '$Data'");
        if(count($Query)==1){
        	echo $Query[0][0];
        }
        else
            echo 0;
    }

	if (isset($_GET['ValidateCost_Grantee'])) {
		$Data = $_POST['Data'];
		if($Functions->Money($Data)!==1)
			echo 1;
		else
			echo 0;
	}

	if (isset($_GET['ValidateContact'])) {
		$Data = $_POST['Data'];
		if($Functions->ValidationMobile($Data)!==1)
			echo 1;
		else
			echo 0;
	}

	if(isset($_GET['AddStudent'])){
		$Data = $_POST['Data']; $State = "";
		$FatherData = "{$Data[0][9]}<x>{$Data[0][10]}<x>{$Data[0][11]}<x>{$Data[0][12]}";
		$MotherData = "{$Data[0][13]}<x>{$Data[0][14]}<x>{$Data[0][15]}<x>{$Data[0][16]}";
		$FamilyData = "{$Data[0][7]}<x>{$Data[0][8]}";
		$OptData = "{$Data[0][17]}<x>{$Data[0][18]}";

		if(empty($Data[0][21])){
			$ScholarID = $Functions->PDO_IDGenerator('tbl_scholars','ScholarID');
			$State = "Add";
		}
		else{
			$State = "Update";
			$ScholarID = $Data[0][19];
	        $Query = $Functions->PDO_SQLQuery("DELETE FROM tbl_scholars WHERE ScholarID = '".$ScholarID."'");
	        $Query->execute();
	        $Query2 = $Functions->PDO_SQLQuery("DELETE FROM tbl_scholaracademics WHERE ScholarID = '".$ScholarID."'");
	        $Query2->execute();
		}
		$Query = $Functions->PDO_SQLQuery("INSERT INTO tbl_scholars(ScholarID,ScholarFamilyName,ScholarGivenName,ScholarMiddleName,ScholarGender,ScholarAddress,ScholarContact,ScholarBirthDate,ScholarPicture,ScholarCivilStatus,ScholarReligion,ScholarFamilyData,ScholarFatherData,ScholarMotherData,ScholarOptionalData) VALUES('$ScholarID','{$Data[0][1]}','{$Data[0][3]}','{$Data[0][2]}','{$Data[0][22]}','{$Data[0][6]}','{$Data[0][20]}','{$Data[0][5]}','Default.png','{$Data[0][23]}','{$Data[0][4]}','{$FamilyData}','{$FatherData}','{$MotherData}','{$OptData}')");
		if($Query->execute()){
			$Query = $Functions->PDO_SQLQuery("INSERT INTO tbl_scholaracademics(ScholarID,ScholarStudentID,ScholarCourse,Active) VALUES('$ScholarID','{$Data[0][19]}','{$Data[0][24]}','1')");
			if($Query->execute())
				echo 1 .'<->'.$State;
			else{
				$Data = $Query->errorInfo();
				print_r($Data);
			}
		}
		else{
			$Data = $Query->errorInfo();
			print_r($Data);
		}
	}

	if(isset($_GET['AddApplicant'])){
		$AppID = $Functions->PDO_IDGenerator('tbl_application','ApplicationID');
		$Data = $_POST['Data']; $State = "";
		$Date = date("n-j-Y");
		$Query = $Functions->PDO_SQLQuery("INSERT INTO tbl_application(ApplicationID,ScholarStudentID,ScholarScholarshipType,ScholarGrant,ScholarTuitionFee,ScholarMiscFee,ScholarGPA,ScholarYear,ApplicationDate) VALUES('$AppID','{$Data[0][1]}','{$Data[0][6]}','{$Data[0][7]}','{$Data[0][3]}','{$Data[0][4]}','{$Data[0][2]}','{$Data[0][5]}','{$Date}')");
		if($Query->execute())
			echo 1;
		else{
			$Data = $Query->errorInfo();
			print_r($Data);
		}
	}

    if(isset($_GET['GetStudent'])){
		if(!isset($_POST['Data']))
			$Category = 'Presidents Lister';
		else
			$Category = $_GET['Category'];

        $RetVal = '{"Academics":[';
        $Query = $Functions->PDO_SQL("SELECT * FROM tbl_scholars INNER JOIN tbl_scholaracademics ON tbl_scholars.ScholarID = tbl_scholaracademics.ScholarID WHERE tbl_scholaracademics.Active = '1'");
        foreach ($Query as $key => $value) {
            $Link = "<a href='#Grades#{$Query[$key][0]}' class='btn btn-sm btn-success'>Show Grades</a>";
            if(count($Query) == ($key+1))
                $RetVal .= '{"Grant":"'.$Query[$key][13].'","Scholarship":"'.$Query[$key][12].'","Picture":"<div class=\'ProfilePicture\'><div class=\'thumbnail\'><img src=\'Images/StudentProfile/'.$Query[$key][8].'\'></div></div>","DateOfBirth":"'.$Query[$key][7].'","Contact":"'.$Query[$key][6].'","Address":"'.$Query[$key][5].'","StudentID":"'.$Query[$key][0].'","Name":"'.$Query[$key][2].' '.$Query[$key][3].' '.$Query[$key][1].'<br/>'.$Query[$key][10].'","Course":"'.$Query[$key][11].'","Gender":"'.$Query[$key][4].'","Button":"'.$Link.'"}';
            else
                $RetVal .= '{"Grant":"'.$Query[$key][13].'","Scholarship":"'.$Query[$key][12].'","Picture":"<div class=\'ProfilePicture\'><div class=\'thumbnail\'><img src=\'Images/StudentProfile/'.$Query[$key][8].'\'></div></div>","DateOfBirth":"'.$Query[$key][7].'","Contact":"'.$Query[$key][6].'","Address":"'.$Query[$key][5].'","StudentID":"'.$Query[$key][0].'","Name":"'.$Query[$key][2].' '.$Query[$key][3].' '.$Query[$key][1].'<br/>'.$Query[$key][10].'","Course":"'.$Query[$key][11].'","Gender":"'.$Query[$key][4].'","Button":"'.$Link.'"},';
        }
        $RetVal .= "]}";
        echo $RetVal;
    }

    if(isset($_GET['FormStudentList'])){
	    echo '
	    <div class="panel-body">
            <table class="table table-striped" id="ScholarsList">
                <thead>
                    <th width="10%"></th>
                    <th width="40%">Name</th>
                    <th width="45">Course</th>
                    <th width="5%">Option</th>
                </thead>
            </table>
        </div>
	    ';
    }

    if(isset($_GET['FormMessageToAdmin'])){
	    echo '
	        <div id="StudentAccount"></div>
	        <div id="LogIn_Message" class="text-danger"></div>
	        <div class="row">
	            <div class="form-group col-xs-12 floating-label-form-group">
	                <label for="StudentID">Message header <span id="Message_Header"></span></label>
	                <input class="form-control" type="text" placeholder="" id="Form_Header">
	            </div>
	            <div class="form-group col-xs-12 floating-label-form-group">
	                <label for="Passcode">Message <span id="Message_Content"></span></label>
                    <textarea col="100" rows="5" value=" " placeholder="" class="form-control editor" id="Form_Content">
                    </textarea>
	            </div>
	        </div>
	        <button class="btn btn-sm btn-success disabled pull-right" id="submit_PostMessage">Post</button>
	    ';
    }

    if(isset($_GET['FormAdminPassword'])){
	    echo '
	    <div class="panel-body">
	        <div id="StudentAccount"></div>
	        <div id="LogIn_Message" class="text-danger"></div>
	        <div class="row">
	            <div class="form-group col-xs-12 floating-label-form-group">
	                <label for="StudentID">Old Password <span id="Message_PasswordOld"></span></label>
	                <input class="form-control" type="password" placeholder="Old Password" id="Password_Old">
	            </div>
	            <div class="form-group col-xs-12 floating-label-form-group">
	                <label for="Passcode">New password <span id="Message_New"></span></label>
	                <input class="form-control" type="password" placeholder="New password" id="Password_New">
	            </div>
	        </div>
	        <i><small><label><input type="checkbox" id="UserShowPassword"> show as text</label></small></i>
	        <button class="btn btn-sm btn-success disabled pull-right" id="submit_UpdatePassword">Change password</button>
	    </div>
	    ';
    }

    if(isset($_GET['FormMessageFromAdmin'])){
	    echo '
	        <div id="StudentAccount"></div>
	        <div id="LogIn_Message" class="text-danger"></div>
	        <div class="row">
	            <div class="form-group col-xs-12 floating-label-form-group">
	                <label for="StudentID">Message header <span id="Message_Header"></span></label>
	                <input class="form-control" type="text" placeholder="" id="Form_Header">
	            </div>
	            <div class="form-group col-xs-12 floating-label-form-group">
	                <label for="Passcode">Message <span id="Message_Content"></span></label>
                    <textarea col="100" rows="5" value=" " placeholder="" class="form-control editor" id="Form_Content">
                    </textarea>
	            </div>
	        </div>
	        <button class="btn btn-sm btn-success disabled pull-right" id="submit_PostMessage">Post</button>
	    ';
    }    
	
	if(isset($_GET['GetStudentID'])){
	    $Data = $_POST['Data'];
	    $Query = $Functions->PDO_SQL("SELECT * FROM tbl_members WHERE MembersStudentID = '$Data'");
	    if(count($Query) == 1){
	        echo "
	            <input type='text' value='{$Query[0][7]}}'>
	            <div class='alert alert-success'>
	                <div class='col-md-12'>  
	                    <div class='col-md-2 ProfilePicture_sq-md thumbnail'>
	                        <img src='../files/{$Query[0][7]}'/> 
	                    </div>
	                    <h5 class='col-md-10'>
	                        {$Query[0][3]} ".substr($Query[0][4],0,1).". {$Query[0][5]}<br/>
	                        {$Query[0][6]}
	                    </h5>
	                </div>
	                Is this the student account you want to change the password?
	            </div>
	        ";
	    }
	    else{
	        echo "
	            <div class='alert alert-danger'>
	                <i class='btn btn-xs btn-circle btn-danger disabled glyphicon glyphicon-exclamation-sign'></i> No student found.
	            </div>
	        ";
	    }
	}

	if(isset($_GET['AlphaNumeric'])){
	    $Data = $_POST['Data'];
	    if($Functions->AlphaNumeric($Data,50)!==1)
	        echo 1;
	    else
	        echo 0;
	}

	if(isset($_GET['AlphaNumericSpaceDash'])){
	    $Data = $_POST['Data'];
	    if($Functions->AlphaNumeric2($Data,50)!==1)
	        echo 1;
	    else
	        echo 0;
	}

	if(isset($_GET['ValidateName'])){
	    $Data = $_POST['Data'];
	    if($Functions->ValidateNames($Data)!==1)
	        echo 1;
	    else
	        echo 0;
	}

	if(isset($_GET['ValidateStudentID'])){
	    $Data = $_POST['Data'];
	    if($Functions->ValidationPSUStudentID($Data)!==1)
	        echo 1;
	    else
	        echo 0;
	}

	if(isset($_GET['CheckPassword'])){
	    $Data = $_POST['Data'];
	    $Data2 = sha1($_POST['Data2']);
	    $Query = $Functions->PDO_SQL("SELECT * FROM tbl_members WHERE MembersID = '$Data' AND MembersPassword = '$Data2'");
	    echo count($Query);
	}

	if(isset($_GET['ValidateForumCategory'])){
	    $Data = $_POST['Data'];
	    if($Functions->String($Data)!==1)
	        echo 1;
	    else
	        echo 0;
	} 

	if(isset($_GET['ValidateForumContent'])){
	    $Data = $_POST['Data'];
	    if(strlen($Data)<=1000)
	        echo 1;
	    else
	        echo 0;
	}

	if(isset($_GET['UpdatePasswordX'])){
	    $Data = $_POST['Data'];
	    $NewPassword = sha1($Data[1]);
	    $MemberID = $Data[0];

	    $Query = $Functions->PDO_SQLQuery("UPDATE tbl_members SET MembersPassword = '$NewPassword' WHERE MembersID = '$MemberID'");
	    if($Query->execute()){
	        echo 1;
	        $_SESSION['DataPass'] = $NewPassword;
	    }
	    else{
	        $Data = $Query->errorInfo();
	        echo "There was an error with your request. SQL says: {$Data[2]}";
	    }
	}

	if(isset($_GET['VerifyAdmin'])){
	    $Data = sha1($_POST['Data']);
	    $Query = $Functions->PDO_SQL("SELECT * FROM tbl_user WHERE UserPassword = '$Data'");
	    if(count($Query) == 0)
	        echo 1;
	    else
	        echo 0;
	}

	if(isset($_GET['UpdatePassword'])){
	    $Data = $_POST['Data'];
	    $NewPassword = sha1($Data[1]);
	    $OldPassword = sha1($Data[0]);

	    $Query = $Functions->PDO_SQLQuery("UPDATE tbl_user SET UserPassword = '$NewPassword' WHERE UserPassword = '$OldPassword'");
	    if($Query->execute()){
	        echo 1;
	        $_SESSION['DataPass'] = $NewPassword;
	    }
	    else{
	        $Data = $Query->errorInfo();
	        echo "There was an error with your request. SQL says: {$Data[2]}";
	    }
	}

	if(isset($_GET['AddAdmin'])){
	    $DataID = $Functions->PDO_IDGenerator('tbl_user','UserID');
	    $NewPassword = sha1("xxx");
	    $AdminName = "Rufo";
	    $AdminPosition = "Administrator";
	    $Query = $Functions->PDO_SQLQuery("INSERT INTO tbl_user(UserID,UserName,UserPassword,UserLevel) VALUES('$DataID','$AdminName','$NewPassword','$AdminPosition')");
	    if($Query->execute()){
	        echo 1;
	    }
	    else{ 
	        $Data = $Query->errorInfo();
	        echo "There was an error with your request. SQL says: {$Data[2]}";
	    }
	}

	if(isset($_GET['SendMessage'])){
	    $Data = $_POST['Data'];
	    $DataID = $Functions->PDO_IDGenerator('tbl_message','MessageID');
	    $DateNTime = date("F j, Y - g:i a");
	    $Header = $Functions->CharToCode($Data[0]);
	    $Content = $Functions->CharToCode($Data[1]);
	    $Receiver = $Functions->CharToCode($Data[2]);

	    $Query = $Functions->PDO_SQLQuery("INSERT INTO tbl_message(MessageID,MessageHeader,MessagerContent,MessageReceiver,MessageSent) VALUES('$DataID','$Header','$Content','$Receiver','$DateNTime')");
	    if($Query->execute()){
	        echo 1;
	    }
	    else{ 
	        $Data = $Query->errorInfo();
	        echo "There was an error with your request. SQL says: {$Data[2]}";
	    }
	}

    if(isset($_GET['Messages'])){
        $Query = $Functions->PDO_SQL("SELECT * FROM tbl_message ORDER BY MessageSent DESC");
        foreach ($Query as $key => $value) {
        	if($value[3] === 'Student'){
	        	echo "
					<div class='bs-callout bs-callout-info' id='callout-dropdown-positioning'>
                        <a href='#DM#{$value[0]}' class='glyphicon glyphicon-remove pull-right'></a>
					    <h3>{$Functions->Context(1000,$value[3])} <small>{$value[4]}</small></h3>
					    <h4>{$Functions->Context(1000,$value[1])}</h4>
					    <p>{$Functions->Context(1000,$value[2])}</p>
					</div>
		        ";
        	}
        	else{
	        	echo "
					<div class='bs-callout bs-callout-warning' id='callout-dropdown-positioning'>
                        <a href='#DM#{$value[0]}' class='glyphicon glyphicon-remove pull-right'></a>
					    <h3>{$Functions->Context(1000,$value[3])} <small>{$value[4]}</small></h3>
					    <h4>{$Functions->Context(1000,$value[1])}</h4>
					    <p>{$Functions->Context(1000,$value[2])}</p>
					</div>
		        ";
        	}

        }
    }	

    if(isset($_GET['GuestMessages'])){
        $Query = $Functions->PDO_SQL("SELECT * FROM tbl_message WHERE MessageReceiver = 'Student' ORDER BY MessageSent DESC");
        foreach ($Query as $key => $value) {
        	echo "
				<div class='bs-callout bs-callout-warning' id='callout-dropdown-positioning'>
				    <h3>{$Functions->Context(1000,$value[3])} <small>{$value[4]}</small></h3>
				    <h4>{$Functions->Context(1000,$value[1])}</h4>
				    <p>{$Functions->Context(1000,$value[2])}</p>
				</div>
	        ";
        }
    }	

	if(isset($_GET['DeleteThread'])){
	    $Data = $_POST['Data'];
	    $Query = $Functions->PDO_SQLQuery("DELETE FROM tbl_message WHERE MessageID = '$Data'");
	    if($Query->execute())
	        echo 1;
	    else{
	        $Data = $Query->errorInfo();
	        echo "There was an error with your request. SQL says: {$Data[2]}";
	    }
	}

	if(isset($_GET['MakeItActive'])){
	    $Data = $_POST['Data'];

	    $Query = $Functions->PDO_SQLQuery("UPDATE tbl_scholaracademics SET Active = '1' WHERE ScholarID = '$Data'");
	    if($Query->execute()){
	        echo 1;
	    }
	    else{
	        $Data = $Query->errorInfo();
	        echo "There was an error with your request. SQL says: {$Data[2]}";
	    }
	}

	if(isset($_GET['MakeItNotActive'])){
	    $Data = $_POST['Data'];

	    $Query = $Functions->PDO_SQLQuery("UPDATE tbl_scholaracademics SET Active = '0' WHERE ScholarID = '$Data'");
	    if($Query->execute()){
	        echo 1;
	    }
	    else{
	        $Data = $Query->errorInfo();
	        echo "There was an error with your request. SQL says: {$Data[2]}";
	    }
	}

    if(isset($_GET['GetStudentAdmin'])){
		if(!isset($_POST['Data']))
			$Category = 'Presidents Lister';
		else
			$Category = $_GET['Category'];

        $RetVal = '{"Academics":['; $class = '';
        $Query = $Functions->PDO_SQL("SELECT * FROM tbl_scholars INNER JOIN tbl_scholaracademics ON tbl_scholars.ScholarID = tbl_scholaracademics.ScholarID");
        foreach ($Query as $key => $value) {
        	if($Query[$key][14] == 1){
        		$class = "<small class='text-danger'>Active</small>";
	            $Options = "<div class='dropdown pull-right'><button class='btn btn-info btn-sm dropdown-toggle' type='button' id='dropdownMenu1' data-toggle='dropdown'><span class='glyphicon glyphicon-tasks'></span> Options</button><ul class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu1'><li role='presentation'><a role='menuitem' tabindex='-1' href='#Details={$value[0]}'><span class='glyphicon glyphicon-stats'></span> Details</a></li><li role='presentation'><a role='menuitem' tabindex='-1' href='#Delete={$value[0]}'><span class='glyphicon glyphicon-trash'></span> Delete</a></li><li role='presentation'><a role='menuitem' tabindex='-1' href='#Update={$value[0]}'><span class='glyphicon glyphicon-refresh'></span> Update</a></li><li role='presentation' class='divider'></li>'<li role='presentation' class='disabled'><a role='menuitem' tabindex='-1' href='#Active#{$value[0]}'><span class='glyphicon glyphicon-thumbs-up'></span> Active</a></li><li role='presentation'><a role='menuitem' tabindex='-1' href='#NotActive#{$value[0]}'><span class='glyphicon glyphicon-thumbs-down'></span> Not Active</a></li></ul></div>";
        	}
			else{
        		$class = "<small class='text-muted'>Not active</small>";
            	$Options = "<div class='dropdown pull-right'><button class='btn btn-info btn-sm dropdown-toggle' type='button' id='dropdownMenu1' data-toggle='dropdown'><span class='glyphicon glyphicon-tasks'></span> Options</button><ul class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu1'><li role='presentation'><a role='menuitem' tabindex='-1' href='#Details={$value[0]}'><span class='glyphicon glyphicon-stats'></span> Details</a></li><li role='presentation'><a role='menuitem' tabindex='-1' href='#Delete={$value[0]}'><span class='glyphicon glyphicon-trash'></span> Delete</a></li><li role='presentation'><a role='menuitem' tabindex='-1' href='#Update={$value[0]}'><span class='glyphicon glyphicon-refresh'></span> Update</a></li><li role='presentation' class='divider'></li>'<li role='presentation'><a role='menuitem' tabindex='-1' href='#Active#{$value[0]}'><span class='glyphicon glyphicon-thumbs-up'></span> Active</a></li><li role='presentation' class='disabled'><a role='menuitem' tabindex='-1' href='#NotActive#{$value[0]}'><span class='glyphicon glyphicon-thumbs-down'></span> Not Active</a></li></ul></div>";
			}

            if(count($Query) == ($key+1))
                $RetVal .= '{"Picture":"<div class=\'col-md-12 ProfilePicture\'><div class=\'thumbnail\'><img src=\'../Images/StudentProfile/'.$Query[$key][8].'\'></div></div>","Name":"'.$Query[$key][2].' '.$Query[$key][3].' '.$Query[$key][1].' '.$class.'<br/>'.$Query[$key][10].'","Course":"'.$Query[$key][17].'","Button":"'.$Options.'"}';
            else
                $RetVal .= '{"Picture":"<div class=\'col-md-12 ProfilePicture\'><div class=\'thumbnail\'><img src=\'../Images/StudentProfile/'.$Query[$key][8].'\'></div></div>","Name":"'.$Query[$key][2].' '.$Query[$key][3].' '.$Query[$key][1].' '.$class.'<br/>'.$Query[$key][10].'","Course":"'.$Query[$key][17].'","Button":"'.$Options.'"},';

//                $RetVal .= '{"Grant":"'.$Query[$key][13].'","Scholarship":"'.$Query[$key][12].'","Picture":"<div class=\'ProfilePicture\'><div class=\'thumbnail\'><img src=\'../Images/StudentProfile/'.$Query[$key][8].'\'></div></div>","DateOfBirth":"'.$Query[$key][7].'","Contact":"'.$Query[$key][6].'","Address":"'.$Query[$key][5].'","StudentID":"'.$Query[$key][0].'","Name":"'.$Query[$key][2].' '.$Query[$key][3].' '.$Query[$key][1].' '.$class.'<br/>'.$Query[$key][10].'","Course":"'.$Query[$key][11].'","Gender":"'.$Query[$key][4].'","Button":"'.$Options.'"}';
        }
        $RetVal .= "]}";
        echo $RetVal;
    }

    if(isset($_GET['Form_StudentAdd'])){
    	echo '
            <table border="0" class="panel-default table">
                <tr>
                    <td>
                        <h4>Personal Information</h4>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                Family Name: <span id="Message_ScholarFamilyName"></span>
                                <input type="text" class="form-control" id="ScholarFamilyName">
                            </div>
                            <div class="col-md-4">
                                First Name: <span id="Message_ScholarFirstName"></span>
                                <input type="text" class="form-control" id="ScholarFirstName">
                            </div>
                            <div class="col-md-4">
                                Middle Name: <span id="Message_ScholarMiddleName"></span>
                                <input type="text" class="form-control" id="ScholarMiddleName">
                            </div>

                            <div class="col-md-2">
                                Gender:<br/>
                                <select class="btn btn-default" id="ScholarGender">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                Civil Status:<br/>
                                <select class="btn btn-default" id="ScholarCivilStatus">
                                    <option>Single</option>
                                    <option>Maried</option>
                                    <option>Widowed</option>
                                    <option>Annuled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                Religion: </span> <span id="Message_ScholarReligion"></span>
                                <input type="text" class="form-control" id="ScholarReligion">
                            </div>

                            <div class="col-md-4">
                                Date of birth: <span id="Message_ScholarDOB"></span>
                                <input type="text" class="form-control" id="ScholarBirthDate"  data-mask="aaa-99-9999">
                            </div>

                            <div class="col-md-4">
                                Contact: <span id="Message_ScholarContact"></span>
                                <input type="text" class="form-control" id="ScholarContact">
                            </div>

                            <div class="col-lg-8">
                                Address:  <span id="Message_ScholarAddress"></span>
                                <input type="text" class="form-control" id="ScholarAddress">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-lg-4">
                                No. of children in the family(include yourself):  <span id="Message_ScholarFamilyNumber"></span>
                                <input type="text" class="form-control" id="ScholarFamilyNumber" data-mask="9?9">
                            </div>  

                            <div class="col-lg-2">
                                Birth order:  <span id="Message_ScholarBirthOrder"></span>
                                <input type="text" class="form-control" id="ScholarBirthOrder" data-mask="9?9">
                            </div>                                    
                        </div>

                        <div class="col-md-12">Name of parents:</div>
                        <div class="col-md-12">
                            <div class="col-lg-6">
                                Father:  <span id="Message_ScholarFather"></span>
                                <input type="text" class="form-control" id="ScholarFather">
                            </div>

                            <div class="col-lg-6">
                                Occupation:  <span id="Message_ScholarFatherOccupation"></span>
                                <input type="text" class="form-control" id="ScholarFatherOccupation">
                            </div>

                            <div class="col-lg-6">
                                Educational attainement:  <span id="Message_ScholarFatherEduc"></span>
                                <input type="text" class="form-control" id="ScholarFatherEduc">
                            </div>

                            <div class="col-lg-2">
                                Age:  <span id="Message_ScholarFatherAge"></span>
                                <input type="text" class="form-control" id="ScholarFatherAge" data-mask="99">
                            </div>                                            

                            <div class="col-lg-6">
                                Mother:  <span id="Message_ScholarMother"></span>
                                <input type="text" class="form-control" id="ScholarMother">
                            </div>

                            <div class="col-lg-6">
                                Occupation:  <span id="Message_ScholarMotherOccupation"></span>
                                <input type="text" class="form-control" id="ScholarMotherOccupation">
                            </div>

                            <div class="col-lg-6">
                                Educational attainement:  <span id="Message_ScholarMotherEduc"></span>
                                <input type="text" class="form-control" id="ScholarMotherEduc">
                            </div>

                            <div class="col-lg-2">
                                Age:  <span id="Message_ScholarMotherAge"></span>
                                <input type="text" class="form-control" id="ScholarMotherAge" data-mask="99">
                            </div>                                            
                        </div>

                        <div class="col-md-12">Optional</div>

                        <div class="col-md-12">
                            <div class="col-lg-6">
                                Boarding house:  <span id="Message_ScholarBoardingHouse"></span>
                                <input type="text" class="form-control" id="ScholarBoardingHouse">
                            </div>

                            <div class="col-lg-6">
                                Landlord/Landlady:  <span id="Message_ScholarBoardingHouseOwner"></span>
                                <input type="text" class="form-control" id="ScholarBoardingHouseOwner">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Academic Information</h4>
                        <div class="col-md-12">
                            <div class="col-lg-2">
                                Student ID: <span id="Message_ScholarStudentID"></span>
                                <input type="text" class="form-control disabled" id="ScholarID">
                            </div> 
                            <div class="col-lg-6">
                                Course:
                                <select class="form-control" id="ScholarCourse">';
                                        $Data = $Functions->PSU_COURSES();
                                        foreach ($Data as $key => $Courses) {
                                            echo '<option>'.$Courses.'</option>';
                                        }
	    echo '
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
    	';
	}

    if(isset($_GET['Form_SholarshipApplication'])){
    	echo '
            <table border="0" class="panel-default table">
                <tr>
                    <td>
                        <h4>Applicant\'s Information</h4>
                        <div class="col-md-12">
                            <div class="col-lg-2">
                                Student ID: <span id="Message_ScholarStudentID"></span>
                                <input type="text" class="form-control" id="ScholarID">
                            </div> 
	                        <div id="Info_StudentData">
	                        </div> 
                        </div> 
                        <h4>Academic Information</h4>
                        <div class="col-md-12">
                            <div class="col-lg-2">
                                GPA: <span id="Message_ScholarGPA"></span>
                                <input type="text" class="form-control" id="ScholarGPA">
                            </div> 
                            <div class="col-lg-2">
                                Year: <span id="Message_ScholarYear"></span><br/>
                                <select class="btn btn-default" id="ScholarYear">
                                    <option>1st year</option>
                                    <option>2nd year</option>
                                    <option>3rd year</option>
                                    <option>4th year</option>
                                </select>
                            </div>                                                            
                        </div>
                        <div class="col-md-12">
                            <div class="col-lg-6">
                                Type of scholarship Grant:
                                <select class="form-control" id="ScholarType">';
                                        $Data = $Functions->PSU_ScholarType();
                                        foreach ($Data as $key => $Types) {
                                            echo '<option>'.$Types.'</option>';
                                        }
	    echo '
                                </select>
                            </div>
                            <div class="col-lg-6">
                                Grants/Benefits:
                                <select class="form-control" id="ScholarBenefits">
	                                <option>Full tuition and miscellaneous waiver</option>
	                                <option>Full tuition waiver only</option>
	                                <option>Full tuition, miscellaneous waiver and monthly stipend</option>
	                                <option>Full tuition, miscellaneous waiver, monthly stipend and book</option>
	                                <option>Allowance</option>
	                                <option>Half tuition waiver only</option>
	                                <option>Half tuition and miscellaneous waiver</option>
	                                <option>Half tuition and monthly allowance</option>
	                                <option>Others</option>
                                </select>
                            </div>  
                        </div>
                        <div class="col-md-12">
                            <div class="col-lg-3">
                                Tuition Fees: <span id="Message_ScholarTuition"></span>
                                <div class="input-group">
                                    <span class="input-group-addon">Php</span>
                                    <input type="text" class="form-control" id="ScholarTuition" value="0">
                                </div>
                            </div>                                                            

                            <div class="col-lg-3">
                                Miscellaneous Fees: <span id="Message_ScholarMiscellaneous"></span>
                                <div class="input-group">
                                    <span class="input-group-addon">Php</span>
                                    <input type="text" class="form-control" id="ScholarMiscellaneous" value="0">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                Total:
                                <div class="input-group disabled">
                                    <span class="input-group-addon">Php</span>
                                    <input type="button" class="form-control disabled" id="ScholarTotalFee" value="0">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
    	';
	}

    if(isset($_GET['GetReport'])){
        $Data = $Functions->PSU_ScholarType();
        $Date = date("n-j-Y");

        $Q = $Functions->PDO_SQL("SELECT DISTINCT ScholarScholarshipType FROM tbl_application");
        foreach ($Q as $i => $data) {
            $Q2 = $Functions->PDO_SQL("SELECT * FROM tbl_application WHERE ScholarScholarshipType = '{$data[0]}'");
            echo "
                <div class='panel-group' id='accordion'>
					<div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse_{$i}' class='collapsed'>{$data[0]}</a></h4>
                        </div>
	                    <div id='collapse_{$i}' class='panel-collapse collapse'>
		                    <table class='table'>
		                		<tr>
		                			<th>Name of scholar</th><th>Year and course</th><th>GPA</th><th>Free tuition fee</th>
		                		</tr>
					            ";
					            foreach ($Q2 as $a => $data2) {
					                if(($Functions->SemReader($data2[8]) == $Functions->SemReader($Date)) && ($Functions->SemesterYearReader($data2[8]) == $Functions->SemesterYearReader($Date))){
									    $Q3 = $Functions->PDO_SQL("SELECT * FROM tbl_scholars INNER JOIN tbl_scholaracademics ON tbl_scholars.ScholarID = tbl_scholaracademics.ScholarID WHERE tbl_scholaracademics.ScholarStudentID = '{$data2[1]}'");
								        $Q4 = $Functions->PDO_SQL("SELECT * FROM tbl_scholaracademics INNER JOIN tbl_application ON tbl_scholaracademics.ScholarStudentID = tbl_application.ScholarStudentID WHERE  tbl_scholaracademics.ScholarStudentID = '{$data2[1]}'");
					                	echo "
					                		<tr>
					                			<td>{$Q3[0][1]}, {$Q3[0][2]} {$Q3[0][3]}</td><td>{$Q4[0][11]} - {$Q3[0][17]}</td><td>{$Q4[0][10]}</td><td>{$Q4[0][8]}</td>
					                		</tr>
					                	";
					                }
					            }
					            echo "
		                    </table>
	                    </div>
	                </div>
                </div>
            ";
        }
    }    

?>