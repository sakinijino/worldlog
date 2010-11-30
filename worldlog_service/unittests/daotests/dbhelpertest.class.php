<?php
  require_once('include.php');
  require_once(DAODIR.'dbhelper.class.php');
?>

<?php
class DBhelperTest
{
  function testConstructor()
  {
    $dbhelper = new DBhelper('uk2016887_db_test', 'localhost', 
                             'uk2016887', 'm8n3q1n2');
    assert($dbhelper->base == 'uk2016887_db_test');
    assert($dbhelper->server == 'localhost');
    assert($dbhelper->user == 'uk2016887');
    assert($dbhelper->pass == 'm8n3q1n2');
  }
}

$test = new DBhelperTest();
$test->testConstructor();
print 'all tests passed.'
?>