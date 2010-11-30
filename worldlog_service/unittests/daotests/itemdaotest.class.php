<?php
  require_once("include.php");
  require_once(MODELDIR.'item.class.php');
  require_once(MODELDIR.'profile.class.php');
  require_once(MODELDIR.'user.class.php');
  require_once(DAODIR.'itemdao.class.php');
  require_once(DAODIR.'profiledao.class.php');
  require_once(DAODIR.'tagdao.class.php');
  require_once(DAODIR.'userdao.class.php');
?> 
<?php
class ItemDaoTest extends DBTestBase
{
  var $itemdao;
  var $userdao;
  var $profiledao;
  var $tagdao;
  var $defaultuser;
  var $defaultprofile;
  var $defaultitem1;
  var $defaultitem2;

  function setUpForAllTests()
  {
    parent::setUpForAllTests();
    
    $this->userdao = new UserDao();
    $this->itemdao = new ItemDao();
    $this->profiledao = new ProfileDao();
    $this->tagdao = new TagDao();
    
    $this->defaultuser = getDefaultUser();  
    $this->defaultprofile = getDefaultProfile();
    $this->defaultitem1 = gerDefaultItem();
    $this->defaultitem2 = cloneItem($this->defaultitem1);
    $this->defaultitem2->longitude = 190.12345;
    $this->defaultitem2->latitude = 80.213;
    $this->defaultitem2->link = 'http://localhost/rss2.xml';
  }
  
  function setUpDB()
  {
    $this->userdao->db = $this->db;
    $this->itemdao->db = $this->db; 
    $this->profiledao->db = $this->db;
    $this->tagdao->db = $this->db;
    
    $userid = $this->userdao->save($this->defaultuser);
    $this->defaultuser->id = $userid;
    $this->defaultitem1->user_id = $userid;
    $this->defaultitem2->user_id = $userid;
    $this->defaultitem1->id = $this->itemdao->save($this->defaultitem1);
    $this->defaultitem2->id = $this->itemdao->save($this->defaultitem2);
  }
  
  function testSelectByID()
  {
    $item = $this->itemdao->loadByID($this->defaultitem1->id);
    assertItemsEqual($item, $this->defaultitem1, true);
  }
  
  function testSelectByUserID()
  {
    $items = $this->itemdao->loadByUserID($this->defaultuser->id);
    
    foreach ($items as $item)
      if ($item->link == $this->defaultitem1->link)
        assertItemsEqual($item, $this->defaultitem1, true);
      else
        assertItemsEqual($item, $this->defaultitem2, true);
  }
  
  function testSelectByBounds()
  {
    //defaultitem1(lnt, lat) = 123.453, 321.543
    //defaultitem2(lnt, lat) = 190.12345, 80.213
    $items = $this->itemdao->loadByBounds(123.5, 123.2, 321.6, 78.5, 0, 10);
    assert(count($items)==1);
    assertItemsEqual($items[0], $this->defaultitem1, true);
    $items = $this->itemdao->loadByBounds(200, 100, 321.6, 321.3, 0, 10);
    assert(count($items)==1);
    assertItemsEqual($items[0], $this->defaultitem1, true);
  }
  
  function testSelectByIDLimit()
  {
    $items = $this->itemdao->loadByIDLimit(-1, 1);
    assert(count($items)==1);
  }
  
  function testSelectAll()
  {
    $items = $this->itemdao->loadAll();
    assert(count($items)==2);
  }
  
  function testSelectByLink()
  {   
    $items = $this->itemdao->loadByLink($this->defaultitem1->link);
    $item = $items[0];
    assertItemsEqual($item, $this->defaultitem1, true);
  }
  
  function testProfileOpers()
  {
    $this->defaultprofile->user_id = $this->defaultuser->id;
    $pid = $this->profiledao->save($this->defaultprofile);
    $this->profiledao->addItem($pid, $this->defaultitem1->id);
    $this->profiledao->addItem($pid, $this->defaultitem2->id);
    
    $items = $this->itemdao->loadByProfileID($pid);
    assert(count($items)==2);
    foreach ($items as $item)
      if ($item->id == $this->defaultitem1->id)
        assertItemsEqual($item, $this->defaultitem1, true);
      else
        assertItemsEqual($item, $this->defaultitem2, true);
    
    $this->profiledao->delItem($pid, $this->defaultitem2->id);
    $items = $this->itemdao->loadByProfileID($pid);
    assert(count($items)==1);
    assertItemsEqual($items[0], $this->defaultitem1, true);
    $this->profiledao->delItem($pid, $this->defaultitem1->id);
    $items = $this->itemdao->loadByProfileID($pid);
    assert(count($items)==0);
    
    $this->profiledao->addItem($pid, $this->defaultitem1->id);
    $this->profiledao->addItem($pid, $this->defaultitem2->id);
    $profile = $this->profiledao->loadByID($pid);
    $this->profiledao->delete($profile);
    $items = $this->itemdao->loadByProfileID($pid);
    assert(count($items)==0);
  }
  
