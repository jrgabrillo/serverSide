<?php
session_start();
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php");
include("../PhpFiles2/Functions.php"); 
$User = $_SESSION['Username']; 
if(!isset($_SESSION['Username']) && !isset($_SESSION['Password'])){ header("Location:../"); }
$Functions = new FunctionsExt;
$Functions2 = new DatabaseClasses;
if(isset($_GET['LogOut'])){
	session_destroy();
	header("Location:../");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $User; ?></title>
<link rel="stylesheet" href="../CSS/General.css" type="text/css">
<link rel="stylesheet" href="../CSS/Admin.css" type="text/css">
<link rel="icon" href="../Images/GSLOGO.png">
<link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap.css" type="text/css"/>
<script type="text/javascript" src="../JQuery/JQuery.js"></script>
<script type="text/javascript" src="../JQuery/Faculty.js"></script>
<script type="text/javascript" src="../JQuery/JS.js"></script></head>
<script type="text/javascript" src="../JQuery/Validation.js"></script>
<script type="text/javascript" src="../BOOTSTRAP/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="modal fade" id="ModalAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="Text_ModalAlert"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="Button_Close">Close</button>
                </div>
            </div>
        </div>
    </div>    	
    <div class="modal fade" id="ModalAuthorize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                	<span id="AuthorizeText">You are about to change the rating. Please enter the authorization code.</span>
                	<input type='password' class='form-control' placeholder="Authorization Code" id='RegistrarAuthCode'/>               	
            	</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="Button_Close">Cancel</button>
                    <button type="button" class="btn btn-warning btn-sm" id="Button_Execute">Done</button>
                </div>
            </div>
        </div>
    </div>
    <div id="Container">
        <div class="Box-shadow">      	
		    <nav class="navbar navebar-default WhiteText" role="navigation"  style='xborder-top:1px solid #000; background:#060E62;'>
		            <div class="navbar-header">
		                <ul class="nav navbar-nav navbar-right">
		                    <li class="navbar-brand">Faculty - <?php echo $User; ?></li>
		                </ul>
		            </div>
		            <h4>
					<ul class="nav navbar-top-links navbar-right">
		                <li class='pull-right'>
		                    <a href="?LogOut">Log out</a>
		                </li>
		                <li class='pull-right'>
		                    <a href="?FacultyReport">Report</a>
		                </li>
		                <li class='pull-right'>
		                    <a href="?Home">Home</a>
		                </li>
		                <li class='pull-right'>
		                    <a href="?SubmitGrades">Submit grades</a>
		                </li>
		            </ul>
		        </h4>
		    </nav> 

        </div>
        <div id="Content">
            <div id="RegistrarContent">
            	<div id="DataReport" class="panel panel-default hidden">
            		<div class='panel-heading'>
        				Year and semester<br/>
        				<?php
        					echo "<input type='text' value='{$User}' id='FacultyName' class='hidden'>";
        					$YearAndSem = '<option>Select year/sem</option>';
                            $Q1 = $Functions2->PDO_SQL("SELECT DISTINCT YearSem FROM enrolledsubject WHERE Professor = '$User'");
                            foreach ($Q1 as $a => $b) {
                            	$YearAndSem .= "<option>{$b[0]}</option>";
                            }
                            echo "
	            				<select class='btn btn-sm btn-default' id='FacultyReportYear'>{$YearAndSem}</select>
                            ";
        				?>
            		</div>
        			<div id='DataReportResult'>
        				<p class='text-center'>No Result</p>
        			</div>
            	</div>
                <div id="DataContainer" class='panel panel-default'>
                    <div id="StudentsList"></div>
                    <div id="StudentInformation"></div>
                </div>
                <div id="SubmitGrades" class="panel panel-default hidden">
                	<div class="panel-heading"><h4>Grades/Ratings submission</h4></div>
                	<?php
						if(!isset($_SESSION['Registrar']) || (isset($_SESSION['Registrar']) && $_SESSION['Registrar'] == "OFF")){
							echo "
			                	<div class='penel-body' id='RegistrarAuthCode2Form'>
			                		<div class='col-md-4'>
					                	<span id='AuthorizeText'>You are about to submit the late grades/ratings of students.<br/> To proceed, please enter the authorization code.</span>
					                	<input type='password' class='form-control' placeholder='Authorization Code' id='RegistrarAuthCode2'/>
					                	<i class='text-danger' id='Notification_RegistrarAuthCode2'><small></small></i>
			                		</div>
			                		<div class='col-md-4'><br/><br/>
					                	<input type='button' class='btn btn-sm btn-danger' value='Submit' id='Button_RegistrarAuthCode2'>              	
			                		</div>
			                	</div>							
							";
						}
						else{
							echo "
								<input type='text' class='hidden' value='{$_SESSION['Registrar']}' id='AuthorizationCodeStatus'>
							";
						}
                	?>
                	<div class="penel-footer" id='StudentsNoGradesList'>
                		<br/><br/><br/><br/><br/>
                	</div>
                </div>
            </div>	
        </div>
    </div>
</body>
</html>
