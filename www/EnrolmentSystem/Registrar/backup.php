<?php
session_start();
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
if(!isset($_SESSION['Username']) && !isset($_SESSION['Password'])){ header("Location:../"); }
$Month = array("JANUARY","FEBRUARY","MARCH","APRIL","MAY","JUNE","JULY","AUGUST","SEPTEMBER","OCTOBER","NOVEMBER","DECEMBER");
$Error = ''; $CourseTitle = @$_SESSION['Session'];
$Functions = new Functions;
if(isset($_GET['LogOut'])){
	session_destroy();
	header("Location:../");
}
if(isset($_POST['FileUpload'])){
	$ImageName = $_FILES['FilePicture']['name'];
	$ImageLocation = $_FILES['FilePicture']['tmp_name'];
	$ImageType = $_FILES['FilePicture']['type'];
	$ImageSize = $_FILES['FilePicture']['size'];
	$ImageError = $_FILES['FilePicture']['error'];
	$StudentID = $_SESSION['StudentID'];
	$Program = $_SESSION['Program'];
	@$_SESSION['SessionChecker'];
	list($width, $height) = @getimagesize($ImageLocation);
	//rename("../StudentsPicture/x.png","../StudentsPicture/gabrillo.png");
	if(!empty($ImageName)){
		if($ImageError == 0){
			if($ImageSize < 2000000){
				if(($ImageType != 'image/jpg') && ($ImageType != 'image/jpeg') && ($ImageType != 'image/png') && ($ImageType != 'image/gif'))
					$Error = 'Invalid file type';
				else
					if(move_uploaded_file($_FILES['FilePicture']['tmp_name'],'../StudentsPicture/'.$_FILES['FilePicture']['name'])){
						$Query = mysql_query("UPDATE students SET StudentPicture = '$ImageName' WHERE StudentID = '$StudentID'");
						$Error = NULL; $_SESSION['StudentID'] = ""; $_SESSION['AddStudent'] = 'OFF';
						header("Location:?KeyD=".$StudentID."&KeyType=".$_SESSION['KeyType']);
					}
			}
			else
				$Error = 'File too large.';
		}
		else
			$Error = 'File is corrupted.';
	}
	else{
		$Error = 'Choose an Image then hit Done again.';
	}
}	
if(isset($_POST['FileSkip'])){
	$ImageName = "Default.png";
	$Program = $_SESSION['Program'];
	$StudentID = $_SESSION['StudentIDNumberInSession'];
	if(mysql_query("UPDATE students SET StudentPicture = '$ImageName' WHERE StudentID = '$StudentID'")){
		header("Location:?KeyD=".$StudentID."&KeyType=".$_SESSION['KeyType']);
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>REGISTRAR</title>
    <link rel="stylesheet" href="../CSS/General.css" type="text/css">
    <link rel="stylesheet" href="../CSS/Registrar.css" type="text/css">
    <link rel="icon" href="../Images/GSLOGO.png">
    <script type="text/javascript" src="../JQuery/JQuery.js"></script>
    <script type="text/javascript" src="../JQuery/JS.js"></script></head>
    <script type="text/javascript" src="../JQuery/Chart.js-master/Chart.js"></script>
    <script type="text/javascript" src="../JQuery/Registrar.js"></script>
    <script type="text/javascript" src="../BOOTSTRAP/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap-theme.css" type="text/css">
</head>


<body>
	<input type="hidden" value="<?php echo @$_SESSION['AddStudent']; ?>" id="AddStudentSessionChecker"/>
    <div id="PopUpShade">
        	<div id="PopUpMessageContent">
                <table border="0" width="90%" align="center">
                    <tr>
                        <td>
                            <span id="PopUpMessage"></span>
							<span id="PopUpTitleDialog"></span>
                            <div id="PopUpInputDialog">
                               	<strong><span id="PopUpTitleX"></span></strong><span id="PopUpInputMessageX"></span><br/>
                                <input type="text" id="PopUpInput" maxlength="6"/>
                                <input type="button" value="Ok" id="PopUpSubmit"/>
                                <input type="button" value="Cancel" id="PopUpCancel"/>
                            </div>
                            <div id="PopUpConfirmDialog">
                            	<input type="hidden" id="HiddenConfirmValue">
                            	<input type="button" value="Ok" id="OK_BTN"/>
                                <input type="button" value="Cancel" id="CANCEL_BTN"/>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
    </div>

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://localhost/EnrolmentSystem/Registrar/">Registrar</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><div class="navbar-brand" id="Timely"></div></li>
            </ul>
            </div>
        </div><!-- /.container-fluid -->
    </nav>
    
    <div id="Container">
        <div id="LeftNav">

	<ul class="nav navbar-default list-group">
        <li>
            <button type="button" class="list-group-item btn btn-info dropdown-toggle" data-toggle="dropdown">
                Enrol <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="AddDoctoral"><a href="?Doctoral">Doctoral</a></li>
                <li id="AddMasteral"><a href="?Masteral">Masteral</a></li>
            </ul>
        </li>  
        <li>
            <button type="button" class="list-group-item btn btn-info dropdown-toggle" data-toggle="dropdown">
                Student Info <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="Doctoral"><a href="?ProgramView=Doctoral">Doctoral</a></li>
                <li id="Masteral"><a href="?ProgramView=Masteral">Masteral</a></li>
            </ul>                
        </li>  
        <li>
            <button type="button" class="list-group-item btn btn-info dropdown-toggle" data-toggle="dropdown">
                Report Generation <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                Chart
                <li><a href="?ChartCourse">Course</a></li>
                <li><a href="?ChartYear">Year</a></li>
                <li><a href="?ChartSemester">Semester</a></li>
                <li class="divider"></li>
                List
                <li><a href="?ListCourse">Course</a></li>
                <li><a href="?ListYear">Year</a></li>
                <li><a href="?ListSemester">Semester</a></li>
                <li><a href="?ListSubject">Subject</a></li>
            </ul>                
        </li>  
        <li><button id="BackupDBX" class="list-group-item btn btn-info">Back up Database</button></li>
        <a href="?FacultyLoading"><button class="list-group-item btn btn-info">Faculty Loading</button></a>
        <a href="?AddCourse"><button class="list-group-item btn btn-info">Add Course</button></a>
        <a href="?LogOut"><button class="list-group-item btn btn-info">Log Out</button></a>
    </ul>
        </div>
        <div id="Content">
            <div id="RegistrarContent">
            	<!-- <div id="StudentsProgram"></div> -->
                <div id="DataContainer">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Hello world</h3>
                        </div>
                        <div class="panel-body">
                            Panel content
                        </div>
                    </div>        
                	<?php
                    	if(isset($_GET['FacultyLoading'])){
					?>
                        <div id="FacultyLoadingList" class="White Box-shadow">
                        
                        
                            <table border="0" width="100%" align="center"><tr><td><div class="Locator">Faculty Loading &nbsp; > &nbsp; <span>Professor List</span></div></td></tr></td></tr></table>
                            
                            		
                        <?php
                            $Query = mysql_query("SELECT * FROM faculty");
                            echo '<table border="0" width="100%" align="center" class="FacultyChoices">';
                            $Count = 0;
                            while($Row = mysql_fetch_assoc($Query)){
                                $TNO = $Row['TNO']; $SubjectNumber = $Row['SubjectNumber'];
                                $Data = $Functions->SelectOne("courses","CourseNumber","$SubjectNumber");
                                echo '<tr><td width="30%">'.($Count+1).'.&nbsp;'.$Row['ProfessorName'].' <span class="FacultyLoad" id="F'.$Count.'">Load</span><span class="FacultySubject" id="FLoaded'.$Count.'">'.$Data[1].': '.$Data[2].'</span>';
                                    $Courses = $Functions->Courses2();
                                    echo '<span class="Hidden" id="'.$Count.'" ><div id="FacultyCourse"><select id="FacultyCourse'.$Count.'"><option>Course</option>';
                                        for($x=0;$x < count($Courses);$x++){
                                            echo '<option>'.$Courses[$x].'</option>';
                                        }
                                    echo '</select></div>';
    
                                    echo '&nbsp;<input type="hidden" value="'.$TNO.'" id="FacultyID'.$Count.'">
                                    <div class="FacultyList" id="FacultyList'.$Count.'"><select><option>Subject</option></select></div>
                                    <div><button id="FacultySureLoad">Load</button><button id="FacultyCancelLoad">Cancel</button></div></span>';
    
                                echo '</td></tr>';
                                $Count++;
                            }
                            echo '</table>';
                        ?>
                        </div>
                	<?php
						}
					?>
                	<span id="StudentsList">
                    	<?php
							if(isset($_GET['ProgramView'])){
								echo '
								<table border="0" width="100%" align="center" class="Graph">
									<tr><td><div class="Title">Student Information</div></td></tr>
									<tr><td><div class="Locator">STUDENT INFO &nbsp; > &nbsp;  <span id="StudentView">'.$_GET['ProgramView'].'</span></div></td></tr>
								</table>
								';
								if($_GET['ProgramView'] == "Doctoral"){
									echo '<table border="0" width="90%" align="center" id="ViewDoctoral" class="Box-shadow"><tr><td>';
								
									$Data = $Functions->Students("DOCTORAL");
									for($x=0;$x<count($Data);$x++){
										$Query = mysql_query("SELECT * FROM students WHERE StudentID = '$Data[$x]'");
										while($Row = mysql_fetch_assoc($Query)){
											echo '
												<ul id="SInfo" class="SInfo">
													<img src="../StudentsPicture/'.$Row['StudentPicture'].'" draggable="false"/>
													<li><div class="SN">'.$Row['StudentSurname'].', '.$Row['StudentFirstName'].' '.$Row['StudentMiddleName'].'<br/> <span class="KeyID">'.$Row['StudentIDNumber'].'</span></li>
												</ul>
											';
										}
									}
									echo '</td></tr></table>';
								}
								else if($_GET['ProgramView'] == "Masteral"){
									echo '<table border="0" width="90%" align="center" id="ViewMasteral" class="Box-shadow"><tr><td>';
									$Data = $Functions->Students("MASTERAL");
									for($x=0;$x<count($Data);$x++){
										$Query = mysql_query("SELECT * FROM students WHERE StudentID = '$Data[$x]'");
										while($Row = mysql_fetch_assoc($Query)){
											echo '
												<ul id="SInfo" class="SInfo">
													<img src="../StudentsPicture/'.$Row['StudentPicture'].'" draggable="false"/>
													<li><div class="SN">'.$Row['StudentSurname'].', '.$Row['StudentFirstName'].' '.$Row['StudentMiddleName'].'<br/> <span class="KeyID">'.$Row['StudentIDNumber'].'</span></div></li>
												</ul>
											';
										}
									}
									echo '</td></tr></table>';
								}
							}
							
							if(isset($_GET['KeyD'])){
								echo '
									<table border="0" width="100%" align="center" class="Graph"><tr><td><div class="Title">Finishing Enrollment</div></td></tr></td></tr></table>
								';
								if($_GET['KeyType'] == 'Transferee' || $_GET['KeyType'] == 'CrossEnrollee')
									$Functions->CrossEnrolleAndTransferee($_GET['KeyD']);
								else
									$Functions->OldStudent($_GET['KeyD']);
							}
						?>
                    <div id="StudentInformation">
                    </div>
                    </span>
                    
                    <div id="PrintableUnits"></div>
                    <div id="PrintableGrades"></div>
                    <div id="PrintableGoodMoral"></div>
                    <div id="PrintableOTR"></div>
                    
                    <div id="Registration" class="Box-shadow White">
                        <div id="ReportGenerationx">
							<?php
                            if(isset($_GET['ChartSemester'])){
                            ?>
                                <div class="Graph">
                                    <div class="Title">Students per Semester:</div><br/>
                                    <table border="0" width="100%">
                                    	<tr>
                                        	<td rowspan="6" colspan="2">
                                                <canvas id="Chart1" width="500px" height="500px"></canvas>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2" height="20px" width="40%"><div class="Legends"><strong>Legend:</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="20px"><div class="DataMarker" id="Data1Marker1"></div>Masteral Students</td><td align="center"><span id="Chart1Data1"><?php echo $Functions->TableCounter2("studentscourse","StudentProgram","MASTERAL"); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td height="20px"><div class="DataMarker" id="Data1Marker2"></div>Doctoral Students</td><td align="center"><span id="Chart1Data2"><?php echo $Functions->TableCounter2("studentscourse","StudentProgram","DOCTORAL"); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" align="right">Total&emsp;</td><td align="center" width="20px"><span id="Chart1Data2"><?php echo $Functions->TableCounter2("studentscourse","StudentProgram","MASTERAL")+$Functions->TableCounter2("studentscourse","StudentProgram","DOCTORAL"); ?></span></td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2">
                                            </td>
                                        </tr>
                                    </table>
                                    </div><br/>
                                </div>                            
							<?php
                            }
                            ?>
							<?php
                            if(isset($_GET['ChartCourse'])){
                            ?>
                                <div class="Graph">
                                    <div class="Title">Students per Course:</div><br/>
                                    <table border="" width="100%">
                                        <tr>
                                            <td rowspan="2"><canvas id="Chart2A" width="500px" height="500px"></canvas></td>
                                            <td height="50px;">
                                            	<table width="100%" border="0">
                                                    <tr><td colspan="2"><strong>Legend to Masteral's Data</strong></td></tr>
                                                    <?php
                                                        $StudentCount = 0;
                                                        $Data = $Functions->ReportCourse("MASTERAL");
                                                        for($x=0;$x<count($Data[0]);$x++){
                                                            $StudentCount += $Data[1][$x];
                                                            echo '<tr><td><div class="DataMarker" id="DataMarker'.$x.'"></div>'.$Data[0][$x].'</td><td align="center" width="50px;"><span id="ChartMasteral'.$x.'">'.$Data[1][$x].'</span></td></tr>';
                                                        }
                                                        echo '<input type="hidden" value="'.$x.'" id="Chart2Data1"/>';
                                                    ?>
                                                    <tr><td align="right">Total&emsp;</td><td align="center"><span id="Chart2DataTotal1"><?php echo $StudentCount; ?></span></td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td></td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2"><hr/></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2"><canvas id="Chart2B" width="500px" height="500px"></canvas></td>
                                            <td height="50px">
                                            	<table width="100%" border="0">
                                                    <tr><td colspan="2"><strong>Legend to Doctoral's Data</strong></td></tr>
                                                    <?php
                                                        $Data = $Functions->ReportCourse("DOCTORAL");
														$StudentCount = 0;
                                                        for($x=0;$x<count($Data[0]);$x++){
                                                            $StudentCount += $Data[1][$x];
                                                            echo '<tr><td><div class="DataMarker" id="DataMarker2'.$x.'"></div>'.$Data[0][$x].'</td><td align="center" width="50px;"><span id="ChartDoctoral'.$x.'">'.$Data[1][$x].'</span></td></tr>';
                                                        }
                                                        echo '<input type="hidden" value="'.$x.'" id="Chart2Data2"/>';
                                                    ?>
                                                    <tr><td align="right">Total&emsp;</td><td align="center"><span id="Chart2DataTotal2"><?php echo $StudentCount; ?></span></td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>
                                            </td>
                                        </tr>
                                    </table>
                                </div>                            
							<?php
                            }
                            ?>
							<?php
                            if(isset($_GET['ChartYear'])){
                            ?>
                                <div class="Graph">
                                    <div class="Title">Students per Year:</div><br/>
                                    <table border="" width="100%">
                                        <tr>
                                            <td width="50%" rowspan="2"><canvas id="Chart3A" width="500px" height="500px"></canvas></td>
                                            <td height="20px">
                                                <div class="Legends"><strong>Legends:</strong></div>
                                                <?php
													$Data = $Functions->ReportSem();
                                                ?>
                                                <table border="0" width="100%" cellspacing="0" id="Course">
                                                    <tr>
                                                        <td>First Semester</td><td width="50px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&emsp;<div class="DataMarker" id="Data3Marker1"></div>Masteral</td><td align="center"><span id="Chart3Data1"><?php echo $Data[0][0]*1; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&emsp;<div class="DataMarker" id="Data3Marker2"></div>Doctoral</td><td align="center"><span id="Chart3Data2"><?php echo $Data[0][1]*1; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Total&emsp;</td><td align="center"><span id="Chart3DataTotal1"><?php echo $Data[0][0]+$Data[0][1]; ?></span></td>
                                                    </tr>
                                                </table>                                    
                                            </td>
                                        </tr>
                                        <tr><td></td></tr>
                                        <tr><td colspan="2"><hr/></td></tr>
                                        <tr>
                                            <td rowspan="2"><canvas id="Chart3B" width="500px" height="500px"></canvas></td>
                                            <td height="20px">
                                                <div class="Legends"><strong>Legends:</strong></div>
                                                <?php
                                                $Data = $Functions->ReportSem();
                                                ?>
                                                <table border="0" width="100%" cellspacing="0" id="Course">
                                                    <td>Second Semester</td><td width="50px"></td>
                                                </tr>
                                                <tr>
                                                    <td>&emsp;<div class="DataMarker" id="Data3Marker3"></div>Masteral</td><td align="center"><span id="Chart3Data3"><?php echo @$Data[1][0]*1; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>&emsp;<div class="DataMarker" id="Data3Marker4"></div>Doctoral</td><td align="center"><span id="Chart3Data4"><?php echo @$Data[1][1]*1; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Total&emsp;</td><td align="center"><span id="Chart3DataTotal2"><?php echo @$Data[1][0]+@$Data[1][1]; ?></span></td>
                                                </tr>
                                                </table>                                    
                                            </td>
                                        </tr>
                                        <tr><td></td></tr>
                                    </table>
                                </div>                            
							<?php
                            }
                            ?>
							<?php
                            if(isset($_GET['ListSemester'])){
                            ?>
                                <div class="Graph">
                                    <div class="Title">Students per Semester:</div><br/>
                                    <div class="Legends"><strong>Legend:</strong><br/><br/>
                                    <table border="0" width="100%">
                                        <tr>
                                            <td>Masteral Students</td><td align="center"><span id="Chart1Data1"><?php echo $Functions->ReportListSemester("studentscourse","StudentProgram","MASTERAL"); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>Doctoral Students</td><td align="center"><span id="Chart1Data2"><?php echo $Functions->ReportListSemester("studentscourse","StudentProgram","DOCTORAL"); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Total&emsp;</td><td align="center"><span id="Chart1Data2"><?php echo $Functions->TableCounter2("studentscourse","StudentProgram","MASTERAL")+$Functions->TableCounter2("studentscourse","StudentProgram","DOCTORAL"); ?></span></td>
                                        </tr>
                                    </table>
                                    </div><br/>
                                </div>                            
							<?php
                            }
                            ?>
							<?php
                            if(isset($_GET['ListCourse'])){
                            ?>
                                <div class="Graph">
                                    <div class="Title">Students per Course:</div><br/>                                    
                                    <div class="Legends"><br/><div class="Title">Legend:</div><br/>
                                        <table border="0" width="100%" cellspacing="0" id="Course">
											<tr><td colspan="2"><strong>Masteral</strong></td></tr>
                                        	<?php
												$StudentCount = 0;
                                            	$Data = $Functions->ReportCourse("MASTERAL");
												for($x=0;$x<count($Data[0]);$x++){
													$StudentCount += $Data[1][$x];
													echo '<tr><td>'.$Data[0][$x].'</td><td align="center"><span id="ChartMasteral'.$x.'">'.$Data[1][$x].'</span></td></tr>';
												}
												echo '<input type="hidden" value="'.$x.'" id="Chart2Data1"/>';
											?>
											<tr><td colspan="2"><br/><strong>Doctoral</strong></td></tr>
                                        	<?php
                                            	$Data = $Functions->ReportCourse("DOCTORAL");
												for($x=0;$x<count($Data[0]);$x++){
													$StudentCount += $Data[1][$x];
													echo '<tr><td>'.$Data[0][$x].'</td><td align="center"><span id="ChartDoctoral'.$x.'">'.$Data[1][$x].'</span></td></tr>';
												}
												echo '<input type="hidden" value="'.$x.'" id="Chart2Data2"/>';
											?>
                                            <tr><td align="right">Total&emsp;</td><td align="center"><span id="Chart2DataTotal"><?php echo $StudentCount; ?></span></td></tr>
                                        </table>
                                    </div><br/>
                                </div>                            
							<?php
                            }
                            ?>
							<?php
                            if(isset($_GET['ListYear'])){
                            ?>
                                <div class="Graph">
                                    <div class="Title">Students per Year:</div><br/>
                                 <div class="Legends"><div class="Title">Legends:</div><br/>
                                <?php
									$Data = $Functions->ReportSem();
								?>
                                 <table border="0" width="100%" cellspacing="0" id="Course">
                                 	<tr>
                                    	<td>First Semester</td><td></td>
                                    </tr>
                                    <tr>
                                    	<td>&emsp;Masteral</td><td><span id="Chart3Data1"><?php echo $Data[0][0]*1; ?></span></td>
                                    </tr>
                                    <tr>
                                    	<td>&emsp;Doctoral</td><td><span id="Chart3Data2"><?php echo $Data[0][1]*1; ?></span></td>
                                    </tr>
                                    <tr>
                                    	<td align="right">Total&emsp;</td><td><span id="Chart3DataTotal1"><?php echo $Data[0][0]+$Data[0][1]; ?></span></td>
                                    </tr>
                                 	<tr>
                                    	<td><br/>Second Semester</td><td></td>
                                    </tr>
                                    <tr>
                                    	<td>&emsp;Masteral</td><td><span id="Chart3Data3"><?php echo @$Data[1][0]*1; ?></span></td>
                                    </tr>
                                    <tr>
                                    	<td>&emsp;Doctoral</td><td><span id="Chart3Data4"><?php echo @$Data[1][1]*1; ?></span></td>
                                    </tr>
                                    <tr>
                                    	<td align="right">Total&emsp;</td><td><span id="Chart3DataTotal2"><?php echo @$Data[1][0]+@$Data[1][1]; ?></span></td>
                                    </tr>
                                 </table>                                    
                                 </div><br/>
                                </div>                            
							<?php
                            }
                            ?>
                        </div>
						<?php 
                        if(isset($_GET['Masteral']) || isset($_GET['Doctoral'])){
                        ?>
                            <div id="PersonalInformation"><br/>
                                <table border="0" width="100%" align="center" id="First">
                                    <tr>
                                        <td colspan="3">
                                            <?php
                                                if(isset($_GET['Masteral'])){$Program = "MASTERAL"; $StudentIDNumber = $Functions->StudentIDNumberGenerator("Masteral"); }
                                                else if(isset($_GET['Doctoral'])){$Program = "DOCTORAL";$StudentIDNumber = $Functions->StudentIDNumberGenerator("Doctoral");} 
                                            ?>
                                            <div class="Graph"><div class="Title">Adding <span id="Program"><?php echo $Program; ?></span> Student</div></div>
                                        </td>
                                    </tr>
                                </table>                            	
                                <table border="0" width="95%" align="center" id="First">
                                    <tr>
                                        <td colspan="3">
                                            <strong>Step: 1/2</strong><br/><br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <span id="OldStudent">
                                            Student's Classification:<br/>
                                            <select id="StudentType" class="Box-shadow">
                                                <option>New</option>
                                                <option>Old</option>
                                                <option>Transferee</option>
                                                <option>Cross-Enrollee</option>
                                                <option>Shifter</option>
                                            </select><input type="text" id="OldInputStudent" placeholder="Student ID Number" class="Box-shadow" maxlength="12"/>
                                            </span>
                                        </td>
                                    </tr>
                                </table><!-- StudentType -->
                                <table border="0" width="95%" align="center" id="NewStudent">
                                    <tr>
                                        <td colspan="4"><br/>
                                            <b>Student Number: <span id="IDNumber"><?php echo $StudentIDNumber; ?></span></b>
                                            <input type="hidden" value="<?php echo @$_SESSION['KeyCheck']; ?>" id="SessionChecker">
                                            <input type="hidden" value="<?php echo $Functions->CodeGenerator(); ?>" id="CodeGen">
                                            <br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            xxx
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="33%"><span id="ErrorStudentFamilyName"></span><input type="text" placeholder="Family Name" value="<?php echo @$_SESSION['KeyThree']; ?>" id="StudentFamilyName"></td>
                                        <td width="33%" colspan="2"><span id="ErrorStudentGivenName"></span><input type="text" placeholder="Given Name" value="<?php echo @$_SESSION['KeyOne']; ?>" id="StudentGivenName"></td>
                                        <td width="33%"><span id="ErrorStudentMiddleName"></span><input type="text" placeholder="Middle Name" value="<?php echo @$_SESSION['KeyTwo']; ?>" id="StudentMiddleName"></td>
                                    </tr>
                                    <tr>
                                        <td width="33%">(Surname)<br/><br/></td>
                                        <td width="33%" colspan="2">(Given Name)<br/><br/></td>
                                        <td width="33%">(Middle Name)<br/><br/></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Date of birth: <span id="ErrorDOB"></span><br/>
                                            <select name="StudentMonth" id="StudentMonth">
                                                <option>Month</option>
                                                <?php
                                                for($x=0;$x<12;$x++){
                                                    if(@$_SESSION['KeyFourA'] == $Month[$x])
                                                        echo '<option selected>'.$Month[$x].'</option>';
                                                    else
                                                        echo '<option>'.$Month[$x].'</option>';
                                                }
                                                ?>
                                            </select>
                                            <select name="StudentDay" id="StudentDay">
                                                <option>Day</option>
                                                <?php
                                                for($x=1;$x<31;$x++){
                                                    if(@$_SESSION['KeyFourB'] == $x)
                                                        echo '<option selected>'.$x.'</option>';
                                                    else
                                                        echo '<option>'.$x.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <select name="StudentYearOfBirth" id="StudentYearOfBirth">
                                                <option>Year</option>
                                                <?php
                                                $y=0;
                                                for($x=1;$x<60;$x++){
                                                    $y = 2000 - $x;
                                                    if(@$_SESSION['KeyFourC'] == $y)
                                                        echo '<option selected>'.$y.'</option>';
                                                    else
                                                        echo '<option>'.$y.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td width="50px">
                                            Gender <span id="ErrorStudentGender"></span><br/>
                                            <select id="StudentGender">
                                                <?php
                                                    $Gender = array("Male","Female");
                                                    for($x=0;$x<count($Gender);$x++){
                                                        if(@$_SESSION['KeyTwelve'] == $Gender[$x])
                                                            echo '<option selected>'.$Gender[$x].'</option>';
                                                        else
                                                            echo '<option>'.$Gender[$x].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            Civil Status<br/>
                                            <select id="StudentCivilStatus">
                                                <option>Single</option>
                                                <option>Married</option>
                                                <option>Widowed</option>
                                                <option>Annulled</option>
                                            </select>
                                        </td>
                                        <td>
                                            Mobile Number
                                            <span id="ErrorStudentMobileNumber"></span>
                                            <input type="text" placeholder="Mobile Number" id="StudentMobileNumber" maxlength="11">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            Address
                                            <span id="ErrorStudentAddress"></span>
                                            <input type="text" placeholder="Address" id="StudentAddress">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Email
                                            <span id="ErrorStudentEmailAddress"></span>
                                            <input type="text" placeholder="Email Address" id="StudentEmailAddress">
                                        </td>
                                        <td colspan="2">
                                            Guardian
                                            <span id="ErrorStudentGuardian"></span>
                                            <input type="text" placeholder="Guardian" id="StudentGuardian">
                                        </td>
                                        <td>
                                            Guardian's Contact Number
                                            <span id="ErrorStudentGuardianContactNumber"></span>
                                            <input type="text" placeholder="Guardian's Contact Number" id="StudentGuardianContactNumber" maxlength="11">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <table width="100%" border="0" id="CourseInputs">
                                                <tr>
                                                    <td colspan="3">
                                                        <hr/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2">
                                                        Course
                                                        <span id="ErrorCourse"></span>
                                                        <span id="StudentProgam"><?php echo @$_SESSION['Program']; ?></span>
                                                        <div id="CourseSelection"></div><br/>
                                                     </td>
                                                     <td colspan="2" width="50%" id="AddSubjectDiv" class="Box-shadow">
                                                        *To add subject(s), select the subject the click add.<br/><br/>
                                                        Course Code:
                                                        <div id="SubjectList"><select><option></option></select></div>
                                                     </td>
                                                </tr>
                                                <tr>
                                                    <td><div><input type="button" value="Add Subject" id="AddSubject"class="Box-shadow"></div></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                    
                                                        <br/><strong>Subjects to enrol:</strong><br/>
                                                        <div id="SubjectContentList">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">
                                            <input type="button" value="Save and Print" id="AddMe" class="Box-shadow"/>
                                            <input type="button" value="Cancel" id="CancelMe" class="Box-shadow"/>
                                        </td>
                                    </tr>
                                </table><!-- StudentInformation -->
                                <table border="0" width="100%" align="center" id="NewStudentPicture">
                                    <tr>
                                        <td>
                                            <strong>Step: 2/2</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <form action="" method="post" enctype="multipart/form-data" name="PictureFileUpload">
                                                <div id="FileSelect"><input type="file" name="FilePicture" id="FilePicture"/></div>
                                                <div id="Data"><?php echo @$Error; ?></div>
                                                <input type="hidden" id="PopsError" value="<?php echo @$Error; ?>"/>
                                                <input type="hidden" value="" name="StudentID"/>
                                                <input type="submit" value="Done" name="FileUpload" id="FileUpload"/>
                                                <input type="submit" value="Ignore" name="FileSkip"/>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            *Choose ignore to set the student's picture to Default
                                        </td>
                                    </tr>
                                </table><!-- StudentPicture -->
                                <div id="OldStudentData">
                                    <div id="OldStudentInformation"></div>
                                    <table width="100%" border="0" id="OldCourseInputs" cellpadding="0" cellspacing="0" align="center" class="Box-shadow">
                                        <tr >
                                            <td colspan="2"><div id="OldStudentCourse"></div></td></tr>
                                        <tr>
                                            <td id="AddSubjectDiv">
                                                *To add subject(s), select the subject the click add.<br/><br/>
                                                <div id="OldSubjectList"><select><option></option></select></div>
                                             </td>
                                        </tr>
                                        <tr>
                                            <td><div><input type="button" value="Add Subject" id="OldAddSubject"class="Box-shadow"></div></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                            
                                                <br/>Subjects to enrol:
                                                <div id="OldSubjectContentList"></div>
                                                <div align="right"><input type="button" value="Save and Print" id="OldAddMe" class="Box-shadow" onClick="PrintDocx()">
                                                <input type="button" value="Cancel" id="OldCancelMe" class="Box-shadow"></div>
                                            </td>
                                        </tr>
                                    </table><!-- OldStudentInformation -->
                                </div>
                                <div id="ShifterData">
                                    <div id="ShifterInformation"></div>
                                    <table width="90%" border="0" id="OldCourseInputs" cellpadding="0" cellspacing="0" align="center" class="Box-shadow">
                                        <tr>
                                            <td colspan="2">Current Course: <div id="ShifterOldCourse"></div></td>
                                        </tr>
                                        <tr>
                                            <td>New Course:
                                            	<div id="ShifterNewCourse"><select></select></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                            
                                                <br/>Subjects to enrol:
                                                <div id="ShifterSubjectList"></div>
                                                <div align="right"><input type="button" value="Save and Print" id="ShifterAddMe" class="Box-shadow" onClick="PrintDocx()">
                                                <input type="button" value="Cancel" id="ShifterCancelMe" class="Box-shadow"></div>
                                            </td>
                                        </tr>
                                    </table><!-- ShifterInformation -->
                                </div>
                                <div id="Printable" class="Print">
                                </div>
                                <div id="OldPrintable" class="Print">
                                </div>
							<?php
                            }
                            ?>
							<?php
                                if(isset($_GET['AddCourse'])){
                            ?>
                                <table border="0" width="100%" align="center">
                                    <tr>
                                        <td colspan="5"><br/>Adding a Course and Subjects<br/><br/></td>
                                    </tr>
                                    <tr>
                                        <td >
                                            Program<br/>
                                            <select id="ProgramTitleX">
                                                <option>Doctoral</option>
                                                <option>Masteral</option>
                                            </select>
                                        </td>
                                        <td width="500">
                                        	Course Title<span id="ErrorCourseTitleX"></span><br/>
                                            <input type="text" placeholder="Course Title" id="CourseTitleX">
                                        </td>
                                        <td width="200px">
                                            Course Code <span id="ErrorCourseCodeX"></span><br/>
                                            <input type="text" placeholder="Course Code" id="CourseCodeX">
                                        </td>
                                        <td colspan="2">
                                            Units<br/>
                                            <select id="CourseUnitsX">
                                                <?php
                                                for($x=1;$x<13;$x++){
                                                    echo '<option>'.$x.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Descriptive Title <span id="ErrorDescriptiveTitleX"></span><br/><input type="text" placeholder="Descriptive Title" id="DescriptiveTitleX"></td>
                                        <td><label><input type="checkbox" id="CHKCourseX"/>Laboratory</label></td><td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" ><input type="button" value="Add" id="BtnCourseOkX"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="center">
                                        	<table border="1" width="100%" cellspacing="0" id="Course">
                                                <tr>
                                                    <td width="150px" align="center">Course Code</td>
                                                    <td width="500px" align="center">Descriptive Title</td>
                                                    <td width="115px" align="center">Units</td>
                                                </tr>
                                                <tr>
                                                	<td colspan="3"><div id="CourseContent"></div>
                                                    </td>
                                                </tr>
                                             </table>
                                        </td>
                                    </tr>
                                     
                                </table><!-- Add Course -->
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                </div>
            </div>	
        </div>
    </div>
</body>
</html>