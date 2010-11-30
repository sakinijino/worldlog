<div id="items" class="section disappear">
  你添加的信息点: <br/>
  <div id="items.list"></div><!--clear when logout-->
  <br/>
  添加<span class="button" onclick="AddBlogDiv.show();">博客</span>
  <span class="button" onclick="AddLinkDiv.show();">网址</span>
  <span class="button" onclick="AddDiaryDiv.show();">日记</span>
</div>

<script>
  function ItemsDiv(){}
  
  Page.generateShowHideFunc(ItemsDiv, $("items"), true);
  
  ItemsDiv.addItem = function(item) {
    $("items.list").appendChild(item.getItemSpan(true));
    $("items.list").appendChild(document.createElement('br'));
  }
  ItemsDiv.generateDiv = function() {
    $("items.list").innerHTML = "";
    Page.currentUser.items.values().each(function(item){
      ItemsDiv.addItem(item);
    });
  }
  
  UserFactory.registerUserItemsUpdateListener(ItemsDiv.generateDiv);
  UserFactory.registerUserItemsLoadListener(ItemsDiv.generateDiv);
  UserFactory.registerLoginListener(ItemsDiv.show);
  UserFactory.registerLogoutListener(function(){
    $("items.list").innerHTML = "";
    ItemsDiv.hide();
  });
</script>