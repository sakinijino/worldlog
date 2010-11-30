<div id="lastestitems" class="section disappear">
  最新添加的节点：<br/>
  <div id="lastestitems.list"></div>
</div>

<script>
  function LastestItemsDiv(){}
  
  Page.generateShowHideFunc(LastestItemsDiv, $("lastestitems"), true, function(){
    $("lastestitems.list").innerHTML = "";
    AjaxRequest.item.getLastestItems(10, function(arr){
      arr.each(function(item){
        $("lastestitems.list").appendChild(item.getItemSpan());
        $("lastestitems.list").appendChild(document.createElement('br'));
      });
    });
  });
  
  UserFactory.registerLoginListener(LastestItemsDiv.hide);
</script>