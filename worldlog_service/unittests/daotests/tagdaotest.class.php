<?php
  require_once('include.php');
  require_once(DAODIR.'tagdao.class.php');
  require_once(MODELDIR.'tag.class.php');
?>

<?php
class TagDaoTest extends DBTestBase
{
  var $tagdao;
  var $defaultuser;

  function setUpForAllTests()
  {
    parent::setUpForAllTests();
    
    $this->tagdao = new TagDao();
  }
  
  function setUpDB()
  {
    $this->tagdao->db = $this->db;
  }
  
  function testOpers()
  {
    $id1 = $this->tagdao->saveByName("123");
    $id2 = $this->tagdao->saveByName("123");
    assert($id1 == $id2);
    
    $tag = $this->tagdao->loadByName("123");
    assert($id1 == $tag->id);
    
    $id1 = $this->tagdao->saveByName("123");
    $id2 = $this->tagdao->saveByName("abc");
    $tags = $this->tagdao->loadAll();
    assert(count($tags)==2);
  }
}

$test = new TagDaoTest();
$test->tearDown();
$test->setUpForAllTests();

$test->setUp();
$test->testOpers();
$test->tearDown();
print 'all tests passed.'
?>