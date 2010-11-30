<?php
  require_once('dbhelper.class.php');

class ItemDao 
{
  var $table_name = "worldlog_items";
  
  var $selectbyidlimit_query_str ="select items.*, 
                 ratings.goodrating, ratings.badrating, ratings.visits 
  					from worldlog_items as items left join 
                 worldlog_item_ratings as ratings
						on items.id = ratings.item_id 
            where items.id > %d and valid = 'true' 
            order by id desc
            limit %d";

  var $selectall_query_str ="select items.*, 
                 ratings.goodrating, ratings.badrating, ratings.visits 
  					from worldlog_items as items left join 
                 worldlog_item_ratings as ratings
						on items.id = ratings.item_id
            where valid ='true'";
  
  var $selectbyid_query_str = "select items.*, 
                 ratings.goodrating, ratings.badrating, ratings.visits 
  					from worldlog_items as items
						left join worldlog_item_ratings as ratings
						on items.id = ratings.item_id
                               where items.id = %d  and valid = 'true'";
  
  var $selectbyuserid_query_str = "select items.*, 
                 ratings.goodrating, ratings.badrating, ratings.visits 
  					from worldlog_items as items
						left join worldlog_item_ratings as ratings
						on items.id = ratings.item_id
  			                           where user_id = %d and valid='true'";
  var $selectbylink_query_str = "select items.*, 
                 ratings.goodrating, ratings.badrating, ratings.visits 
  					from worldlog_items as items
						left join worldlog_item_ratings as ratings
						on items.id = ratings.item_id 
                                   where link = '%s' and valid='true'";
  			                                   
  var $selectbybounds_query_str = "select items.*, 
                 ratings.goodrating, ratings.badrating, ratings.visits 
  					from worldlog_items as items
						left join worldlog_item_ratings as ratings
						on items.id = ratings.item_id
                          			where longitude < %f and longitude >%f and
		                                  latitude <%f and latitude >%f and items.id > %d 
		                                  and valid ='true'
		                                  order by id desc
		                                  limit %d";

  var $selectbytagname_query_str = "select items.*, 
                 ratings.goodrating, ratings.badrating, ratings.visits 
                    from worldlog_items as items left join 
                         worldlog_item_ratings as ratings 
                    on items.id = ratings.item_id
                    where valid='true' and items.id in (
                        select items.id
                        from worldlog_items as items join
                             worldlog_item_tag as it join
                             worldlog_tags as t
                        on items.id = it.item_id and 
                           it.tag_id = t.id
                        where t.name = '%s')";
  var $selectbyprofileid_query_str = "select items.*, 
                 ratings.goodrating, ratings.badrating, ratings.visits 
                    from worldlog_items as items left join 
                         worldlog_item_ratings as ratings 
                    on items.id = ratings.item_id
                    where valid='true' and items.id in (
                        select items.id
                        from worldlog_items as items join 
                             worldlog_profile_item as pi
                        on items.id = pi.item_id 
                        where pi.p_id = %d)";
                                
  var $insert_query_str = "insert into worldlog_items (user_id,longitude,latitude,tags,icon,link,title,content,type,valid,createtime,enable,updatetime) 
                                               values (%d,     %f,       %f,      '%s','%s','%s','%s', '%s',   '%s','true','%s',    '%s',  '%s')";
  var $insert_rating_query_str = "insert into worldlog_item_ratings (item_id, goodrating, badrating, visits) values (%d, %d, %d, %d)";
  
  var $delete_query_str = "update worldlog_items set valid='false' where id = %d";
  var $update_query_str = "update worldlog_items set 
                           user_id = %d ,longitude = %f,latitude=%f,tags='%s',icon='%s',link='%s',title='%s',content='%s',type='%s',createtime='%s',enable='%s',updatetime = '%s'
                           where id=%d";
  var $inc_visits_query_str = "update worldlog_item_ratings set visits = visits + 1 where item_id = %d";
  var $inc_goodrating_query_str = "update worldlog_item_ratings set goodrating = goodrating + 1 where item_id = %d";
  var $inc_badrating_query_str = "update worldlog_item_ratings set badrating = badrating + 1 where item_id = %d";
  var $db = NULL;
  
  function ItemDao($db=NULL)
  {
    $this->db = $db;
  }

