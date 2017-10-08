<?php
include("Functions.php");
session_start();
$function = new DatabaseClasses;

if(isset($_GET['authenticate'])){
	$data = $_POST['data'];
	$username = $data['username'];
	$date = new DateTime();
	$hash = $date->getTimestamp();

	if($username == 'judge'){
		$password = $data['password'];
		$query = $function->PDO(true,"SELECT * FROM tbl_judges WHERE access_code = '{$password}'");
	}
	else{
		$password = sha1($data['password']);
		$query = $function->PDO(true,"SELECT * FROM tbl_user WHERE user_name = '{$username}' AND user_password = '{$password}'");
	}
	if(count($query)>0){
		$_SESSION["data"] = [$username,$password,$hash];
		print_r(json_encode($query));
	}
	else{
		echo 0;
	}
}

if(isset($_GET['signout'])){
	$data = session_destroy();
	print_r($data);
}

if(isset($_GET['isSignIn'])){
	print_r(json_encode($_SESSION));
}

if(isset($_GET['getJudgeInfo'])){
	$data = $_POST['data'];
	$query = $function->PDO(true,"SELECT * FROM tbl_judges WHERE access_code = '{$data}'");
	print_r(json_encode($query));
}

if(isset($_GET['getCriteria'])){
	$query = $function->PDO(true,"SELECT * FROM tbl_criteria");
	print_r(json_encode($query));
}

if(isset($_GET['setCriteria'])){
	$data = $_POST['data'];
    $id = $function->PDO_IDGenerator('tbl_criteria','id');
    $data = json_decode($data);
    $jsondata = json_encode($data[0]);

    if($data[1] == 'insert' ){
		$query = $function->PDO(false,"INSERT INTO tbl_criteria(id,criteria) VALUES('{$id}','{$jsondata}')");
		if($query->execute()){
			echo 1;
		}
		else{
			$Data = $query->errorInfo();
			print_r($Data);
		}
    }
    else{
		$query = $function->PDO(false,"UPDATE tbl_criteria SET criteria = '{$jsondata}'");
		if($query->execute()){
			echo 1;
		}
		else{
			$Data = $query->errorInfo();
			print_r($Data);
		}
    }
}

if(isset($_GET['getCandidate'])){
	$data = $_POST['data'];
	$list = [];
	$query = $function->PDO(true,"SELECT DISTINCT(category) FROM tbl_contestant WHERE status='1' ORDER BY name ASC");
	foreach ($query as $key => $value) {
		$query2 = $function->PDO(true,"SELECT * FROM tbl_contestant WHERE category='{$value[0]}' ORDER BY name ASC");
		$list[] = [$value[0],$query2];
	}
	print_r(json_encode($list));
}

if(isset($_GET['getCandidateWithScores'])){
	$data = $_POST['data'];
	$list = [];
	$query = $function->PDO(true,"SELECT DISTINCT(category) FROM tbl_contestant WHERE status='1' ORDER BY name ASC");
	foreach ($query as $key => $value) {
		$query2 = $function->PDO(true,"SELECT * FROM tbl_contestant WHERE category='{$value[0]}' ORDER BY name ASC");
		$subList = [];
		foreach ($query2 as $key1 => $value1) {
			// print_r($value1);
			$queryCategory = $function->PDO(true,"SELECT * FROM tbl_score WHERE judge_id='{$data}' AND contestant_id='{$value1[0]}'");
			if(count($queryCategory)>0){
				$subList[] = [$value1,$queryCategory[0]];				
			}
			else{
				$subList[] = [$value1,[]];								
			}
		}
		$list[] = [$value[0],$subList];
	}
	print_r(json_encode($list));
}

if(isset($_GET['setCandidate'])){
	$data = $_POST['data'];
	$status = 0;
    $id = $function->PDO_IDGenerator('tbl_contestant','id');
	$criteria = $function->PDO(true,"SELECT * FROM tbl_criteria");
    $name = json_encode([$data['contestantFirstName'],$data['contestantMiddleName'],$data['contestantLastName']]);

    if($data['contestantPicture'] == 'no-image'){
	    $file = 'avatar.jpg';
	    $status = 1;
	}
	else{
	    $file = $id.'-'.time().'.rng';
	    $handle = fopen('../img/'.$file, 'w+');
	    fwrite($handle, $data['contestantPicture']);
	    fclose($handle);
	    $status = 1;
	}

	if($status == 1){
		$query = $function->PDO(false,"INSERT INTO tbl_contestant(id,criteria_id,name,age,picture,category,detail,status) VALUES('{$id}','{$criteria[0][0]}','{$name}','{$data['contestantAge']}','{$file}','{$data['contestantCategory']}','{$data['contestantDetails']}','1')");
		if($query->execute()){
			echo 1;
		}
		else{
			$Data = $query->errorInfo();
			print_r($Data);
		}
	}
}

