<?php
  require_once('include.php');
  require_once(MODELDIR.'user.class.php');
?>

<?php
class UserTest
{
  function setUp()
  {
    $this->defaultuser = getDefaultUser();
  }
  
  function testClone()
  {
    $usercopied = cloneUser($this->defaultuser);
    assertUsersEqual($this->defaultuser, $usercopied, true); 
    $usercopied = cloneUser(NULL);
    assert($usercopied==NULL);
  }
}

$test = new UserTest();
$test->setUp();
$test->testClone();
print 'all tests passed.'
?>