  function loadByID($id)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyid_query_str,
                     mysql_real_escape_string($id));
    $item = $this->db->queryUniqueObject($query);
    return $item;
  }
  
  function loadByUserID($userid)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyuserid_query_str,
                     mysql_real_escape_string($userid));
    $this->db->query($query);
    $items = array();
    while ($item = $this->db->fetchNextObject()) {
      $items[] = $item;
    }
    return $items;
  }
 
  
  function loadByBounds($maxlnt, $minlnt, $maxlat, $minlat, $startid, $limit)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbybounds_query_str,
                     mysql_real_escape_string($maxlnt),
                     mysql_real_escape_string($minlnt),
                     mysql_real_escape_string($maxlat),
                     mysql_real_escape_string($minlat),
                     mysql_real_escape_string($startid),
                     mysql_real_escape_string($limit));

                   
    $this->db->query($query);
    $items = array();
    while ($item = $this->db->fetchNextObject()) {
      $items[] = $item;
    }
    return $items;
  }
  
  function loadByIDLimit($id,$limit)
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyidlimit_query_str,
                     mysql_real_escape_string($id),mysql_real_escape_string($limit));
    $this->db->query($query);
    $items = array();
    while ($item = $this->db->fetchNextObject()) {
      $items[] = $item;
    }
    return $items;
  }
  
  function loadAll()
  {
    if ($this->db==NULL) return NULL;
    $query = $this->selectall_query_str;
    $this->db->query($query);
    $items = array();
    while ($item = $this->db->fetchNextObject()) {
      $items[] = $item;
    }
    return $items;
  }//load all
  
  
  function save($item)
  {    
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->insert_query_str,
            mysql_real_escape_string($item->user_id),         
    				mysql_real_escape_string($item->longitude),       
    				mysql_real_escape_string($item->latitude),       
    				mysql_real_escape_string($item->tags),       
    				mysql_real_escape_string($item->icon),       
    				mysql_real_escape_string($item->link),       
    				mysql_real_escape_string($item->title),      
    				mysql_real_escape_string($item->content),    
    				mysql_real_escape_string($item->type),
    				mysql_real_escape_string($item->createtime),    
    				mysql_real_escape_string($item->enable),
            mysql_real_escape_string($item->updatetime));
    $this->db->execute($query);
    $item_id = $this->db->lastInsertedId();
    //for rating
    $query = sprintf($this->insert_rating_query_str,
            mysql_real_escape_string($item_id),
            mysql_real_escape_string($item->goodrating),
            mysql_real_escape_string($item->badrating),
            mysql_real_escape_string($item->visits));   
    $this->db->execute($query);
    
    return $item_id;
  }
  
  function delete($item) 
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->delete_query_str,
                     mysql_real_escape_string($item->id));
    $this->db->execute($query);
  }
  
  function update($item) 
  {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->update_query_str, 
            mysql_real_escape_string($item->user_id),         
    				mysql_real_escape_string($item->longitude),       
    				mysql_real_escape_string($item->latitude),        
    				mysql_real_escape_string($item->tags),       
    				mysql_real_escape_string($item->icon),       
    				mysql_real_escape_string($item->link),       
    				mysql_real_escape_string($item->title),      
    				mysql_real_escape_string($item->content),    
    				mysql_real_escape_string($item->type),
            mysql_real_escape_string($item->createtime),   
    				mysql_real_escape_string($item->enable),
    				mysql_real_escape_string($item->updatetime),
            mysql_real_escape_string($item->id));
    $this->db->execute($query);
  }

  function incVisits($item_id)
  {
 	  if ($this->db==NULL) return NULL;
 		$query = sprintf($this->inc_visits_query_str, 
           mysql_real_escape_string($item_id));
 		$this->db->execute($query);
  }//function
    
  function incGoodRating($item_id)
  {
 	  if ($this->db==NULL) return NULL;
 		$query = sprintf($this->inc_goodrating_query_str, 
           mysql_real_escape_string($item_id));
 		$this->db->execute($query);
  }//function
  function incBadRating($item_id)
  {
 	  if ($this->db==NULL) return NULL;
 		$query = sprintf($this->inc_badrating_query_str, 
           mysql_real_escape_string($item_id));
 		$this->db->execute($query);
  }//function
  
  function loadByLink($link)
  {
  	if ($this->db==NULL) return NULL;
  	if ($link != ""){
    	$query = sprintf($this->selectbylink_query_str, 
           mysql_real_escape_string($link));
   		$this->db->query($query);
      $items = array();
      while ($item = $this->db->fetchNextObject()) {
        $items[] = $item;
      }
      return $items;
  	}
  }//function
  
  function loadByProfileID($profileid) {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbyprofileid_query_str,
                     mysql_real_escape_string($profileid));
    $this->db->query($query);
    $items = array();
    while ($item = $this->db->fetchNextObject()) {
      $items[] = $item;
    }
    return $items;
  }
  
  function loadByTagName($name) {
    if ($this->db==NULL) return NULL;
    $query = sprintf($this->selectbytagname_query_str,
                     mysql_real_escape_string($name));
    $this->db->query($query);
    $items = array();
    while ($item = $this->db->fetchNextObject()) {
      $items[] = $item;
    }
    return $items;
  }
}//end of class
?>