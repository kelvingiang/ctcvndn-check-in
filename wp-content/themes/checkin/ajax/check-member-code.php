<?php

define('WP_USE_THEMES', false);
require('../../../../wp-load.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$memberCode = $_POST['memberCode'];
global $wpdb;
$table   = $wpdb->prefix . 'check_in_member';
$sql     = $wpdb->prepare("SELECT * FROM $table WHERE `member_code` = '%s'",  $memberCode);
$data    = $wpdb->get_row($sql, ARRAY_A);


if (!empty($data)) {
  $response = array('status' => 'exited', 'message' =>  '會員編號已存在');
} else {
  $response = array('status' => 'done', 'message' => '');
}

echo json_encode($response);
