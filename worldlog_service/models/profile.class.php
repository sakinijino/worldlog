<?php
class Profile 
{
  var $id;
  var $name;
  var $user_id;
  var $longitude;
  var $latitude;
  var $zoom_level;
}
  
  function cloneProfile($profile)
  {
    if ($profile==NULL) return NULL;
    $newprofile = new Profile();
    $newprofile->id =$profile->id;
    $newprofile->name =$profile->name;
    $newprofile->user_id =$profile->user_id;
    $newprofile->longitude =$profile->longitude;
    $newprofile->latitude =$profile->latitude;
    $newprofile->zoom_level =$profile->zoom_level;
    return $newprofile;
  }
function profileToXML($profile) {
  return parseProfilesToXML($profile, true);
}
function profilesToXML($profiles) {
  return parseProfilesToXML($profiles, false);
}

function parseProfilesToXML($profiles, $issingle)
  {
    $profilexml = <<<XML
  <profile>
    <id>%d</id>
    <userid>%d</userid>
    <name>%s</name>
    <longitude>%f</longitude>
    <latitude>%f</latitude>
    <zoomlevel>%d</zoomlevel>
    %s
  </profile>

XML;
    $profilesxml = <<<XML
<profiles>
%s
</profiles>
XML;
    if ($issingle) {
      $xml = "";
      $profile = $profiles;
      $xml .= sprintf($profilexml,
                      $profile->id,
                      $profile->user_id,
                      $profile->name,
                      $profile->longitude,
                      $profile->latitude,
                      $profile->zoom_level,
                      itemsToXML($profile->items));
      return $xml;
    }
    else {
      $xml = "";
      foreach ($profiles as $profile)
      {
        $xml .= sprintf($profilexml,
                        $profile->id,
                        $profile->user_id,
                        $profile->name,
                        $profile->longitude,
                        $profile->latitude,
                        $profile->zoom_level,
                        itemsToXML($profile->items));
      }
      $xml = sprintf($profilesxml, $xml);
      return $xml;
    }
  }
?>