<?php
  function getDBHelper()
  {
    $base = 'worldlog_db';
    $server = 'localhost';
    $user = 'root';
    $pass = 'pass';
    
    return new DBHelper($base, $server, $user, $pass, true);
  }
?>
