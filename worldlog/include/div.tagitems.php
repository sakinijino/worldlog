<div id="tagitems" class="section disappear">
  tag: <span id="tagitems.tagname" class="link" style="font-weight:bolder;"></span><br/>
  <div id="tagitems.list"></div>
</div>
<script>
  function TagItemsDiv(){}
  
  Page.generateShowHideFunc(TagItemsDiv, $("tagitems"), true, null, function(){
    TagItemsDiv.clear();
  });
  
  TagItemsDiv.clear = function(){
    $("tagitems.tagname").innerHTML = "";
    $("tagitems.list").innerHTML = "";
  };
 
  TagItemsDiv.addItem = function(item) {
    $("tagitems.list").appendChild(item.getItemSpan(false));
    $("tagitems.list").appendChild(document.createElement('br'));
  }
  
  TagFactory.registerSearchListener(function(tag){
    TagItemsDiv.clear()
    $("tagitems.tagname").innerHTML = tag.name;
    AjaxRequest.item.getTagItems(tag.name, function(arr){
      arr.each(TagItemsDiv.addItem);
    });
    TagItemsDiv.show();
  });
</script>