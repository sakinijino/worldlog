<?php
  require_once('include.php');
  require_once(MODELDIR.'user.class.php');
  require_once(DAODIR.'userdao.class.php');
?>

<?php
class UserDaoTest extends DBTestBase
{
  var $userdao;
  var $defaultuser;

  function setUpForAllTests()
  {
    parent::setUpForAllTests();
    
    $this->userdao = new UserDao();
    $this->defaultuser = getDefaultUser();
  }
  
  function setUpDB()
  {
    $this->userdao->db = $this->db;
    $this->defaultuser->id = $this->userdao->save($this->defaultuser); 
  }
  
  function testSelectByName()
  {
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    assertUsersEqual($this->defaultuser, $userloaded, true);
  }
  
  function testSelectByNameAndPassword()
  {
    $userloaded = $this->userdao->loadByNameAndPassword($this->defaultuser->name,
                                                        $this->defaultuser->password);
    assertUsersEqual($this->defaultuser, $userloaded, true);
  }
  
  function testSaveAndSelectByID()
  {
    $insertedid = $this->userdao->save($this->defaultuser);
    $userloaded = $this->userdao->loadByID($insertedid);
    assertUsersEqual($this->defaultuser, $userloaded);
  }
  
  function testSelectWithWrongName()
  {
    $userloaded = $this->userdao->loadByName("wrong name");
    assert($userloaded == NULL);
  }
  
  function testSelectWithWrongPassword()
  {
    $this->userdao->save($this->defaultuser);
    $userloaded = $this->userdao->loadByNameAndPassword($this->defaultuser->name,
                                                        'wrong password');
    assert($userloaded == NULL);
  }
  
  function testDelete()
  {
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    $this->userdao->delete($userloaded);
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    assert($userloaded == NULL);
  }
  
  function testUpdate()
  {
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    $userloaded->nickname = 'Saki Nijino';
    $usermodified = cloneUser($userloaded);
    $this->userdao->update($usermodified);
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    assertUsersEqual($userloaded, $usermodified, true);
  }
}

$test = new UserDaoTest();
$test->tearDown();
$test->setUpForAllTests();

$test->setUp();
$test->testSelectByName(); //!!!two lines are inserted...???!!!
$test->tearDown();

$test->setUp();
$test->testSaveAndSelectByID();
$test->tearDown();

$test->setUp();
$test->testSelectByNameAndPassword();
$test->tearDown();

$test->setUp();
$test->testSelectWithWrongName();
$test->tearDown();

$test->setUp();
$test->testSelectWithWrongPassword();
$test->tearDown();

$test->setUp();
$test->testDelete();
$test->tearDown();

$test->setUp();
$test->testUpdate();
$test->tearDown();
print 'all tests passed.'
?>