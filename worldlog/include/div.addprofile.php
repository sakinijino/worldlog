<div id="addprofile" class="section disappear">
  将当前的位置保存为我的地图<br/>
  *地图名字: <input type="text" id="addprofile.name" size="14" value="我的地图"/><br/>
  *当前中心经度: <input type="text" id="addprofile.lnt" size="14" value="" readonly="readonly"/><br/>
  *当前中心纬度: <input type="text" id="addprofile.lat" size="14" value="" readonly="readonly"/><br/>
  *当前缩放: <input type="text" id="addprofile.zoom" size="14" value="" readonly="readonly"/><br/>
  <input type="button" id="addprofile.submitaddbtn" value="保存"/><br/><br/>
</div>

<script>
  function AddProfileDiv(){}
  
  Page.generateShowHideFunc(AddProfileDiv, $("addprofile"), true);
  
  $("addprofile.submitaddbtn").onclick = function() {
    if ($F("addprofile.lnt")=="" || $F("addprofile.lat")=="" 
     || $F("addprofile.name")=="" || $F("addprofile.zoom")=="" ) {
      alert("请选择地点并为地图命名");
      return;
    }
    var lnt = Number($F("addprofile.lnt"));
    var lat = Number($F("addprofile.lat"));
    var zoom = Number($F("addprofile.zoom"));
    if (lnt==NaN || lat==NaN || zoom==NaN) {
      alert("请选择地点");
      return;
    }
    AjaxRequest.profile.addProfile($F("addprofile.name"), lnt, lat, zoom,
      null, 
      function(){
        alert("添加失败！");
    });
  }

  WorldlogMapFactory.registerMoveEndListener(function(map) {
	  $("addprofile.lnt").value = map.getCenter().x;
    $("addprofile.lat").value = map.getCenter().y;
    $("addprofile.zoom").value = map.getZoom();
  })
</script>