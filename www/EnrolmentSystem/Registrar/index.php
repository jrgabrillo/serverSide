<?php
session_start();
include("../PHPFiles/DBConnection.php");
include("../PHPFiles/Functions.php"); 
include("../PhpFiles2/Functions.php"); 
if(!isset($_SESSION['Username']) && !isset($_SESSION['Password'])){ header("Location:../"); }
$Functions = new FunctionsExt;
$Functions2 = new DatabaseClasses;
if(isset($_GET['LogOut'])){
	session_destroy();
	header("Location:../");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>REGISTRAR</title>

    <style>
        .highcharts-button{
            display: none;
        }
    </style>

    <script type="text/javascript" src="../JQuery/JQuery.js"></script>
    <script type="text/javascript" src="../JQuery/JS.js"></script>
    <script type="text/javascript" src="../JQuery/Upload.js"></script>
    <script type="text/javascript" src="../JQuery/Validation.js"></script>

    <script src="../JQuery/js/highcharts.js"></script>
    <script src="../JQuery/js/highcharts-3d.js"></script>
    <script src="../JQuery/js/modules/exporting.js"></script>
    <script src="../JQuery/Report.js"></script>

    <script type="text/javascript" src="../JQuery/Registrar.js"></script>
    <script type="text/javascript" src="../BOOTSTRAP/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../JQuery/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
    <script type="text/javascript" src="../JQuery/plugins/dataTables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="../JQuery/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="../BOOTSTRAP/js/plugins/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="../BOOTSTRAP/js/sb-admin.js"></script>

    <link rel="stylesheet" href="../CSS/General.css" type="text/css"/>
    <link rel="stylesheet" href="../CSS/Registrar.css" type="text/css"/>
    <link rel="icon" href="../Images/GSLOGO.png">
    <link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="../BOOTSTRAP/font-awesome/css/font-awesome.css" type="text/css"/>
    <link rel="stylesheet" href="../JQuery/jasny-bootstrap/css/jasny-bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="../BOOTSTRAP/css/sb-admin.css"/>
</head>
<body>
	<input type="hidden" value="<?php echo @$_SESSION['AddStudent']; ?>" id="AddStudentSessionChecker"/>
    <nav class="navbar label-primary WhiteText" role="navigation" style='height:120px; background:#060E62;'>
        <div class="container-fluid">
            <div class="navbar-header col-md-12">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand col-md-12">
                    <div class="col-md-5">
                        <img src='../Images/GSLOGO.png' class='col-md-3'>
                        <h1 style='color:#fff; font-family:monotype corsiva;'>PSU-OUS-EES</h1>
                    </div>
                    <div class="col-md-5"><h1 style='color:#fff; font-family:monotype corsiva;'><p>Welcome</p></h1></div>
                    <div class="col-md-2"><h1 style='color:#fff; font-family:monotype corsiva;'><p class='text-right' id="Timely">Loading time</p></h1></div>
                    
                </span>
            </div>
            <div class="collapse navbar-collapse">
            </div>
        </div>
    </nav>
    <nav class="navbar label-primary WhiteText" role="navigation" style='xborder-top:1px solid #000; background:#060E62;'>
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">REGISTRAR</span>
            </div>
            <div class="collapse navbar-collapse">
                <h4 class="pull-right"><a href="?LogOut"><button class="btn btn-default">Log Out</button></a></h4>
            </div>
        </div>
        <div class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse panel panel-default">
                <ul class="nav" id="side-menu panel-body">
                    <li><a href="?Dashboard"> Home</a></li>
                    <li class="panel-group" id="accordion">
                        <a data-toggle="collapse" data-parent="#accordion" href="#One">
                            <span class="glyphicon glyphicon-chevron-down pull-right" id="Chevy0"></span>
                            Enrol
                        </a>
                        <ul class="nav nav-second-level collapse panel-collapse collapse" style="height: auto;" id="One">
                            <li><a href="?Doctoral" id="AddDoctoral" class="list-group-item">Doctoral</a></li>
                            <li><a href="?Masteral" id="AddMasteral" class="list-group-item">Masteral</a></li>
                        </ul>
                    </li>   
                    <li class="panel-group" id="accordion">
                        <a data-toggle="collapse" data-parent="#accordion" href="#Two">
                            <span class="glyphicon glyphicon-chevron-down pull-right" id="Chevy1"></span>
                            Student Info
                        </a>
                        <ul id="Two" class="list-group panel-collapse collapse">
                            <li><a href="?ProgramView=Doctoral" class="list-group-item">Doctoral</a></li>
                            <li><a href="?ProgramView=Masteral" class="list-group-item">Masteral</a></li>
                        </ul>
                    </li>                    
                    <li class="panel-group" id="accordion">
                        <a data-toggle="collapse" data-parent="#accordion" href="#Three">
                            <span class="glyphicon glyphicon-chevron-down pull-right" id="Chevy2"></span>
                            Reports
                        </a>
                        <ul id="Three" class="list-group panel-collapse collapse">
                            <li class="list-group-item"><img src="../Images/glyphicons_042_pie_chart.png"/>&emsp;Pie Chart
                                    <li><a href="?ChartCourse" class="list-group-item">&emsp;Course</a></li>
                                    <li><a href="?ChartYear" class="list-group-item">&emsp;Year</a></li>
                                    <li><a href="?ChartSemester" class="list-group-item">&emsp;Semester</a></li>
                            </li>
                            <li class="list-group-item"><img src="../Images/glyphicons_114_list.png"/>&emsp;List
                                    <li><a href="?ListCourse" class="list-group-item">&emsp;Course</a></li>
                                    <li><a href="?ListYear" class="list-group-item">&emsp;Year</a></li>
                                    <li><a href="?ListSemester" class="list-group-item">&emsp;Semester</a></li>
                                    <!--<li class="list-group-item">&emsp;<a href="?ListSubject">Subject</a></li> -->
                            </li>
                        </ul>
                    </li>                    
                    <li><a href="?FacultyLoading">Faculty Loading</a></li>                    
                    <li class='hidden'><a href="?AddCourse">Add Course</a></li>                    
                    <li><a id="BackupDBX" class="hand">Backup Database</a></li>                    
                    <li><a href="?LogOut">Log Out</a></li>                    
                </ul>
            </div>
        </div>
    </nav>

    <div id="Container">
        <div id="Content">
            <div id="RegistrarContent">
                <div id="DataContainer">
                	<?php
                    	if(isset($_GET['FacultyLoading'])){
							echo '
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3>Faculty Loading</h3>
									</div>
							';
                            $Q2 = $Functions2->PDO_SQL("SELECT * FROM faculty");
                            echo "<table class='table table-striped'>";
                            foreach ($Q2 as $a => $b) {
                                $Q3 = $Functions2->PDO_SQL("SELECT * FROM courses WHERE CourseNumber = '{$b[2]}'");
                                if(count($Q3) == 0)
                                    $Load = "";
                                else
                                    $Load = "<small>{$Q3[0][5]}<br/>{$Q3[0][1]}: {$Q3[0][2]}</small>";

                                echo '<tr><td width="30%">
                                <div class="col-md-3">'.($a+1).'.&nbsp;'.$b[1].'</div>
                                <div class="col-md-7">
                                    <span class="FacultySubject" id="FLoaded'.$a.'">'.$Load.' &nbsp;</span>
                                    <span class="Hidden" id="'.$a.'" >
                                        <div class="col-md-5">
                                            <select class="form-control" id="FacultyCourse'.$a.'">
                                            <option>Course</option>';
                                            $Courses = $Functions->Courses2();
                                            for($x=0;$x < count($Courses);$x++){
                                                echo '<option>'.$Courses[$x].'</option>';
                                            }
                                echo '
                                            </select>
                                        </div>
                                        <input type="hidden" value="'.$b[0].'" id="FacultyID'.$a.'"/>
                                        <div class="FacultyList col-md-3" id="FacultyList'.$a.'">
                                            <select class="form-control">
                                                <option>Subject</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button id="FacultySureLoad" class="btn btn-success btn-sm">Load</button> 
                                            <button id="FacultyCancelLoad" class="btn btn-success btn-sm">Cancel</button>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-md-2"><span class="FacultyLoad btn btn-sm btn-warning pull-right" id="F'.$a.'">Load</span></div>
                                </td></tr>';      
                            }
                            echo "</table>
								</div>
							";
						}
					?>
                	
                	<?php
						if(isset($_GET['ProgramView'])){
							echo "
								<div class='panel panel-default'>
                                    <div class='panel-heading'>
										<h3>Student Information <small>{$_GET['ProgramView']}</small></h3>
                                    </div>
                                    <div class='panel-body'>
                                        <table class='table table-striped' id='StudentsList'>
                                            <thead>
                                                <th width='10%'></th>
                                                <th width='30%'>Name</th>
                                                <th width='55%'>Course</th>
                                                <th width='5%'>Option</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>        
							";
						}
						
						if(isset($_GET['KeyD'])){
							echo "
								<table class='table'><tr><td><div class='Title'>Finishing Enrollment</div></td></tr></td></tr></table>
							";
							if($_GET['KeyType'] == 'Transferee' || $_GET['KeyType'] == 'CrossEnrollee')
								$Functions->CrossEnrolleAndTransferee($_GET['KeyD']);
							else
								$Functions->OldStudent($_GET['KeyD']);
						}
                    ?>
                    <div id="PrintableUnits"></div>
                    <div id="PrintableGrades"></div>
                    <div id="PrintableGoodMoral"></div>
                    <div id="PrintableOTR"></div>
                    <div id="Registration">
                        <div id="ReportGenerationx">
                            <?php
                                if(isset($_GET['Dashboard'])){
                                    echo '
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="col-md-12 text-center">
                                                    <img src="../Images/PSU - OUS2.png" alt="" id="ImageFlip"><br/>
                                                    <i id="ImageLoading">loading effects...</i>
                                                    <h1>Pangasinan State University</h1>
                                                    <h3>OPEN UNIVERSITY SYSTEM</h3>
                                                    <H5> - Lingayen Pangasinan - </H5>
                                                </div>
                                            </div>        
                                        </div>        
                                    ';
                                }

                                //Chart

                                if(isset($_GET['ChartSemester'])){
    								echo "
    									<div class='panel panel-default'>
    										<div class='panel-heading'>
    											<h3>Chart <small>Students per semester</small></h3>
    										</div>
                                            <div class='panel-body'>
                                                <div class='col-md-6 col-md-offset-3'>
                                                    <div class='panel panel-default'>
                                                        <div class='panel-body' id='SemesterChart1'></div>
                                                        <table class='table table-bordered table-striped' id='SemesterChartLegend1'></table>
                                                    </div>
                                                </div>
                                            </div>
    									</div>        
    								";
                                }
                                else if(isset($_GET['ChartCourse'])){
    								echo "
    									<div class='panel panel-default'>
    										<div class='panel-heading'>
    											<h3>Chart <small>Students per course</small></h3>
    										</div>
                                            <div class='panel-body'>
                                                <div class='col-md-6'>
                                                    <div class='panel panel-default'>
                                                        <div class='panel-body' id='CourseChart1'></div>
                                                        <table class='table table-bordered table-striped' id='CourseChartLegend1'></table>
                                                    </div>
                                                </div>
                                                <div class='col-md-6'>
                                                    <div class='panel panel-default'>
                                                        <div class='panel-body' id='CourseChart2'></div>
                                                        <table class='table table-bordered table-striped' id='CourseChartLegend2'></table>
                                                    </div>
                                                </div>
                                            </div>
    									</div>        
    								";
                                }
                                else if(isset($_GET['ChartYear'])){
    								echo "
    									<div class='panel panel-default'>
    										<div class='panel-heading'>
    											<h3>Chart <small>Students per year</small></h3>
    										</div>
                                            <div class='panel-body'>
                                                <div class='col-md-6'>
                                                    <div class='panel panel-default'>
                                                        <div class='panel-body' id='YearChart1'></div>
                                                        <table class='table table-bordered table-striped' id='YearChartLegend1'></table>
                                                    </div>
                                                </div>
                                                <div class='col-md-6'>
                                                    <div class='panel panel-default'>
                                                        <div class='panel-body' id='YearChart2'></div>
                                                        <table class='table table-bordered table-striped' id='YearChartLegend2'></table>
                                                    </div>
                                                </div>
                                            </div>
    									</div>        
    								";
                                }

                                //List
                                if(isset($_GET['ListSemester'])){
                                    echo "
                                        <div class='panel panel-default'>
                                            <div class='panel-heading'>
                                                <h3>List <small>Students per semester</small></h3>
                                            </div>
                                            <div class='panel-body'>
                                                <div class='col-md-6 col-md-offset-3'>
                                                    <div id='SemesterList'></div>
                                                </div>
                                            </div>
                                        </div>        
                                    ";
                                }
                                else if(isset($_GET['ListCourse'])){
                                    echo "
                                        <div class='panel panel-default'>
                                            <div class='panel-heading'>
                                                <h3>List <small>Students per course</small></h3>
                                            </div>
                                            <div class='panel-body'>
                                                <div class='col-md-6'>
                                                    <div id='CourseList1'></div>
                                                </div>
                                                <div class='col-md-6'>
                                                    <div id='CourseList2'></div>
                                                </div>
                                            </div>
                                        </div>        
                                    ";
                                }
                                else if(isset($_GET['ListYear'])){
                                    echo "
                                        <div class='panel panel-default'>
                                            <div class='panel-heading'>
                                                <h3>List <small>Students per year</small></h3>
                                            </div>
                                            <div class='panel-body'>
                                                <div class='col-md-6'>
                                                    <div id='YearList1'></div>
                                                </div>
                                                <div class='col-md-6'>
                                                    <div id='YearList2'></div>
                                                </div>
                                            </div>
                                        </div>        
                                    ";
                                }
                            ?>
                        </div>
						<?php 
                        if(isset($_GET['Masteral']) || isset($_GET['Doctoral'])){
                            if(isset($_GET['Masteral'])){
                                $Program = "New masteral student";
                                $ProgramVal = "MASTERAL";
                            }
                            else if(isset($_GET['Doctoral'])){
                                $Program = "New doctoral student";
                                $ProgramVal = "DOCTORAL";
                            }
                            $StudentIDNumber = $Functions2->OUSStudentIDNumberGenerator();                                
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3>Enrol <small><span id="StudentTitle"><?php echo $Program; ?></span></small></h3>
                                </div>
                                <div class="panel-body">
                                    <input type='text' class='form-control hidden' id='StudentProgram' value='<?php echo $ProgramVal; ?>'>
                                    <div class='form-group col-md-3'>
                                        <label>Student's Category</label>
                                        <select id="StudentType" class="form-control">
                                            <option>Old</option>
                                            <option>Shifter</option>
                                            <option>Transferee</option>
                                            <option>Cross-Enrollee</option>
                                            <option>New</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Student ID</label>
                                        <span class="hidden" id="GeneratedID"></span>
                                        <input type="text" class="form-control" id="StudentIDInput" data-mask="99-OUS-9999" placeholder="Student ID"/>
                                        <span id="ErrorStudentIDInput"></span>
                                    </div>
                                    <span class="col-md-3 hidden" id='StudentCategoryForm'>
                                        <label><br/></label>
                                        <select id='StudentCategory' class='form-control'>
                                            <option>Regular</option>
                                            <option>International</option>
                                        </select>
                                    </span>
                                    <span class="col-md-3">
                                        <label>Registration Code</label>
                                        <input type='text' id='RegistrationCode' class='form-control' readonly value='<?php echo $Functions->CodeGenerator(); ?>'>
                                    </span>
                                    <div id="NewStudentData" class="hidden"></div>
                                    <div id="OldStudentData">
                                        <div id="StudentInformation"></div>
                                    </div>
                                    <div id="ShifterData">
                                        <div id="ShifterInformation"></div>
                                    </div>
                                    <div id="Printable" class="hidden"></div>
                                    <div id="OldPrintable" class="Print"></div>
                                </div>        
                            </div>
                        <?php } ?>
                        <div id="PersonalInformation">
						<?php if(isset($_GET['AddCourse'])){ ?>
                            <div class="panel label-primary">
                                <div class="panel-heading">
                                    <h3 align="left">Add <small>Course and subjects</small></h3>
                                </div>
                                <div class="Graph">
                                    <table border="0" class="table">
                                        <tr>
                                            <td >
                                                Program<br/>
                                                <select id="ProgramTitleX" class="btn btn-default btn-sm">
                                                    <option>Doctoral</option>
                                                    <option>Masteral</option>
                                                </select>
                                            </td>
                                            <td width="500">
                                                Course Title<span id="ErrorCourseTitleX"></span><br/>
                                                <input type="text" class="form-control" placeholder="Course Title" id="CourseTitleX">
                                            </td>
                                            <td width="200px">
                                                Course Code <span id="ErrorCourseCodeX"></span><br/>
                                                <input type="text" class="form-control" placeholder="Course Code" id="CourseCodeX">
                                            </td>
                                            <td colspan="2">
                                                Units<br/>
                                                <select id="CourseUnitsX" class="btn btn-default btn-sm">
                                                    <?php
                                                    for($x=1;$x<13;$x++){
                                                        echo '<option>'.$x.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Descriptive Title <span id="ErrorDescriptiveTitleX"></span><br/><input class="form-control" type="text" placeholder="Descriptive Title" id="DescriptiveTitleX"></td>
                                            <td colspan="2">
                                                <br/>
                                                <div class="btn-group">
                                                    <span class="input-group-addon">
                                                        <input type="checkbox" id="CHKCourseX">
                                                    </span>
                                                    <span class="input-group-addon">
                                                        Laboratory
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" align="center"><input type="button" class="btn btn-sm btn-success disabled" value="Add" id="BtnCourseOkX"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" align="center">
                                                <div id="CourseContent"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>                            
                            </div>        
                        <?php } ?>
              </div>
          </div>
        </div>	
    </div>

    <div class="modal fade" id="BackUpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">PSU OUS ENROLLMENT SYSTEM</h4>
                </div>
                <div class="modal-body">
                    Database Back up on process...
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="Text_ModalAlert"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>    

    <div class="modal fade" id="ModalConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="Text_ModalConfirmation"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning btn-sm" id="Button_Execute">Ok</button>
                </div>
            </div>
        </div>
    </div>  

    <div class="modal fade" id="ModalConfirmation2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="Text_ModalConfirmation2"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning btn-sm" id="Button_Execute2">Ok</button>
                </div>
            </div>
        </div>
    </div>  

    <div class="modal fade bs-example-modal-lg" id="Modal_Universal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">System:</h4>
                </div>
                <div class='panel-body' id="Modal_BodyUniversal">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal_Credit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">System:</h4>
                </div>
                <div class='modal-body'>
                    <strong>Credited Subject: </strong><u id='CreditedSubject'></u><br/>
                    School last attended:
                    <input type='text' class='form-control' id='SchoolLastAttended'/><br/>
                    <?php
                        $RatingsArray = array("1.00","1.25","1.50","1.75","2.00","2.25","2.50","2.75","3.00","4.00","5.00","INC","DRP"); $RatingSelect = ""; $ReExam = "";
                        $RatingOptions = "";
                        foreach ($RatingsArray as $a => $b) {
                            $RatingOptions .= "<option>{$b}</option>";
                        }
                        echo "
                            Rating:
                            <select class='btn btn-sm btn-default' id='CreditedSubjectRating'>{$RatingOptions}</select>
                        ";
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning btn-sm" id="Button_CreditedSubject">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>