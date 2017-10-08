<link rel="stylesheet" href="../BOOTSTRAP/css/bootstrap.css" type="text/css"/>
<style>
.col-md-6{
	width:500px;
}
small{
	font-size: 5px;
}
</style>
<?php
include("../PHPFiles/DBConnection.php"); 
include("../PHPFiles/Functions.php"); 
include("../PHPFiles2/Functions.php"); 
$Functions2 = new DatabaseClasses;
$Functions = new FunctionsExt;

if(isset($_GET['ReportQuery'])){
    $Total = 0; $Collection = "";
    $SummarySubTotal = 0; $SummaryTotal = 0; $SummeryOfCollection = "";
    $Data = $_POST['Data'];

    $Date = "{$Data[0]}-01-{$Data[1]}";
    $GetMonth = date("m",strtotime($Date));
    $Date = date("m-d",strtotime($Date));
    $Date1 = "{$Data[1]}-{$Date}";
    $Date2 = $Functions2->PDO_SQL("SELECT LAST_DAY('$Date1')");
    $Date2 = $Date2[0][0];

    $Q1 = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE DateOfPayment BETWEEN '$Date1' AND '$Date2'");
    foreach ($Q1 as $a => $b) {
    	$Total = $Total + $b[3];
	    $QStudent = $Functions2->PDO_SQL("SELECT * FROM students WHERE StudentIDNumber = '{$b[1]}'");
    	$Collection .= "
    		<tr>
    			<td align='center'>
		    		{$b[4]}
    			</td>
    			<td>
		    		{$QStudent[0][4]} {$QStudent[0][2]}, {$QStudent[0][3]} 
    			</td>
    			<td align='center'>
		    		{$b[3]}
    			</td>
    			<td align='center'>
		    		{$b[2]}
    			</td>
    		</tr>
    	";
    }

    $QDateDiff = $Functions2->PDO_SQL("SELECT DATEDIFF('$Date2','$Date1')");

    for($x=1;$x<=($QDateDiff[0][0]+1);$x++){
    	if($x<=9)
		    $DateX = "{$Data[1]}-{$GetMonth}-0{$x}";
		else
		    $DateX = "{$Data[1]}-{$GetMonth}-{$x}";

	    $Q2 = $Functions2->PDO_SQL("SELECT * FROM cashier WHERE DateOfPayment = '{$DateX}'");
	    if(count($Q2)>0){
	    	$SummarySubTotal = 0;
	    	foreach ($Q2 as $a => $b) {
			    $SummarySubTotal = $SummarySubTotal + $b[3];
	    	}
		    $SummeryOfCollection .= "
		    	<tr>
		    		<td width='10%'>{$x}</td>
		    		<td>{$SummarySubTotal}</td>
		    	</tr>
		    ";
		    $SummaryTotal = $SummaryTotal + $SummarySubTotal;
	    }
    }

    echo "
	<div class='panel panel-default'>
		<div class='panel-heading text-center'>
			<h4>
				Pangasinan State University<br/>
				<small>
					<strong>Open University System</strong><br/>
					Lingayen Campus
				</small>
			</h4>
			<u><strong>Collection Report of <u>{$Data[0]} {$Data[1]}</u></strong></u>
		</div>
		<table class='table'>
    		<tr>
    			<td>
    				<div class='col-md-7'>
    					Collection Report
        				<table class='table table-bordered'>
                    		<tr>
                    			<td class='text-center' width='10%'>OR Number</td>
                    			<td width='30%'>Name</td>
                    			<td class='text-center' width='10%'>Amount Paid</td>
                    			<td class='text-center' width='10%'>Date of Payment</td>
                    		</tr>
	                    	{$Collection}
                    		<tr>
                    			<th colspan='2'><span class='pull-right'>Total: </span></th>
                    			<th class='text-center'>{$Total}</th>
                    			<th></th>
                    		</tr>
        				</table>
		            </div>
    				<div class='col-md-5'>
    					Summary
        				<table class='table table-bordered'>
                        	<tr>
				        		<td colspan='2'>{$Data[0]} {$Data[1]}</td>
                        	</tr>
                        	{$SummeryOfCollection}
                        	<tr>
                        		<th><span class='pull-right'>Total: </span></td>
                        		<th>{$SummaryTotal}</td>
                        	</tr>
        				</table>
		            </div>
    			</td>
    		</tr>
    	</table>
    </div>
    ";
}
?>