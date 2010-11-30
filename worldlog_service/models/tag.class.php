<?php
class Tag 
{
  var $id;
  var $name;
  var $num;
}

function cloneTag($tag)
{
  if ($tag==NULL) return NULL;
  $newtag = new Tag();
  $newtag->id = $tag->id;
  $newtag->name = $tag->name;
  $newtag->num = $tag->num;
  return $newtag;
}

function tagsToXML($tags)
  {
    $tagxml = <<<XML
  <tag>
    <id>%d</id>
    <name>%s</name>
    <num>%d</num>
  </tag>

XML;
    $tagsxml = <<<XML
<tags>
%s
</tags>
XML;
    $xml = "";
    foreach ($tags as $tag)
    {
      $xml .= sprintf($tagxml,
                      $tag->id,
                      $tag->name,
                      $tag->num);
    }
    $xml = sprintf($tagsxml, $xml);
    return $xml;
  }
?>