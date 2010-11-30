<?php
  require_once('dbhelper.class.php');

class UserDao 
{
	var $table_name = "worldlog_users";
  var $selectbyname_query_str = "select *
                          from worldlog_users
                          where name = '%s'";
  var $selectbynameandpassword_query_str = "select *
                          from worldlog_users
                          where name = '%s' and password = '%s'";
  var $selectbyid_query_str = "select *
                          from worldlog_users
                          where id = %d";
  var $insert_query_str = "insert into worldlog_users (name, nickname, email,
                           password, img_url, default_profile_id) 
                           values ('%s', '%s', '%s', '%s', '%s', %s)";
  var $delete_query_str = "delete from worldlog_users where id = %d ";
  var $update_query_str = "update worldlog_users set 
                           name='%s', nickname='%s', email = '%s', password='%s', img_url='%s',
                           default_profile_id = %s
                           where id='%d'";
  var $db;
  
  function UserDao($db=NULL)
  {
    $this->db = $db;
  }

  function loadByName($name)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyname_query_str,
                     mysql_real_escape_string($name));
    $user = $this->db->queryUniqueObject($query);
    return $user;
  }
  
  function loadByNameAndPassword($name, $password)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbynameandpassword_query_str,
                     mysql_real_escape_string($name),
                     mysql_real_escape_string($password));
    $user = $this->db->queryUniqueObject($query);
    return $user;
  }
  
  function loadByID($id)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyid_query_str,
                     mysql_real_escape_string($id));
    $user = $this->db->queryUniqueObject($query);
    return $user;
  }
  
  function save($user)
  {
    $profile_id = $user->default_profile_id;
    if ($profile_id==NULL) $profile_id = 'NULL';
    
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->insert_query_str,
                     mysql_real_escape_string($user->name), 
                     mysql_real_escape_string($user->nickname), 
                     mysql_real_escape_string($user->email), 
                     mysql_real_escape_string($user->password), 
                     mysql_real_escape_string($user->img_url),
                     mysql_real_escape_string($profile_id));
    $this->db->execute($query);
    return $this->db->lastInsertedId();
    
  }
  
  function delete($user) 
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->delete_query_str,
                     mysql_real_escape_string($user->id));
    $this->db->execute($query);
  }
  
  function update($user) 
  {
    $profile_id = $user->default_profile_id;
    if ($profile_id==NULL) $profile_id = 'NULL';
    
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->update_query_str, 
                     mysql_real_escape_string($user->name), 
                     mysql_real_escape_string($user->nickname), 
                     mysql_real_escape_string($user->email), 
                     mysql_real_escape_string($user->password), 
                     mysql_real_escape_string($user->img_url),
                     mysql_real_escape_string($profile_id),
                     mysql_real_escape_string($user->id));
    $this->db->execute($query);
  }
}
?>