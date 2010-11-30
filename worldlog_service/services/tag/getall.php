<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');

  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $tagdao = new TagDao($db);
  $tags = $tagdao->loadAll();
  $db->close();
  print tagsToXML($tags);
?>
