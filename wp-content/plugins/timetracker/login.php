<?php
  // require(dirname(__FILE__).'/wp-load.php');
  require('../../../wp-load.php');
  $data = $_POST['data'];
  $username = $data[0]['value'];
  $password = $data[1]['value'];

  if(!empty($username) && !empty($password)){
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => true
    );

    $user = wp_signon($creds,false);
    if(is_wp_error($user)){
        echo 0;
    }
    else{
      $data = $user->data;
      print_r(json_encode($data));
    }
  }
  else{
    echo 0;
  }


?>