  function testTagOpers()
  {
    $this->tagdao->addItemTag("123", $this->defaultitem1->id);
    $this->tagdao->addItemTag("123", $this->defaultitem2->id);
    $this->tagdao->addItemTag("abc", $this->defaultitem2->id);
    
    $items = $this->itemdao->loadByTagName("123");
    assert(count($items)==2);
    $tag = $this->tagdao->loadByName("123");
    assert($tag->num==2);
    foreach ($items as $item)
      if ($item->id == $this->defaultitem1->id)
      {
        assertItemsEqual($item, $this->defaultitem1, true);
      }
      else
        assertItemsEqual($item, $this->defaultitem2, true);
    $items = $this->itemdao->loadByTagName("abc");
    assert(count($items)==1);
    $tag = $this->tagdao->loadByName("abc");
    assert($tag->num==1);
    
    $this->tagdao->delItemTag("123", $this->defaultitem2->id);
    $items = $this->itemdao->loadByTagName("123");
    assert(count($items)==1);
    $tag = $this->tagdao->loadByName("123");
    assert($tag->num==1);
    
    assertItemsEqual($items[0], $this->defaultitem1, true);
    $items = $this->itemdao->loadByTagName("abc"); 
    assert(count($items)==1);
    $tag = $this->tagdao->loadByName("abc");
    assert($tag->num==1);
    
    $this->tagdao->delItemTag("123", $this->defaultitem1->id);
    $items = $this->itemdao->loadByTagName("123");
    assert(count($items)==0);
    $tag = $this->tagdao->loadByName("123");
    assert($tag->num==0);
  }
  
  function testDelete()
  {
    $userloaded = $this->userdao->loadByName($this->defaultuser->name);
    $items = $this->itemdao->loadByUserID($userloaded->id);
    
    foreach ($items as $item)
      $this->itemdao->delete($item);
    $items = $this->itemdao->loadByUserID($userloaded->id);
    assert(count($items)==0);
  }
  
  function testUpdate()
  {
    $item = $this->itemdao->loadByID($this->defaultitem1->id);
    
    $item->longitude = 190.567;
    $this->itemdao->update($item);
    $itemUpdated = $this->itemdao->loadByID($item->id);
    assertItemsEqual($item, $itemUpdated, true);
  }
  
  function testIncVisits()
  {
    $this->itemdao->incVisits($this->defaultitem1->id);
    
    $itemUpdated = $this->itemdao->loadByID($this->defaultitem1->id);
    assert($this->defaultitem1->visits+1==$itemUpdated->visits);
  }
  
  function testRating()
  {
    $this->itemdao->incGoodRating($this->defaultitem1->id);
    
    $itemUpdated = $this->itemdao->loadByID($this->defaultitem1->id);
    assert($this->defaultitem1->goodrating+1==$itemUpdated->goodrating);
    
    $this->itemdao->incBadRating($this->defaultitem1->id);
    
    $itemUpdated = $this->itemdao->loadByID($this->defaultitem1->id);
    assert($this->defaultitem1->badrating+1==$itemUpdated->badrating);
  }
  
  function testFKError()
  {
    //db.php print a very beautiful error information on screen...
    
    /*$item = gerDefaultItem();
    $item->id = -1;//give a wrong user id here
    $insertedid = $this->itemdao->save($item);
    assert($insertedid == NULL);*/
  }
}

$test = new ItemDaoTest();
$test->tearDown();
$test->setUpForAllTests();

$test->setUp();
$test->testSelectByID();
$test->tearDown();

$test->setUp();
$test->testSelectByUserID();
$test->tearDown();

$test->setUp();
$test->testSelectByBounds();
$test->tearDown();

$test->setUp();
$test->testSelectByIDLimit();
$test->tearDown();

$test->setUp();
$test->testSelectAll();
$test->tearDown();

$test->setUp();
$test->testSelectByLink();
$test->tearDown();

$test->setUp();
$test->testDelete();
$test->tearDown();

$test->setUp();
$test->testUpdate();
$test->tearDown();

$test->setUp();
$test->testIncVisits();
$test->tearDown();

$test->setUp();
$test->testRating();
$test->tearDown();

$test->setUp();
$test->testFKError();
$test->tearDown();

$test->setUp();
$test->testProfileOpers();
$test->tearDown();

$test->setUp();
$test->testTagOpers();
$test->tearDown();
print 'all tests passed.'
?>