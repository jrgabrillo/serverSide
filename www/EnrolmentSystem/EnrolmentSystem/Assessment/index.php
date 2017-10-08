
<?php
session_start();
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
if(!isset($_SESSION['Username']) && !isset($_SESSION['Password'])){ header("Location:../"); }
$Functions = new Functions;
if(isset($_GET['LogOut'])){
	session_destroy();
	header("Location:../");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Assesment</title>
<link rel="icon" href="../Images/GSLOGO.png">
<link rel="stylesheet" href="../CSS/General.css" type="text/css">
<link rel="stylesheet" href="../CSS/Assessment.css" type="text/css">
<link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap.css" type="text/css"/>
<link rel="stylesheet" href="../JQuery/jasny-bootstrap/css/jasny-bootstrap.min.css" type="text/css"/>
<script type="text/javascript" src="../JQuery/JQuery.js"></script>
<script type="text/javascript" src="../JQuery/Validation.js"></script>
<script type="text/javascript" src="../BOOTSTRAP/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../JQuery/Assessment.js"></script>
<script type="text/javascript" src="../JQuery/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
</head>

<body>
    <div id="Container">
        <div class="Box-shadow">
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
                        <span class="navbar-brand">ASSESSMENT</span>
                    </div>
                    <div class="collapse navbar-collapse">
                        <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search" id="SearchBox">
                            </div>
                        </form>
                        <h4 class="pull-right"><a href="?LogOut"><button class="btn btn-default">Log Out</button></a></h4>
                    </div>
                </div>
            </nav>
        </div>
        <div id="Content">
            <div id="SearchResult" class="text-center"></div>
            <div id="RegistrarContent">
				<div id="ErrorAssessmentCode"></div>         	
            	<div class="input-group col-md-5" >
            		<span class="input-group-addon">Assessment Code</span>
	            	<input type="text" placeholder="Assessment Code" id="AssessmentCode" class='form-control'/>
            	</div>
                <div id="DataContainer">
                    </br>
                	<span id="StudentsList"></span>
                    <div id="StudentInformation"></div>
                    <div id="ScholarshipTable"></div>
                    <div id="EnrolledSubjectsList"></div>
                    <div id="Printable" class='hidden'>
                        <div id="PrintStudentInformation"></div>
                        <div id="PrintEnrolledSubjectsList"></div>
                    </div>
                </div>
            </div>	
        </div>
    </div>

    <div class="modal fade" id="ModalAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="Label_ModalAlert">System:</h4>
                </div>
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
    
</body>
</html>
<script type="text/javascript">
/*
function PrintDocx(){
	var TuitionFee = $("#TuitionFee").text(), MiscFee = $("#MiscFee").text(), AssessmentCode = $("#AssessmentCode").val(), StudentIDNumber = $("#StudentNumber").val();
	$.post("Assessment.php?PrintAndSave",{Tuition:TuitionFee,Misc:MiscFee,Assessment:AssessmentCode,StudentIDNumber:StudentIDNumber},function(Assessment){
		alert(Assessment);
		var prtContent = document.getElementById("Printable");
		var WinPrint = window.open('', '', 'letf=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
		WinPrint.document.write(prtContent.innerHTML);
		WinPrint.document.close();
		WinPrint.focus();
		WinPrint.print();
		WinPrint.close();
	}); // automatic Retrieving of enrolled subject listed	
}
*/
</script>
