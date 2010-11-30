<?php
  require_once('include.php');
  require_once(MODELDIR.'tag.class.php');
?>

<?php
class TagTest
{
  var $tag1;
  var $tag2;

  function setUpForAllTests()
  {
    $this->tag1 = new Tag();
    $this->tag2 = new Tag();
    $this->tag1->id = 1;
    $this->tag1->num = 12;
    $this->tag1->name = "123";
    $this->tag2->id = 2;
    $this->tag2->num = 23;
    $this->tag2->name = "abc";
  }
  
  function testClone()
  {
    $tagcopied = cloneTag($this->tag1);
    assertTagsEqual($this->tag1, $tagcopied, true);
    $tagcopied = cloneTag(NULL);
    assert($tagcopied==NULL);
  }
  
  function testtagsToXML()
  {
    $xml = tagsToXML(
              array($this->tag1, $this->tag2));
    $result = <<<XML
<tags>
  <tag>
    <id>1</id>
    <name>123</name>
    <num>12</num>
  </tag>
  <tag>
    <id>2</id>
    <name>abc</name>
    <num>23</num>
  </tag>

</tags>
XML;
    assert($xml == $result);//$xml content may be different for different php version;
  }
}

$test = new TagTest();
$test->setUpForAllTests();
$test->testClone();
$test->testtagsToXML();
print 'all tests passed.'
?>