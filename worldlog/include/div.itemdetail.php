<div id="itemdetail" class="section disappear">
  <div id="itemdetail.detail"></div>
</div>

<script>
  function ItemDetailDiv(){}
  
  Page.generateShowHideFunc(ItemDetailDiv, $("itemdetail"), true);
  
  ItemDetailDiv.currentItem = null;
  ItemDetailDiv.itemDetail = function(item) {
    if (ItemDetailDiv.currentItem!= null) 
      ItemDetailDiv.currentItem.unRegisterDeleteListener(ItemDetailDiv.clear);
    
    var div = $("itemdetail.detail");
    div.innerHTML = "";
    div.appendChild(item.getDetailDiv());
    ItemDetailDiv.currentItem = item;
    ItemDetailDiv.currentItem.registerDeleteListener(ItemDetailDiv.clear);
    ItemDetailDiv.show();
  }
  ItemDetailDiv.clear = function() {
    ItemDetailDiv.hide();
    $("itemdetail.detail").innerHTML = "";
  }
  
  ItemFactory.registerCreateListener(ItemDetailDiv.itemDetail);
  ItemFactory.registerFocusListener(ItemDetailDiv.itemDetail);
  ItemFactory.registerUpdateListener(ItemDetailDiv.itemDetail);

  UserFactory.registerLogoutListener(ItemDetailDiv.clear);
</script>