<?php
  require_once('include.php');
  require_once(MODELDIR.'profile.class.php');
?>

<?php
class ProfileTest
{
  var $defaultprofile1;
  var $defaultprofile2;

  function setUpForAllTests()
  {
    $this->defaultprofile1 = getDefaultProfile();
    $this->defaultprofile2 = cloneProfile($this->defaultprofile1);
    $this->defaultprofile2->zoom_level = 1;
  }
  
  function testClone()
  {
    $profilecopied = cloneProfile($this->defaultprofile1);
    assertProfilesEqual($this->defaultprofile1, $profilecopied, true);
    $profilecopied = cloneProfile(NULL);
    assert($profilecopied==NULL);
  }
  
  function testprofilesToXML()
  {
    $xml = profilesToXML(
              array($this->defaultprofile1, $this->defaultprofile2));
    $result = <<<XML
<profiles>
  <profile>
    <id>0</id>
    <userid>0</userid>
    <name>PKU</name>
    <longitude>136.123450</longitude>
    <latitude>49.000000</latitude>
    <zoomlevel>4</zoomlevel>
  </profile>
  <profile>
    <id>0</id>
    <userid>0</userid>
    <name>PKU</name>
    <longitude>136.123450</longitude>
    <latitude>49.000000</latitude>
    <zoomlevel>1</zoomlevel>
  </profile>

</profiles>
XML;
    assert($xml == $result);//$xml content may be different for different php version;
    //print $xml;
  }
}

$test = new ProfileTest();
$test->setUpForAllTests();
$test->testClone();
$test->testprofilesToXML();
print 'all tests passed.'
?>