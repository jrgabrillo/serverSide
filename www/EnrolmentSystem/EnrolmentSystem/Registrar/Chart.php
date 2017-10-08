<?php
if(isset($_GET['ChartSemester'])){
?><br/>
    <table width="10%" align="center">
        <tr>
            <td>
                <div class="panel panel-primary">
                    <div class="panel-heading">Panel heading</div>
                    <div class="panel-body">
                    	<canvas id="Chart1" width="500px" height="500px"></canvas>
                    </div>
	                <table class="table table-striped" border="0">
                        <tr>
                            <td><div class="DataMarker" id="Data1Marker1"></div></td>
                            <td>Masteral Students</td>
                            <td align="center">
                                <span id="Chart1Data1" class="badge">
                                    <?php 
										$Data1 = $Functions->ReportCourse("MASTERAL");
										for($x=0,$Total1=0;$x<count($Data1[0]);$x++){
											$Total1 += $Data1[1][$x];
										}
										echo $Total1;
									?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="DataMarker" id="Data1Marker2"></div></td>
                            <td>Doctoral Students</td>
                            <td align="center">
                                <span id="Chart1Data2" class="badge">
                                    <?php 
                                        $Data2 = $Functions->ReportCourse("DOCTORAL");
										for($x=0,$Total2=0;$x<count($Data2[0]);$x++){
											$Total2 += $Data2[1][$x];
										}
										echo $Total2;
                                    ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">
                                <h3>Total 
                                    <span id="Chart1Data2" class="Right">
                                        <span class="label label-primary">
                                            <?php echo $Total1+$Total2;?>
                                        </span>
                                    </span>
                                </h3>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
<?php
}
else if(isset($_GET['ChartCourse'])){
?>
<table class="table">
    <tr>
        <td width="40%">
            <div class="panel panel-primary Right">
                <div class="panel-heading">Legend to Masteral's Data</div>
                <div class="panel-body">
                	<canvas id="Chart2A" width="400px" height="400px"></canvas>
                </div>
                <table class="table table-striped">
                    <?php
                        $StudentCount = 0;
                        $Data = $Functions->ReportCourse("MASTERAL");
                        for($x=0;$x<count($Data[0]);$x++){
                            $StudentCount += $Data[1][$x];
                            echo '<tr><td><h6><div class="DataMarker" id="DataMarker'.$x.'"></div></h6></td><td><h6>'.$Data[0][$x].'</h6></td><td align="center"><h6><span id="ChartMasteral'.$x.'" class="badge">'.$Data[1][$x].'</span></h6></td></tr>';
                        }
                        echo '<input type="hidden" value="'.$x.'" id="Chart2Data1"/>';
                    ?>
                    <tr><td colspan="3"><h3>Total <span id="Chart2DataTotal1" class="Right"><span class="label label-primary"><?php echo $StudentCount; ?></span></h3></span></td></tr>
                </table>
            </div>                        
        </td>
        <td width="40%">
            <div class="panel panel-primary">
                <div class="panel-heading">Legend to Doctoral's Data</div>
                <div class="panel-body">
                    <canvas id="Chart2B" width="400px" height="400px"></canvas>
                </div>
                <table class="table table-striped">
                    <?php
                        $Data = $Functions->ReportCourse("DOCTORAL");
                        $StudentCount = 0;
                        for($x=0;$x<count($Data[0]);$x++){
                            $StudentCount += $Data[1][$x];
                            echo '<tr><td><h6><div class="DataMarker" id="DataMarker2'.$x.'"></div></h6></td><td><h6>'.$Data[0][$x].'</h6></td><td align="center" width="50px"><h6><span id="ChartDoctoral'.$x.'" class="badge">'.$Data[1][$x].'</span></h6></td></tr>';
                        }
                        echo '<input type="hidden" value="'.$x.'" id="Chart2Data2"/>';
                    ?>
                    <tr><td colspan="3"><h3>Total <span id="Chart2DataTotal2" class="Right"><span class="label label-primary"><?php echo $StudentCount; ?></span></h3></span></td></tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<?php
}
else if(isset($_GET['ChartYear'])){
?><br/>
<table class="table">
    <tr>
        <td width="40%">
            <?php
                $Data = $Functions->ReportSem();
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">First Semester</div>
                <div class="panel-body" align="center">
                	<canvas id="Chart3A" width="400px" height="400px"></canvas>
                </div>
                <table class="table table-striped" border="0">
                    <tr>
                        <td width="5%"><h6><div class="DataMarker" id="Data3Marker1"></div></h6></td>
                        <td><h6>Masteral</h6></td>
                        <td width="5%">
                            <h6>
                                <span id="Chart3Data1" class="badge">
                                    <?php echo count(@$Data[0][0]); ?>
                                </span>
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td><h6><div class="DataMarker" id="Data3Marker2"></div></h6></td><td><h6>Doctoral</h6></td><td><h6><span id="Chart3Data2" class="badge"><?php echo count(@$Data[0][1]); ?></span></h6></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><h3>Total <span id="Chart3DataTotal1"><span class="label label-primary"><?php echo count(@$Data[0][0])+count(@$Data[0][1]); ?></span></span></h3></td>
                    </tr>
                </table>
            </div>
        </td>
        <td width="40%">
            <?php
            $Data = $Functions->ReportSem();
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">Second Semester</div>
                <div class="panel-body" align="center">
                	<canvas id="Chart3B" width="400px" height="400px"></canvas>
                </div>
                <table class="table table-striped">
                    <tr>
                        <td width="5%"><h6><div class="DataMarker" id="Data3Marker3"></div></h6></td>
                        <td><h6>Masteral</h6></td>
                        <td width="5%">
                            <h6>
                                <span id="Chart3Data3" class="badge">
                                    <?php echo count(@$Data[1][0]); ?>
                                </span>
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td><h6><div class="DataMarker" id="Data3Marker4"></div></h6></td><td><h6>Doctoral</h6></td><td><h6><span id="Chart3Data4" class="badge"><?php echo count(@$Data[1][1]); ?></span></h6></td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3" align="right"><h3>Total <span id="Chart3DataTotal2"><span class="label label-primary"><?php echo @$Data[1][0]+@$Data[1][1]; ?></span></span></h3></td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<?php
}

?>