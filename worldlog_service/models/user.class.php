<?php
class User 
{
  var $id;
  var $name;
  var $nickname;
  var $password;
  var $email;
  var $img_url;
  var $default_profile_id;
}

function cloneUser($user)
{
  if ($user==NULL) return NULL;
  $newuser = new User();
  $newuser->id = $user->id;
  $newuser->name = $user->name;
  $newuser->nickname = $user->nickname;
  $newuser->password = $user->password;
  $newuser->email =$user->email;
  $newuser->img_url = $user->img_url;
  $newuser->default_profile_id = $user->default_profile_id;
  return $newuser;
}

function userToXML($user) {
  return parseUserToXML($user, true);
}
function usersToXML($users) {
  return parseUserToXML($users, false);
}

function parseUserToXML($users, $issingle)
  {
    $userxml = <<<XML
  <user>
    <id>%d</id>
    <name>%s</name>
    <nickname>%s</nickname>
    <email>%s</email>
  </user>

XML;
    $usersxml = <<<XML
<users>
%s
</users>
XML;
    if ($issingle) {
      $xml = "";
      $user = $users;
      $xml .= sprintf($userxml,
                      $user->id,
                      $user->name,
                      $user->nickname,
                      $user->email);
      return $xml;
    }
    else {
      $xml = "";
      foreach ($users as $user)
      {
        $xml .= sprintf($userxml,
                        $user->id,
                        $user->name,
                        $user->nickname,
                        $user->email);
      }
      $xml = sprintf($usersxml, $xml);
      return $xml;
    }
  }
?>