if(isset($_GET['deleteContestant'])){
	$data = $_POST['data'];
	// print_r($data);
	$query = $function->PDO(false,"DELETE FROM tbl_contestant WHERE id = '{$data}'"); 
	if($query->execute()){
		echo 1;
	}
	else{
		$Data = $query->errorInfo();
		print_r($Data);
	}
}

if(isset($_GET['setJudge'])){
	$data = $_POST['data'];
    $id = $function->PDO_IDGenerator('tbl_judges','id');
	$criteria = $function->PDO(true,"SELECT * FROM tbl_criteria");

	$accessCode = substr(sha1($data['judgeName']),0,8);

	$query = $function->PDO(false,"INSERT INTO tbl_judges(id,criteria_id,name,access_code,details,picture,status) VALUES('{$id}','{$criteria[0][0]}','{$data['judgeName']}','{$accessCode}','{$data['judgeDetails']}','avatar.jpg','1')");
	if($query->execute()){
		echo 1;
	}
	else{
		$Data = $query->errorInfo();
		print_r($Data);
	}
}

if(isset($_GET['getJudeges'])){
	$data = $_POST['data'];
	$query = $function->PDO(true,"SELECT * FROM tbl_judges WHERE status='1' ORDER BY name ASC");
	print_r(json_encode($query));
}

if(isset($_GET['getJudegeAccess'])){
	$data = $_POST['data'];
	$password = sha1($data[0]);

	$query = $function->PDO(true,"SELECT * FROM tbl_user WHERE user_password = '{$password}'");
	if(count($query)>0){
		$query = $function->PDO(true,"SELECT * FROM tbl_judges WHERE id='{$data[1]}'");
		print_r(json_encode($query));
	}
	else{
		echo 0;
	}
}

if(isset($_GET['deleteJudge'])){
	$data = $_POST['data'];
	$query = $function->PDO(false,"DELETE FROM tbl_judges WHERE id = '{$data}'"); 
	if($query->execute()){
		echo 1;
	}
	else{
		$Data = $query->errorInfo();
		print_r($Data);
	}
}

if(isset($_GET['saveGrade'])){
	$data = $_POST['data'];
	$data = json_decode($data);

	$query = $function->PDO(true,"SELECT * FROM tbl_score WHERE contestant_id='{$data[0]}' AND judge_id = '{$data[1]}'");
	if(count($query)<=0){
		$criteria = $function->PDO(true,"SELECT * FROM tbl_criteria WHERE status='1'");
	    $id = $function->PDO_IDGenerator('tbl_score','id');
	    $jsondata = json_encode($data[2]);

		$query = $function->PDO(false,"INSERT INTO tbl_score(id,criteria_id,contestant_id,judge_id,scores) VALUES('{$id}','{$criteria[0][0]}','{$data[0]}','{$data[1]}','{$jsondata}')");
		if($query->execute()){
			echo 1;
		}
		else{
			$Data = $query->errorInfo();
			print_r($Data);
		}
		//insert
	}
	else{
	    $jsondata = json_encode($data[2]);
		$query = $function->PDO(false,"UPDATE tbl_score SET scores = '{$jsondata}' WHERE contestant_id='{$data[0]}' AND judge_id = '{$data[1]}'");
		if($query->execute()){
			echo 1;
		}
		else{
			$Data = $query->errorInfo();
			print_r($Data);
		}
		//update
	}
}

// if(isset($_GET['getJudegesScores'])){
// 	$list = [];
// 	$criteria = $function->PDO(true,"SELECT * FROM tbl_criteria WHERE status='1'");
// 	$query = $function->PDO(true,"SELECT * FROM tbl_judges WHERE status='1' ORDER BY name ASC");
// 	foreach ($query as $key => $value) {
// 		$subList = [];
// 		$category = $function->PDO(true,"SELECT DISTINCT(category) FROM tbl_contestant WHERE status='1' ORDER BY name ASC");
// 		foreach ($category as $key1 => $value1) {
// 			$contestants = $function->PDO(true,"SELECT * FROM tbl_score INNER JOIN tbl_contestant WHERE tbl_contestant.category = '{$value1[0]}' AND tbl_score.contestant_id = tbl_contestant.id  AND tbl_score.judge_id='{$value[0]}' ORDER BY tbl_contestant.name ASC");
// 			$subList[] = [$value1[0]=>$contestants];
// 		}
// 		$list[] = [$value,$subList]; 
// 	}
// }


//this is all in one
// if(isset($_GET['getJudegesScores'])){
// 	$list = [];
// 	$criteria = $function->PDO(true,"SELECT * FROM tbl_criteria WHERE status='1'");
// 	$category = $function->PDO(true,"SELECT DISTINCT(category) FROM tbl_contestant WHERE status='1' ORDER BY name ASC");
// 	foreach ($category as $i => $v) {
// 		$query = $function->PDO_ASSOC("SELECT tbl_contestant.id,tbl_contestant.name AS c_name,tbl_contestant.picture AS c_picture,tbl_contestant.age,tbl_contestant.detail,tbl_contestant.status,tbl_contestant.category,tbl_score.contestant_id,tbl_score.judge_id,tbl_score.scores,tbl_judges.id,tbl_judges.name,tbl_judges.details,tbl_judges.picture FROM tbl_contestant INNER JOIN tbl_score,tbl_judges WHERE tbl_contestant.id = tbl_score.contestant_id AND tbl_contestant.status='1' AND tbl_contestant.category = '{$v[0]}' AND tbl_score.judge_id = tbl_judges.id ORDER BY tbl_contestant.name ASC");
// 		foreach ($query as $i2 => $v2) {
// 			print_r($v2);
// 		}

