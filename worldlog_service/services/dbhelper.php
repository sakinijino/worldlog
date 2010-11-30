<?php
  function getDBHelper()
  {
    $base = 'uk2016887_db';
    $server = 'localhost';
    $user = 'uk2016887';
    $pass = 'm8n3q1n2';
    
    return new DBHelper($base, $server, $user, $pass, true);
  }
?>