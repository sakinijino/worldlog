<?php
class Item 
{
  var $id;
  var $user_id;
  var $longitude;
  var $latitude;
  var $tags;
  var $icon;
  var $link;
  var $title;
  var $content;
  var $type;
  var $createtime;
  var $enable;
  var $updatetime;
  var $visits;
  var $goodrating;
  var $badrating;
  
}
  
  function cloneItem($item)
  {
    if ($item==NULL) return NULL;
    $newitem = new Item();
    $newitem->id = 	$item->id;
    $newitem->user_id = 	$item->user_id;
    $newitem->longitude = 	$item->longitude;
    $newitem->latitude = 	$item->latitude;
    $newitem->tags = 	$item->tags;
    $newitem->icon = 	$item->icon;
    $newitem->link = 	$item->link;
    $newitem->title = 	$item->title;
    $newitem->content = 	$item->content;
    $newitem->type = 	$item->type;
    $newitem->createtime = 	$item->createtime;
    $newitem->enable = 	$item->enable;
    $newitem->updatetime = $item->updatetime;
    $newitem->visits = 	$item->visits;
    $newitem->goodrating= 	$item->goodrating;
    $newitem->badrating= 	$item->badrating;
    
    return $newitem;
  }


function itemToXML($item) {
  return parseItemsToXML($item, true);
}
function itemsToXML($items) {
  return parseItemsToXML($items, false);
}

function parseItemsToXML($items, $issingle)
{
    $itemxml = 
<<<XML
  <item>
    <id>%d</id>
    <userid>%d</userid>
    <longitude>%f</longitude>
    <latitude>%f</latitude>
    <tags><![CDATA[%s]]></tags>
    <icon><![CDATA[%s]]></icon>
    <link><![CDATA[%s]]></link>
    <title><![CDATA[%s]]></title>
    <content><![CDATA[%s]]></content>
    <type>%s</type>
    <createtime>%s</createtime>
    <enable>%s</enable>
    <updatetime>%s</updatetime>
    <visits>%d</visits>
    <goodrating>%d</goodrating>
    <badrating>%d</badrating>
  </item>

XML;

   $itemsxml =
<<<XML
<items>
%s
</items>
XML;
    if ($issingle) {
      $xml = "";
      $item = $items;
      $xml .= sprintf($itemxml,
              $item->id,        
      				$item->user_id,         
      				$item->longitude,       
      				$item->latitude,
      				$item->tags,
      				$item->icon,       
      				$item->link,       
      				$item->title,      
      				$item->content,
      				$item->type,    
      				$item->createtime,
      				$item->enable,  
      				$item->updatetime,
      				$item->visits, 
      				$item->goodrating,
              $item->badrating);
      return $xml;
    }
    else {
      $xml = "";
      foreach ($items as $item)
      {
        $xml .= sprintf($itemxml,
              $item->id,        
      				$item->user_id,         
      				$item->longitude,       
      				$item->latitude,
      				$item->tags,
      				$item->icon,       
      				$item->link,       
      				$item->title,      
      				$item->content,
      				$item->type,    
      				$item->createtime,
      				$item->enable,  
      				$item->updatetime,
      				$item->visits, 
      				$item->goodrating,
              $item->badrating);
      }
      $xml = sprintf($itemsxml, $xml);
      return $xml;
    }
  }
?>