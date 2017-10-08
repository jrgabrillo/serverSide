<?php
include("../PhpFiles2/Functions.php"); 
include("Functions.php");
$Functions = new FunctionsExt;
$Functions2 = new DatabaseClasses;
session_start();


if(isset($_GET['NewStudent'])){
    $Month = array('January','February','March','April','May','June','July','August','September','October','November','December');
    echo '    
        <table class="table" id="NewCrossEnrolleeTransfereeStudent" width="95%" align="center">
            <tr>
                <td colspan="4">
                    <h5>Student picture(Optional)<br/><span id="ErrorStudentPicture"></span></h5>
                    <div class="form-group col-xs-12 floating-label-form-group text-left">
                        <div id="uploads" class="uploads"></div>
                        <form action="../PhpFiles/Upload.php" method="post" enctype="multipart/form-data" id="upload">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="bar ImageLoader">
                                    <span class="bar-fill-text" id="pt"></span>
                                </div>
                                <div class="fileinput-preview thumbnail FileInput" data-trigger="fileinput">
                                    Upload new picture
                                </div>
                                <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="file" id="file" required>
                                    </span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput" id="RemovePicture">Remove</a>
                                </div> 
                            </div>                                 
                        </form>                                    
                    </div>
                </td>
            </tr>
            <tr>
                <td width="33%">
                    <h5>(Surname) <span id="ErrorStudentFamilyName"></span></h5>
                    <input type="text" name="StudentSurName" class="form-control" placeholder="Family Name" id="StudentFamilyName">
                </td>
                <td width="33%" colspan="2">
                    <h5>(Given Name) <span id="ErrorStudentGivenName"></span></h5>
                    <input type="text" name="StudentGivenName" class="form-control" placeholder="Given Name" id="StudentGivenName">
                </td>
                <td width="33%">
                    <h5>(Middle Name) <span id="ErrorStudentMiddleName"></span></h5>
                    <input type="text" name="StudentMiddleName" class="form-control" placeholder="Middle Name" id="StudentMiddleName">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="col-md-12">Date of birth:</div>
                    <div class="col-md-3">
                        <select class="form-control" id="StudentBirthMonth">
                        ';
                        foreach ($Month as $key => $value){
                            echo "<option>{$value}</option>";
                        }
                        echo '
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="StudentBirthDay">
                        ';
                        for($x=1;$x<32;$x++){
                            echo "<option>{$x}</option>";
                        }
                        echo '
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="StudentBirthYear">
                        ';
                        for($x=1950;$x<2000;$x++){
                            echo "<option>{$x}</option>";
                        }
                        echo '
                        </select>
                    </div>
                </td>
                <td>
                    <div class="col-md-6">
                        Gender
                        <select id="StudentGender" name="StudentGender" class="form-control">
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        Civil Status
                        <select id="StudentCivilStatus" name="StudentStatus" class="form-control">
                            <option>Single</option>
                            <option>Married</option>
                            <option>Widowed</option>
                            <option>Annulled</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h5>Contact No. <span id="ErrorStudentMobileNumber"></span></h5>
                    <input type="text" name="StudentContact" class="form-control" placeholder="Mobile Number" id="StudentMobileNumber"/>
                </td>
                <td colspan="3">
                    <h5>Address <span id="ErrorStudentAddress"></span></h5>
                    <input type="text" name="StudentAddress" class="form-control" placeholder="Address" id="StudentAddress">
                </td>
            </tr>
            <tr>
                <td>
                    <h5>Email <span id="ErrorStudentEmailAddress"></span></h5>
                    <input type="text" name="StudentEmail" class="form-control" placeholder="Email Address" id="StudentEmailAddress">
                </td>
                <td colspan="2">
                    <h5>Guardian <span id="ErrorStudentGuardian"></span></h5>
                    <input type="text" name="StudentGuardian" class="form-control" placeholder="Guardian" id="StudentGuardian">
                </td>
                <td>
                    <h5>Guardian\'s Contact No. <span id="ErrorStudentGuardianContactNumber"></span></h5>
                    <input type="text" name="StudentGuardianContact" class="form-control" placeholder="Guardian\'s Contact Number" id="StudentGuardianContactNumber">
                </td>
            </tr>
            <tr>
                <td colspan="1">
                    <h5>Year Graduated</h5>
                        <select class="form-control" id="StudentYearGraduated">
                        ';
                        for($x=1970;$x<=date('Y');$x++) {
                            echo "<option>{$x}</option>";
                        }
                        echo '
                        </select>
                </td>
                <td colspan="3">
                    <h5>Course Graduated <span id="ErrorStudentCourseGraduated"></span></h5>
                    <input type="text" name="StudentCourseGraduated" class="form-control" placeholder="Course Graduated" id="StudentCourseGraduated"/>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="right">
                    <div id="counter"></div><br/><br/>
                    <input type="submit" value="Save" id="AddMe" class="btn btn-sm btn-success disabledx"/>
                    <br/><br/>
                </td>
            </tr>
        </table>
    ';
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

if(isset($_GET['TestFile'])){
    header('Content-Type:application/json');
    $uploaded = array();
    $succeeded = array();
    $failed = array();
    $allowed = ['jpg','jpeg','png','gif'];

    if(!empty($_FILES['file'])){
        $name = $_FILES['file']['name'];
        if($_FILES['file']['error'] == 0){
            $temp = $_FILES['file']['tmp_name'];
            $ext = explode('.',$name);
            $ext = strtolower(end($ext));
            $file = sha1($temp)."-{time()}.{$ext}";
            $succeeded[] = array(
                'name' => $name,
                'file' => $file,
            );
        }
        else{
            $failed[] = array(
                'name' => $name,
            );
        }

        if(!empty($_POST['ajax'])){
            echo json_encode(array(
                'succeeded' => $succeeded,
                'failed' => $failed
            ));
        }
    }
    else{
        $failed[] = array(
            "Unable to upload the file."
        );
        echo json_encode(array(
            'succeeded' => $succeeded,
            'failed' => $failed
        ));
    }
}

if(isset($_GET['AddMe'])){
    $Data = $_POST['Data'];
    $CapitalizedProgram = $Functions2->Capitalize($Data[0][16]);

    if($Data[0][0] == "" || $Data[0][0] == "DefaultID")
        $StudentIDNumber = $Functions2->OUSStudentIDNumberGenerator();   
    else                
        $StudentIDNumber = $Data[0][0];   

    $ProfilePicture = $Data[0][15];
    if(empty($ProfilePicture))
        $ProfilePicture = "Default.png";

    $ID1 = $Functions->IDGenerator('students','StudentID');
    $ID2 = $Functions->IDGenerator('studentscourse','StudentCourseID');
    $Q1 = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$StudentIDNumber}'");
    $Q2 = $Functions2->PDO_SQL("SELECT * FROM studentscourse WHERE StudentIDNumber = '{$StudentIDNumber}'");
    $InsertQuery1 = "INSERT INTO students(StudentID,StudentIDNumber,StudentDateOfBirth,StudentSurname,StudentFirstName,StudentMiddleName,StudentMobileNumber,StudentAddress,StudentGuardian,StudentGuardianMobileNumber,StudentGender,StudentCivilStatus,StudentEmail,StudentPicture) VALUES('{$ID1}','{$StudentIDNumber}','{$Data[0][1]}','{$Data[0][2]}','{$Data[0][3]}','{$Data[0][4]}','{$Data[0][5]}','{$Data[0][6]}','{$Data[0][8]}','{$Data[0][9]}','{$Data[0][12]}','{$Data[0][11]}','{$Data[0][7]}','{$ProfilePicture}')";
    $InsertQuery2 = "INSERT INTO studentscourse(StudentCourseID,StudentProgram,StudentIDNumber,StudentType,StudentCourseGraduated,DateUnderGrad,StudentCategory) VALUES('{$ID2}','{$CapitalizedProgram}','{$Data[0][0]}','{$Data[0][14]}','{$Data[0][10]}','{$Data[0][13]}','{$Data[0][17]}')";
    if((count($Q1)==0)&&(count($Q2)==0)){
        $Query1 = $Functions2->PDO_SQLQuery($InsertQuery1); $Query2 = $Functions2->PDO_SQLQuery($InsertQuery2);
        if($Query1->execute()&&$Query2->execute()){
            echo "1<x>{$StudentIDNumber}";
        }
        else{
            $Data = $Query->errorInfo();
            echo "There was an error with your request. SQL says: {$Data[2]}";
        }
    }
    else{
        echo "There was an error with your request.";
    }
}
?>