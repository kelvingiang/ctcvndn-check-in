<?php

define('WP_USE_THEMES', false);
require('../../../../wp-load.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$barcode = $_POST['id'];
$event = $_POST['event'];

// echo $barcode .'----'.$event;

// die();

if (!empty($barcode)) {
  global $wpdb;
  $table_member   = $wpdb->prefix . 'check_in_member';
  $table_detail  = $wpdb->prefix . 'check_in_detail';


  $sqlMember    = "SELECT * FROM $table_member WHERE qr_code = '$barcode'";
  $rowMember   = $wpdb->get_row($sqlMember, ARRAY_A);


  if (!empty($rowMember) && $rowMember['trash'] == 0) {

    // add 11/10/2017 KIEM TRA SO LAN CHECK IN =======================================================================================  
    // $sql2 = "SELECT time, date,  (SELECT COUNT(*) FROM $table_detail WHERE check_in_id =" . $row['ID'] . ") as count FROM $table_detail WHERE check_in_id =" . $row['ID'] . " ORDER BY time DESC LIMIT 1";
    // $row2 = $wpdb->get_row($sql2, ARRAY_A);
    $sqlDetail = "SELECT * FROM $table_detail WHERE member_id = '" . $rowMember['ID'] . "'AND event_id = '" . $event . "'";
    $rowDetail = $wpdb->get_row($sqlDetail, ARRAY_A);

 

    if ($rowDetail['ID'] == '') {
      $data = array(
        'member_id' => $rowMember['ID'],
        'event_id' => $event,
        'time' => date('H:i:s'),
        'date' => date('m-d-Y'),
      );
      $wpdb->insert($table_detail, $data);
      $checked = 0;
    }else{
      $checked = 1;
    }
    // end ================================================================================================    

    $info = array(
      'contact' => $rowMember['contact'],
      'member_code' => $rowMember['member_code'],
      'company_cn' =>  $rowMember['company_cn'],
      'company_vn' =>  $rowMember['company_vn'],
      'position' => $rowMember['position'],
      'address' => $rowMember['address'],
      'email' => $rowMember['email'],
      'phone' => $rowMember['phone'],
      'career' => $rowMember['career'],
      // // 'Img' => $img,
      // 'TotalTimes' => $row2['count'] + 1,
      // 'LastCheckIn' => $row2['date'] . ' / ' . $row2['time']
    );
    $response = array('status' => 'done', 'message' => $rowMember['ID'],'check'=>$checked, 'info' => $info);
    // end ================================================================================================     
  } elseif ($rowMember['trash'] == 1) {
    $response = array('status' => 'unactive', 'message' => 'chua kich hoat tai khoan');
  } else {
    $response = array('status' => 'error', 'message' => '0000');
  }

  echo json_encode($response);
}
