<?php
  require_once('dbhelper.class.php');

class ProfileDao 
{
  var $selectbyid_query_str = "select id, name, longitude, latitude, zoom_level, 
                          user_id
                          from worldlog_profiles
                          where id = %d";
  var $selectbyuserid_query_str = "select id, name, longitude, latitude, zoom_level, 
                          user_id
                          from worldlog_profiles
                          where user_id = %d";
  var $add_item_query_str = "insert into worldlog_profile_item (p_id, item_id)
                           values (%d, %d)";
  var $del_item_query_str = "delete from worldlog_profile_item
                            where p_id = %d and item_id = %d";
  var $insert_query_str = "insert into worldlog_profiles (name, longitude, 
                           latitude, zoom_level, user_id)
                           values ('%s', %f, %f, %d, %d)";
  var $delete_query_str = "delete from worldlog_profiles where id = %d";
  var $del_items_query_str = "delete from worldlog_profile_item where p_id = %d";
  var $update_query_str = "update worldlog_profiles set 
                           name='%s', longitude=%f, latitude=%f, zoom_level=%d,
                           user_id = %d
                           where id=%d";
  var $db = NULL;
  
  function ProfileDao($db=NULL)
  {
    $this->db = $db;
  }

  function loadByID($id)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyid_query_str,
                     mysql_real_escape_string($id));
    $profile = $this->db->queryUniqueObject($query);
    return $profile;
  }
  
  function loadByUserID($userid)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyuserid_query_str,
                     mysql_real_escape_string($userid));
    $this->db->query($query);
    $profiles = array();
    while ($profile = $this->db->fetchNextObject()) {
      $profiles[] = $profile;
    }
    return $profiles;
  }
  
  function save($profile)
  {    
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->insert_query_str,
                     mysql_real_escape_string($profile->name), 
                     mysql_real_escape_string($profile->longitude), 
                     mysql_real_escape_string($profile->latitude), 
                     mysql_real_escape_string($profile->zoom_level),
                     mysql_real_escape_string($profile->user_id));
    $this->db->execute($query);
    return $this->db->lastInsertedId();
  }
  
  function addItem($p_id, $item_id)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->add_item_query_str,
                     mysql_real_escape_string($p_id),
                     mysql_real_escape_string($item_id));
    $this->db->execute($query);
  }
  
  function delItem($p_id, $item_id)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->del_item_query_str,
                     mysql_real_escape_string($p_id),
                     mysql_real_escape_string($item_id));
    $this->db->execute($query);
  }
  
  function delete($profile) 
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->delete_query_str,
                     mysql_real_escape_string($profile->id));
    $this->db->execute($query);
    $query = sprintf($this->del_items_query_str,
                     mysql_real_escape_string($profile->id));
    $this->db->execute($query);
  }
  
  function update($profile) 
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->update_query_str, 
                     mysql_real_escape_string($profile->name), 
                     mysql_real_escape_string($profile->longitude), 
                     mysql_real_escape_string($profile->latitude), 
                     mysql_real_escape_string($profile->zoom_level),
                     mysql_real_escape_string($profile->user_id),
                     mysql_real_escape_string($profile->id));
    $this->db->execute($query);
  }
}
?>