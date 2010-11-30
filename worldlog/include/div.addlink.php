<div id="addlink" class="section disappear">
  添加网址<br/>
  网址: <input type="text" id="addlink.link" size="24" value=""/><span style="color:red"> *</span><br/>
  标题: <input type="text" id="addlink.title" size="14" value=""/><br/>
  经度: <input type="text" id="addlink.lnt" size="14" value="" readonly="readonly"/><span style="color:red"> *</span><br/>
  纬度: <input type="text" id="addlink.lat" size="14" value="" readonly="readonly"/><span style="color:red"> *</span><br/>
  tag: <input type="text" id="addlink.tags" size="14" value=""/><br/>
  <br/>
  在地图上选择地点,然后点击"提交网址"完成添加.<br/>
  <input id="addlink.submitbtn" type="button" value="提交网址"/>
</div>

<script>
  function AddLinkDiv(){}
  
  Page.generateShowHideFunc(AddLinkDiv, $("addlink"), true);
  
  AddLinkDiv.submitBtnOnClick = function() {
    if ($F("addlink.lnt")=="" || $F("addlink.lat")=="" || $F("addlink.link")=="" ) {
      alert("请选择地点并填写网址");
      return;
    }
    var lnt = Number($F("addlink.lnt"));
    var lat = Number($F("addlink.lat"));
    if (lnt==NaN || lat==NaN) {
      alert("请选择地点");
      return;
    }
    
    AjaxRequest.item.addLink(lnt, lat, $F("addlink.link"), $F("addlink.title"), $F("addlink.tags"),
      function(){
        $("addlink.link").value="";
        $("addlink.title").value="";
        $("addlink.tags").value="";
        AddLinkDiv.hide();
      }, 
      function(){
        alert("添加失败！");
    });
  }
  $("addlink.submitbtn").onclick = AddLinkDiv.submitBtnOnClick;
  
  UserFactory.registerLogoutListener(AddLinkDiv.hide);
  WorldlogMapFactory.registerClickListener(function(o, p) {
    if (p == null) return;
	  $("addlink.lat").value = p.y;
    $("addlink.lnt").value = p.x;
  })
</script>