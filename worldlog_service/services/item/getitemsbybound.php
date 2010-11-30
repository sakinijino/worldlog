<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');

  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $itemdao = new ItemDao($db);
  $items = $itemdao->loadByBounds(0+getParam('maxlnt'), 
                                 0+getParam('minlnt'), 
                                 0+getParam('maxlat'), 
                                 0+getParam('minlat'),
                                 0,
                                 100);
  $db->close();
  print itemsToXML($items);
?>
