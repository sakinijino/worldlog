<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  
  $userid = getParam('userid');
  if ($userid == "") $userid = $_SESSION['user_id'];
  if ($userid == null) {
    print itemsToXML(array());
    exit;
  }

  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $itemdao = new ItemDao($db);
  $items = $itemdao->loadByUserID(0+$userid);
  $db->close();
  print itemsToXML($items);
?>