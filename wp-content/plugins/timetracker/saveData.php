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

    $filename = $id."_".$time.'.png';
    $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
    $wp_filesystem->put_contents('img/screen/'.$filename, $file, FS_CHMOD_FILE);
    return $filename;
  }

  function insertScreenCapture($time,$file,$user) {
    require('../../../wp-load.php');
    global $wpdb;
    $timeDate =  date('Y-m-d H:i:s', $time);

    $ret = $wpdb->insert('tbl_screencapture', array('id' => $time,'date_time' => $timeDate,'screen' => $file,'user' => $user),array('%s','%s','%s','%s'));

    print_r($ret);
  }
?>