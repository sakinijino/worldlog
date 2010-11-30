<?php
  function getTestDBHelper()
  {
    $base = 'uk2016887_db_test';
    $server = 'localhost';
    $user = 'uk2016887';
    $pass = 'm8n3q1n2';
    
    return new DBHelper($base, $server, $user, $pass, true);
  }
  
  function clearTestDB()
  {
    $dbhelper = getTestDBHelper();
    $db = $dbhelper->connect();
    $db->query('set foreign_key_checks=0');
    $db->query('delete from worldlog_users');
    $db->query('delete from worldlog_profiles');
    $db->query('delete from worldlog_tags');
    $db->query('delete from worldlog_items');
    $db->query('delete from worldlog_resources');
    $db->query('delete from worldlog_item_ratings');
    $db->query('delete from worldlog_item_tag;');
    $db->query('delete from worldlog_profile_item;');
    $db->query('set foreign_key_checks=1');
    $db->close();
  }
  
class DBTestBase 
{
  var $db = NULL;
  var $dbhelper;
  
  function setUpForAllTests()
  {
    $this->dbhelper = getTestDBHelper();
  }
  
  function setUp()
  {
    $this->db = $this->dbhelper->connect();
    $this->setUpDB();
  }
  
  function tearDown()
  {
    if ($this->db!=NULL) 
      $this->db->close();
    clearTestDB();
  }
} 
?> 