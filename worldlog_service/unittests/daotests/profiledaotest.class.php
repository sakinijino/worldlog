<?php
  require_once('include.php');
  require_once(MODELDIR.'profile.class.php');
  require_once(MODELDIR.'user.class.php');
  require_once(DAODIR.'profiledao.class.php');
  require_once(DAODIR.'userdao.class.php');
?>

<?php
class ProfileDaoTest extends DBTestBase
{
  var $profiledao;
  var $userdao;
  var $defaultuser;
  var $defaultprofile1;
  var $defaultprofile2;
  
  function setUpForAllTests()
  {
    parent::setUpForAllTests();
    
    $this->userdao = new UserDao();
    $this->profiledao = new ProfileDao();

    $this->defaultuser = getDefaultUser(); 
    $this->defaultprofile1 = getDefaultProfile();
    $this->defaultprofile2 = cloneProfile($this->defaultprofile1);
    $this->defaultprofile2->name = 'THU';
  }
  
  function setUpDB()
  {
    $this->userdao->db = $this->db;
    $this->profiledao->db = $this->db;
    $userid = $this->userdao->save($this->defaultuser);
    $this->defaultprofile1->user_id = $userid;
    $this->defaultprofile2->user_id = $userid;
    $this->profiledao->save($this->defaultprofile1);
    $this->profiledao->save($this->defaultprofile2);
  }
  
  function testSelectByUserID()
  {
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    $profiles = $this->profiledao->loadByUserID($userloaded->id);
    
    foreach ($profiles as $profile)
      if ($profile->name == $this->defaultprofile1->name)
        assertProfilesEqual($profile, $this->defaultprofile1);
      else
        assertProfilesEqual($profile, $this->defaultprofile2);
  }
  
  function testSelectByID()
  {
    $this->defaultprofile1->user_id = $this->userdao->save($this->defaultuser);
    $insertid = $this->profiledao->save($this->defaultprofile1);
    
    $profile = $this->profiledao->loadByID($insertid);
    assertProfilesEqual($profile, $this->defaultprofile1);
  }
  
  function testDelete()
  {
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    $profiles = $this->profiledao->loadByUserID($userloaded->id);
    
    foreach ($profiles as $profile)
      $this->profiledao->delete($profile);
    $profiles = $this->profiledao->loadByUserID($userloaded->id);
    assert(count($profiles)==0);
  }
  
  function testUpdate()
  {
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    $profiles = $this->profiledao->loadByUserID($userloaded->id);
    $profile = $this->profiledao->loadByID($profiles[0]->id);
    
    $profile->longitude = 190.567;
    $this->profiledao->update($profile);
    $profileUpdated = $this->profiledao->loadByID($profile->id);
    assertProfilesEqual($profile, $profileUpdated, true);
  }
}

$test = new ProfileDaoTest();
$test->tearDown();
$test->setUpForAllTests();

$test->setUp();
$test->testSelectByUserID();
$test->tearDown();

$test->setUp();
$test->testSelectByID();
$test->tearDown();

$test->setUp();
$test->testDelete();
$test->tearDown();

$test->setUp();
$test->testUpdate();
$test->tearDown();
print 'all tests passed.'
?>