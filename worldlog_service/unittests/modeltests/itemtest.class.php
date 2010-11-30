<?php
  require_once('include.php');
  require_once(MODELDIR.'item.class.php');
?>

<?php
class ItemTest
{  
  var $defaulti1;
  var $defaulti2;

  function setUpForAllTests()
  {
    $this->defaulti1 = gerDefaultItem();
    $this->defaulti2 = cloneItem($this->defaulti1);
    $this->defaulti2->link = 'www.google.com';
    $this->defaulti2->type = 'link';
  }
  
  function testClone()
  {
    $icopied = cloneItem($this->defaulti1);
    assertItemsEqual($this->defaulti1, $icopied, true);
    $icopied = cloneItem(NULL);
    assert($icopied==NULL);   
  }
  
  function testItemsToXML()
  {
    $xml = itemsToXML(
                array($this->defaulti1, $this->defaulti2));
    $result = 
<<<XML
<items>
  <item>
    <itemid>1</id>
    <userid>0</userid>
    <longitude>123.453000</longitude>
    <latitude>321.543000</latitude>
    <tags><![CDATA[as sa ew]]></tags>
    <icon><![CDATA[1.ico]]></icon>
    <link><![CDATA[sakinijino.bokee.com]]></link>
    <title><![CDATA[future]]></title>
    <content><![CDATA[<p>213</p>]]></content>
    <type>blog</type>
    <createtime>2006-05-12 00:00:00</createtime>
    <enable>true</enable>
    <updatetime>2006-05-13 00:00:00</updatetime>
    <visits>3</visits>
    <goodrating>25</goodrating>
    <badrating>10</badrating>
  </item>
  <item>
    <itemid>1</id>
    <userid>0</userid>
    <longitude>123.453000</longitude>
    <latitude>321.543000</latitude>
    <tags><![CDATA[as sa ew]]></tags>
    <icon><![CDATA[1.ico]]></icon>
    <link><![CDATA[www.google.com]]></link>
    <title><![CDATA[future]]></title>
    <content><![CDATA[<p>213</p>]]></content>
    <type>link</type>
    <createtime>2006-05-12 00:00:00</createtime>
    <enable>true</enable>
    <updatetime>2006-05-13 00:00:00</updatetime>
    <visits>3</visits>
    <goodrating>25</goodrating>
    <badrating>10</badrating>
  </item>

</items>
XML;
    assert($xml == $result);//$xml content may be different for different php version;
  }
}

$test = new ItemTest();
$test->setUpForAllTests();
$test->testClone();
$test->testItemsToXML();
print 'all tests passed.'
?>