<?php 
include("PHPFiles/DBConnection.php"); 
include("PHPFiles/Functions.php"); 
$Functions = new FunctionsExt;
if(isset($_POST['LogInSubmit'])){
	$UName = $_POST['PostUsername'];
	$Password = $_POST['PostPassword'];
	$PWord = sha1($_POST['PostPassword']);
	if(!empty($UName) && !empty($Password)){
		$z = $Functions->LogIn($UName,$PWord);
	}
	else{
		if(empty($PWord) || empty($UName)){
			$z = '<b>LOG IN ERROR:</b> Password and Username field is required.';	
		}
		else if(empty($Password)){
			$z = '<b>LOG IN ERROR:</b> Password field is required.';	
		}     
		else if(empty($UName)){
			$z = '<b>LOG IN ERROR:</b> Username field is required.';	
		}
	}
}

?>
<style>
	#Content{overflow:hidden !important;}
</style>
<!doctype html>
<html>
<head>
    <title>EnrolmentSystem [Log In]</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="JQuery/JQuery.js"></script>
    <script type="text/javascript" src="JQuery/JS.js"></script>
    <script type="text/javascript" src="BOOTSTRAP/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="BOOTSTRAP/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="BOOTSTRAP/css/bootstrap-theme.min.css" type="text/css">
    <link rel="stylesheet" href="CSS/General.css" type="text/css">
    <link rel="icon" href="Images/GSLOGO.png">
</head>

<body>
    <br/>
    <div align="center">
        <?php
        if(isset($_POST['LogInSubmit'])){
        ?>
            <div class="panel panel-default Long2">
                <div class="panel-body">
                    <?php echo $z; ?>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="panel panel-default Long2">
            <div class="panel-body">
                <h2 id="Login">PSU-OUS<br/>Enrolment System</h2><br/><br/>
                <div id="Logo"><img src="Images/GSLOGO.png" draggable="false" class="img-thumbnail"></div>
                <form action="" method="post">
                    <div class='col-md-12'>
                        <input type="text" class="form-control" placeholder="Username" name="PostUsername" id="Uname"/><br/>
                        <input type="password" class="form-control" placeholder="Password" name="PostPassword" id="PWord"/><br/>
                        <input type="submit" name="LogInSubmit" value="Log In" class="btn btn-success btn-sm"/>
                    </div>
                </form>
            </div>
        </div>
                
        </div>
    </div>
</body>
</html>