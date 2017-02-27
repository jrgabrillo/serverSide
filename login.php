<?php
	require(dirname(__FILE__).'/wp-load.php');
	$data = $_POST['data'];
	$username = $data[0]['value'];
	$password = $data[1]['value'];

    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => true
    );

    $user = wp_signon($creds,false);
    if(is_wp_error($user)){
        echo 0;
        // echo $user->get_error_message();
    }
    else{
    	$data = $user->data;
    	print_r(json_encode($data));
		// $query = $wpdb->get_results("SELECT * FROM tbl_posts");
		// print_r($query);
    }

?>