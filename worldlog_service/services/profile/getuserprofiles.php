<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  
  $userid = getParam('userid');
  if ($userid == "") $userid = $_SESSION['user_id'];
  if ($userid == null) {
    print profilesToXML(array());
    exit;
  }

  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $profiledao = new ProfileDao($db);
  $itemdao = new ItemDao($db);
  $profiles = $profiledao->loadByUserID(0+$userid);
  
  foreach ($profiles as $index => $profile){
	  $profiles[$index]->items = $itemdao->loadByProfileID($profile->id);
	}
  $db->close();
  print profilesToXML($profiles);
?>