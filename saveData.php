<?php
  require('../../../wp-load.php');

  $data = $_POST['data'];
  $date = new DateTime();
  $timeStamp = $date->getTimestamp();

  $filename = saveImage($data[0],$data[1],$timeStamp);
  insertScreenCapture($timeStamp,$filename,$data[0]);

  function saveImage($id,$file,$time){
    if (empty($wp_filesystem)) {
        require_once(ABSPATH.'/wp-admin/includes/file.php');
        WP_Filesystem();
    }
    global $wp_filesystem;

    $filename = $id."_".$time.'.rng';
    $wp_filesystem->put_contents('img/'.$filename, $file, FS_CHMOD_FILE);
    return $filename;
  }

  function insertScreenCapture($time,$file,$user) {
    require('../../../wp-load.php');
    global $wpdb;
    $table_name = $wpdb->prefix."tbl_screenCapture";
    $timeDate =  date('Y-m-d H:i:s', $time);

    $wpdb->insert('tbl_screenCapture', array('id' => $time,'date_time' => $timeDate,'screen' => $file,'user' => $user),array('%s','%s','%s','%s'));
  }
?>