<?php
  require_once('db.class.php');

  class DBhelper
  {
    var $base;
    var $server;
    var $user;
    var $pass;
    var $debug;
    
    function DBhelper($base, $server, $user, $pass, $debug=false)
    {
      $this->base = $base;
      $this->server = $server;
      $this->user = $user;
      $this->pass = $pass;
      $this->debug = $debug;
    }
    
    function connect()
    {
      $db = new db($this->base, $this->server, $this->user, $this->pass);
      //$db->defaultDebug = $debug;
      return $db;
    }
  }
?>