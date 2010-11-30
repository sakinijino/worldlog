<?php
  function assertUsersEqual($user1, $user2, $testidequal=false)
  {
    if ($testidequal) assert($user1->id == $user2->id);
    assert($user1->name == $user2->name);
    assert($user1->nickname == $user2->nickname);
    assert($user1->email == $user2->email);
    assert($user1->password == $user2->password);
    assert($user1->img_url == $user2->img_url);
    assert($user1->default_profile_id == $user2->default_profile_id);
  }
  
  function assertProfilesEqual($profile1, $profile2, $testidequal=false)
  {
    if ($testidequal) assert($profile1->id == $profile2->id);
    assert($profile1->name == $profile2->name);
    assert($profile1->user_id == $profile2->user_id);
    assert($profile1->longitude == $profile2->longitude);
    assert($profile1->latitude == $profile2->latitude);
    assert($profile1->zoom_level == $profile2->zoom_level);
  }
  
  function assertTagsEqual($tag1, $tag2, $testidequal=false)
  {
    if ($testidequal) assert($tag1->id == $tag2->id);
    assert($tag1->name == $tag2->name);
    assert($tag1->num == $tag2->num);
  }
  
  function assertItemsEqual($item1, $item2, $testidequal=false)
  {
    if ($testidequal) assert($item1->id == $item2->id);
    assert($item1->user_id == $item2->user_id);
    assert($item1->longitude == $item2->longitude);
    assert($item1->latitude == $item2->latitude);
    assert($item1->tags == $item2->tags);
    assert($item1->icon == $item2->icon);
    assert($item1->link == $item2->link);
    assert($item1->title == $item2->title);
    assert($item1->content == $item2->content);
    assert($item1->type == $item2->type);
    assert($item1->createtime == $item2->createtime);
    assert($item1->enable == $item2->enable);
    assert($item1->updatetime == $item2->updatetime);
    assert($item1->visits == $item2->visits);
    assert($item1->goodrating == $item2->goodrating);
    assert($item1->badrating == $item2->badrating);
  }
?>