<?php
//secure this file
include("Functions.php");
session_start();
$function = new DatabaseClasses;

    if (isset($_GET['kill-session'])){
        print_r(session_destroy());
    }

	if(isset($_GET['chkConnection'])){
		print_r($function->chkConnection());
	}

	if(isset($_GET['createDB'])){
		$data = $function->createDB('db_k12');
		if($data == 1){
			echo 1;
		}
	}

	if(isset($_GET['createTables'])){
		$fileDir = '../db/k12.sql';
		if(file_exists($fileDir)){
			$query = file_get_contents($fileDir);
			$query = $function->PDO(false,$query);
			if($query->execute()){
				echo 1;
			}
			else{
				echo 0;
			}
		}
		else{
			echo 0;
		}
	}

	if(isset($_GET['restoreTablesFromFile'])){
		$data = $_POST['data'];
		print_r($data);
		$query = $function->PDO(false,$data);
		if($query->execute()){
			echo 1;
		}
		else{
			echo 0;
		}
	}

	if(isset($_GET['login'])){
		$data = $_POST['data'];
		$username = $data[0]['value'];
		$password = sha1($data[1]['value']);
		$date = new DateTime();
		$hash = $date->getTimestamp();
		$query = $function->PDO(true,"SELECT * FROM tbl_admin WHERE username = '{$username}' AND password = '{$password}'");
		if(count($query)>0){
			$_SESSION["data"] = [$username,$password,$hash];
			// print_r(json_encode($query));
			print_r("admin");
		}
		else{
			$query = $function->PDO(true,"SELECT * FROM tbl_employer WHERE username = '{$username}' AND password = '{$password}'");
			if(count($query)>0){
				$_SESSION["data"] = [$username,$password,$hash];
				// print_r(json_encode($query));
				print_r("employer");
			}
			else{
				echo 0;
			}
		}
	}

	//getters
	if(isset($_GET['get-listAdmin'])){
		$query = $function->PDO(true,"SELECT * FROM tbl_admin WHERE status = '1'");
		print_r(json_encode($query));
	}

	if(isset($_GET['get-admin'])){
		$query = $function->PDO(true,"SELECT * FROM tbl_admin WHERE username = '{$_SESSION['data'][0]}' AND password = '{$_SESSION['data'][1]}'");
		print_r(json_encode($query));
	}

	if(isset($_GET['get-products'])){
		$query = $function->PDO(true,"SELECT * FROM tbl_product WHERE status = 1 ORDER BY `date` DESC");
		print_r(json_encode($query));
	}

	if(isset($_GET['get-clients'])){
		$query = $function->PDO(true,"SELECT * FROM tbl_employer WHERE status = 1 ORDER BY `date` DESC");
		print_r(json_encode($query));
	}

	if(isset($_GET['get-employee'])){
		$query = $function->PDO(true,"SELECT * FROM tbl_employee WHERE status = 1 ORDER BY `date` DESC");
		print_r(json_encode($query));
	}

	//setters
	if(isset($_GET['set-newAdmin'])){
        $id = $function->PDO_IDGenerator('tbl_admin','id');
		$date = $function->PDO_DateAndTime();
		$data = $_POST['data'];

		$password = sha1($data[3]['value']);
		$capabilities = $data[4]['value'];
		$query = $function->PDO(false,"INSERT INTO tbl_admin(id,name,username,password,capabilities,email,status,`date`) VALUES ('{$id}','{$data[0]['value']}','{$data[2]['value']}','{$password}','{$capabilities}','{$data[1]['value']}','1','{$date}')");
		if($query->execute()){
			echo 1;
		}
		else{
			$Data = $query->errorInfo();
			print_r($Data);
		}
	}

	if(isset($_GET['set-newProduct'])){
		$data = $_POST['data'];
        $id = $function->PDO_IDGenerator('tbl_product','id');
		$date = $function->PDO_DateAndTime();

		$user = $function->PDO(true,"SELECT * FROM tbl_admin WHERE username = '{$_SESSION['data'][0]}' AND password = '{$_SESSION['data'][1]}'");
		$user = $user[0][0];

		$query = $function->PDO(false,"INSERT INTO tbl_product(id,product_name,qty,price,category,description,status,`date`,addedby,lastupdateby) VALUES ('{$id}','{$data[0]['value']}','{$data[1]['value']}','{$data[2]['value']}','{$data[4]['value']}','{$data[3]['value']}','1','{$date}','{$user}','{$user}')");
		if($query->execute()){
			echo 1;	
		}
		else{
			$Data = $query->errorInfo();
			print_r($Data);
		}
	}	

	if(isset($_GET['set-newClient'])){
		$data = $_POST['data'];
        $id = $function->PDO_IDGenerator('tbl_employer','id');
		$date = $function->PDO_DateAndTime();

		$user = $function->PDO(true,"SELECT * FROM tbl_admin WHERE username = '{$_SESSION['data'][0]}' AND password = '{$_SESSION['data'][1]}'");
		$user = $user[0][0];
		if(count($user)==1){
			$log = $function->log("add",$user[0][0],"Attempt to add employer with an id of \'".$id."\' in tbl_employer.");
			$password = sha1($data[5]['value']);
			$query = $function->PDO(false,"INSERT INTO tbl_employer(id,name,email,phonenumber,address,avatar,username,password,status,`date`) VALUES ('{$id}','{$data[0]['value']}','{$data[2]['value']}','{$data[1]['value']}','{$data[3]['value']}','','{$data[4]['value']}','{$password}','1','{$date}')");
			if($query->execute()){
				if(is_array($log)){
					$function->log($log,$user[0][0],"Added employer with an id of \'".$id."\' in tbl_employer.");
				}
				echo 1;
			}
			else{
				$Data = $query->errorInfo();
				print_r($Data);
			}
		}
		else{
			echo 0;
		}
	}	

	if(isset($_GET['set-newBulkEmployee'])){
		$data = $_POST['data'];
		$data = json_decode($data);
		$date = $function->PDO_DateAndTime();
		$q1 = ""; $count = 0;

		$user = $function->PDO(true,"SELECT * FROM tbl_employer WHERE username = '{$_SESSION['data'][0]}' AND password = '{$_SESSION['data'][1]}'");
		print_r($user);
		// $user = $user[0][0];
		// $numEmployees = $function->PDO(true,"SELECT * FROM tbl_employee WHERE employer_id = '{$user}'");
		// $count = count($numEmployees);

		// foreach ($data as $key => $value) {
		// 	$dob = date("m/j/Y",strtotime($value[3]));
		// 	$email = (count($value)>5)?$value[5]:"";
	 //        $id = $user.'-'.($count++);
	 //        $password = sha1($id);
	 //        if((count($data)-1) <= $key){
		// 		$q1 .= "('{$id}','{$value[0]}','{$user}','{$password}','{$value[2]}','{$value[1]}','{$value[4]}','{$dob}','{$email}','1','{$date}')";
	 //        }
	 //        else{
		// 		$q1 .= "('{$id}','{$value[0]}','{$user}','{$password}','{$value[2]}','{$value[1]}','{$value[4]}','{$dob}','{$email}','1','{$date}'),";
	 //        }
		// }

		// print_r("INSERT INTO  tbl_employee(id,emplyee_id,employer_id,password,family_name,given_name,gender,date_of_birth,email_address,status,`date`) VALUES".$q1);

		// $query = $function->PDO(false,"INSERT INTO  tbl_employee(id,emplyee_id,employer_id,password,family_name,given_name,gender,date_of_birth,email_address,status,`date`) VALUES".$q1);
		// if($query->execute()){
		// 	echo 1;
		// }
		// else{
		// 	$Data = $query->errorInfo();
		// 	print_r($Data);
		// }
	}	

	//deleters
    if(isset($_GET['delete-sublevelsubject'])){
		$data = $_POST['data'];
		$newdata = [];
		$subject_id = $data[0];
		$subject_code = $data[1][0];
		$subject_title = $data[1][1];
		$subject_discription = $data[1][2];
        $Query = $function->PDO_SQL("SELECT * FROM tbl_subject WHERE id = '{$subject_id}'");
        $data = json_decode($Query[0][2]);

        foreach ($data as $i => $v) {
        	if(count($v)==0){
        		$newdata[] = $v;
        	}
        	else{
        		if(($v[1] == $subject_code) && ($v[0] == $subject_title) && ($v[2] == $subject_discription)){
        			// echo "code: {$subject_code}, title: {$subject_title}, value: {$subject_discription}";
        		}
        		else{
	        		$newdata[] = $v;
        		}        		
        	}
        }
        $data = json_encode($newdata);

		$QueryString = "UPDATE tbl_subject SET subject_title = '{$data}' WHERE id = '{$subject_id}'";
		$Query = $function->PDO_SQLQuery($QueryString);
		if($Query->execute())
			echo 1;
		else{
			print_r(json_encode([$query->errorInfo()]));
		}
    }

    //backups
    if(isset($_GET['buckup-db'])){
		$db = $function->db_buckup();
    	// print_r($db);
        $file = sha1('rufongabrillojr').'-'.time().'.sql';
        $handle = fopen('../db/'.$file, 'w+');

        if(fwrite($handle, $db)){
        	fclose($handle);
        	print_r(json_encode([1,$file]));
        }
    }	

    if(isset($_GET['get-dbFiles'])){
    	$dir = '../db';$_files = [];$data = "";
		$files = array_diff(scandir($dir), array('..', '.'));
		foreach ($files as $i => $v){
			$data = stat($dir."/".$v);
			$data = date("F j, Y",$data['mtime']);
			$_files[] = [$v,$data];
		}
		// print_r($_files);
		print_r(json_encode($_files));
    }
    
    if(isset($_GET['send-mail'])){
        $data = $_POST['data'];

        $message = "<div style='text-align: center;width: 500px;position: relative;margin: 0 auto;border-radius: 3px;background: #4485F4;color: #fff;padding: 30px;border-top: yellow solid 10px;top: 50px;box-shadow: 0px 0px 50px #ccc;margin-top: 50px;margin-bottom: 50px;'><b><font size='6'>Welcome to KABOOM REWARDS</font></b><br/><br/><br/>Thank you for registering to KABOOM REWARDS. Here is your&nbsp;system generated password: {$data[1]}&nbsp;<br/><br/><br/>Please change your password as soon as you get in to your account. <br/>Powered By: <a href='http://rnrdigitalconsultancy.com/' style='color: #fff;'>RNR Digital Consultancy</a> &nbsp;<br/><br/><br/>Thanks and God bless.</div> ";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: PSU Jobs <apparato.net>' . "\r\n";
        $subject = 'PSU Job Portal - Applicant Account Registration';

        $result = mail($data[0],$subject,$message,$headers);
    }

?>