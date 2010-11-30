<?php
  require_once('dbhelper.class.php');

class TagDao 
{
	var $table_name = "worldlog_tags";
  var $selectbyname_query_str = "select *
                          from worldlog_tags
                          where name = '%s'";
  var $selectall_query_str = "select *
                          from worldlog_tags";
  var $add_itemtag_query_str = "insert into worldlog_item_tag (tag_id, item_id)
                           values (%d, %d)";
  var $inc_tag_num_qurey_str = "update worldlog_tags set num=num+1 where name = '%s'";
  var $del_itemtag_query_str = "delete from worldlog_item_tag
                            where tag_id = %d and item_id = %d";
  var $dec_tag_num_qurey_str = "update worldlog_tags set num=num-1 where name = '%s'";
  var $insertbyname_query_str = "insert into worldlog_tags (name, num) 
                           values ('%s', 0)";
  var $deletebyname_query_str = "delete from worldlog_tags where name = '%s' ";
  var $db;
  
  function TagDao($db=NULL)
  {
    $this->db = $db;
  }

  function loadByName($name)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyname_query_str,
                     mysql_real_escape_string($name));
    $tag = $this->db->queryUniqueObject($query);
    return $tag;
  }
  
  function loadAll()
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectall_query_str);
    $this->db->query($query);
    $tags = array();
    while ($tag = $this->db->fetchNextObject()) {
      $tags[] = $tag;
    }
    return $tags;
  }
  
  function saveByName($name)
  {
    if ($this->db==NULL) return NULL;
    if (trim($name)=="") return NULL;
    $tag = $this->loadByName($name);
    if ($tag != NULL) return $tag->id;
    
    $query = sprintf($this->insertbyname_query_str,
                     mysql_real_escape_string($name));
    $this->db->execute($query);
    return $this->db->lastInsertedId();
    
  }
  
  function addItemTag($name, $item_id)
  {
    if ($this->db==NULL) return NULL;
    $tag_id = $this->saveByName($name);
    if ($tag_id == NULL) return NULL;
    $query = sprintf($this->add_itemtag_query_str,
                     mysql_real_escape_string($tag_id),
                     mysql_real_escape_string($item_id));
    $this->db->execute($query);
    $query = sprintf($this->inc_tag_num_qurey_str,
                     mysql_real_escape_string($name));
    $this->db->execute($query);
  }
  
  function delItemTag($name, $item_id)
  {
    if ($this->db==NULL) return NULL;
    $tag_id = $this->saveByName($name);
    $query = sprintf($this->del_itemtag_query_str,
                     mysql_real_escape_string($tag_id),
                     mysql_real_escape_string($item_id));
    $this->db->execute($query);
    $query = sprintf($this->dec_tag_num_qurey_str,
                     mysql_real_escape_string($name));
    $this->db->execute($query);
  }
}
?>