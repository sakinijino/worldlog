<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');

  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $itemdao = new ItemDao($db);
  $items = $itemdao->loadByIDLimit(0, 0+getParam('num'));
  $db->close();
  print itemsToXML($items);
?>