// 	}
// }

// almost perfect
// if(isset($_GET['getJudegesScores'])){
// 	$list = [];
// 	$criteria = $function->PDO(true,"SELECT * FROM tbl_criteria WHERE status='1'");
// 	$category = $function->PDO(true,"SELECT DISTINCT(category) FROM tbl_contestant WHERE status='1' ORDER BY name ASC");
// 	foreach ($category as $i => $v) {
// 		$subList = [];
// 		$query = $function->PDO(true,"SELECT * FROM tbl_contestant WHERE tbl_contestant.status='1' AND tbl_contestant.category = '{$v[0]}' ORDER BY tbl_contestant.name ASC");
// 		foreach ($query as $i2 => $v2) {
// 			$scores = $function->PDO(true,"SELECT tbl_score.scores,tbl_score.contestant_id,tbl_score.judge_id,tbl_judges.id,tbl_judges.name,tbl_judges.picture,tbl_judges.details FROM tbl_score INNER JOIN tbl_judges WHERE tbl_judges.id = tbl_score.judge_id AND tbl_score.contestant_id = '{$v2[0]}'");
// 			$subList[] = [$v2,$scores];
// 		}
// 		$list[] = [$v[0],$subList];
// 	}
// 	// print_r($list);
	
// 	print_r(json_encode([$criteria[0],$list]));
// }

// if(isset($_GET['getJudegesScores'])){
// 	$list = [];
// 	$criteria = $function->PDO(true,"SELECT * FROM tbl_criteria WHERE status='1'");
// 	$judges = $function->PDO(true,"SELECT name FROM tbl_judges WHERE status='1'");
// 	$category = $function->PDO(true,"SELECT DISTINCT(category) FROM tbl_contestant WHERE status='1' ORDER BY name ASC");
// 	foreach ($category as $i => $v) {
// 		$subList = [];
// 		$query = $function->PDO(true,"SELECT * FROM tbl_contestant WHERE tbl_contestant.status='1' AND tbl_contestant.category = '{$v[0]}' ORDER BY tbl_contestant.name ASC");
// 		foreach ($query as $i2 => $v2) {
// 			$scores = $function->PDO(true,"SELECT tbl_score.scores,tbl_score.contestant_id,tbl_score.judge_id,tbl_judges.id FROM tbl_judges INNER JOIN tbl_score WHERE tbl_score.judge_id = tbl_judges.id AND tbl_score.contestant_id = '{$v2[0]}'");
// 			$subList[] = [$v2,$scores];
// 		}
// 		$list[] = [$v[0],$subList];
// 	}
// 	// print_r($list);
	
// 	print_r(json_encode([$criteria[0][1],$judges,$list]));
// }

if(isset($_GET['getJudegesScores'])){
	$list = [];
	$criteria = $function->PDO(true,"SELECT * FROM tbl_criteria WHERE status='1'");
	$judges = $function->PDO(true,"SELECT name FROM tbl_judges WHERE status='1'");
	$category = $function->PDO(true,"SELECT DISTINCT(category) FROM tbl_contestant WHERE status='1' ORDER BY name ASC");
	foreach ($category as $i => $v) {
		$subList = [];
		$query = $function->PDO(true,"SELECT id,name,status,category FROM tbl_contestant WHERE tbl_contestant.status='1' AND tbl_contestant.category = '{$v[0]}' ORDER BY tbl_contestant.name ASC");
		foreach ($query as $i2 => $v2) {
			$scores = $function->PDO(true,"SELECT tbl_score.scores,tbl_score.contestant_id,tbl_score.judge_id,tbl_judges.id,tbl_judges.name FROM tbl_judges INNER JOIN tbl_score WHERE tbl_score.judge_id = tbl_judges.id AND tbl_score.contestant_id = '{$v2[0]}'");
			$string = "";
			foreach ($scores as $i3 => $v3) {
				if($i3>=(count($scores)-1))
					$string .= " tbl_judges.name != '{$v3[4]}' ";
				else
					$string .= " tbl_judges.name != '{$v3[4]}' AND ";
			}
			$notScores = $function->PDO(true,"SELECT tbl_judges.id,tbl_judges.name FROM tbl_judges WHERE $string");
			$scores[] = $notScores;
			$subList[] = [$v2,$scores];
		}
		$list[] = [$v[0],$subList];
	}
	print_r(json_encode([$criteria[0][1],$judges,$list]));
}

?>