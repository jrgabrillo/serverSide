<?php
session_start();
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
$Functions = new FunctionsExt;
if(!isset($_SESSION['Username']) && !isset($_SESSION['Password'])){ header("Location:../"); }
if(isset($_GET['LogOut'])){
	session_destroy();
	header("Location:../");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cashier</title>
<link rel="stylesheet" href="../CSS/General.css" type="text/css">
<link rel="stylesheet" href="../CSS/Cashier.css" type="text/css">
<script type="text/javascript" src="../JQuery/JQuery.js"></script>
<script type="text/javascript" src="../JQuery/Cashier.js"></script>
<link rel="icon" href="../Images/GSLOGO.png">
<script type="text/javascript" src="../JQuery/Validation.js"></script>
<script type="text/javascript" src="../BOOTSTRAP/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../JQuery/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
<link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap.css" type="text/css"/>
<link rel="stylesheet" href="../JQuery/jasny-bootstrap/css/jasny-bootstrap.css" type="text/css"/>

</head>

<body>
        <div id="Container">
            <div class="Box-shadow" style='background:#428bca;border-bottom:2px solid #000;'>
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
                                    <h1 style='color:#fff; font-family:monotype corsiva;'>PSU-GS-EES</h1>
                                </div>
                                <div class="col-md-5"><h1 style='color:#fff; font-family:monotype corsiva;'><p>Welcome</p></h1></div>
                                <div class="col-md-2"><h1 style='color:#fff; font-family:monotype corsiva;'><p class='text-right' id="Timely">Loading time</p></h1></div>
                            </span>
                        </div>
                        <div class="collapse navbar-collapse">
                        </div>
                    </div>
                </nav>
                <nav class="navbar label-primary WhiteText" role="navigation" style='height:80px; background:#060E62;'>
                    <div class="container-fluid">
                        <div class="navbar-header col-md-12">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <span class="navbar-brand col-md-12">
                                <div class="col-md-1">
                                    CASHIER
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" placeholder="Search" id="SearchBox">
                                </div>
                                <div class="col-md-5 pull-right">
                                    <a href="?Home" class="btn btn-danger">Home</a>
                                    <a href="?OtherFee" class="btn btn-danger">Others Fee</a>
                                    <a href="?Report" class="btn btn-danger">Collection Report</a>
                                    <a href="?LogOut" class="btn btn-danger pull-right">Log Out</a>
                                </div>
                            </span>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="Content">
                <div id="RegistrarContent">
                    <div id="OtherFee" class='hidden'></div>
                    <div id="CollectionReport" class='hidden'></div>
                    <div id="SearchResult" class="text-center"></div>
                    <div id="DataContainer">
                        <div id="ErrorAssessmentCode"></div>            
                        <div class="input-group col-md-5">
                            <span class="input-group-addon">Assessment Code</span>
                            <input type="text" placeholder="Assessment Code" class='form-control' id="AssessmentCode"/>
                        </div><br/>
                        <div id="StudentInformation"></div>
                        <div id="Cashier">
                        	<span id="CashierFees"></span>
                            <table class="table Box-shadow">
                            	<tr>
                                    <td colspan="4">
                                        <span id="ErrorAmountPaid"></span>&emsp;
                                        <span id="ErrorReceiptNumber"></span><br/>
                                    	<span id="CashierInputs">
                                        	<input type="hidden" value="<?php echo $Functions->DateNow(); ?>" id="DateNow">
                                            <span class='col-md-3'><input type="text" placeholder="Amount" id="AmountPaid" class="btn btn-sm btn-default"></span>
                                            <span class='col-md-3'><input type="text" placeholder="Reciept Number" id="ReceiptNumber" class="btn btn-sm btn-default"></span>
                                            <span class='col-md-3'><input type="button" value="Submit" id="CashierBtn" class="btn btn-sm btn-success disabled"></span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                	<td>
                                    <span id="PaymentList">
                                    </span>
                                    </td>
                                 </tr>
                            </table>
                        </div>
                        <div id="EnrolledSubjectsList"></div>
                    </div>
                    <div id="Printable" class='hidden'>
                        <div id="PrintStudentInformation"></div>
                        <div id="PrintEnrolledSubjectsList"></div>
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