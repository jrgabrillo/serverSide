<?php
  // require(dirname(__FILE__).'/wp-load.php');
  require('../../../wp-load.php');

  if(isset($_GET['getFeeds'])){
    $data = [];
    $screen = get_users();
    foreach ($screen as $key => $value) {
      $userScreen = getScreen($value->data->ID);
      $data[] = [[$value->roles,$value->data],$userScreen];
    }
    print_r(json_encode($data));
  }

  if(isset($_GET['getUsers'])){
    $data = [];
    $screen = get_users();
    foreach ($screen as $key => $value) {
      $data[] = [$value->roles,$value->data];
    }
    print_r(json_encode($data));
  }

  if(isset($_GET['getFreq'])){
    // echo '10m';
    echo '20s';
  }

  function getScreen($ID){
    global $wpdb;
    $screen = $wpdb->get_results("SELECT * FROM tbl_screencapture WHERE user = '$ID' ORDER BY date_time DESC");
    return json_encode($screen);
  }

?>