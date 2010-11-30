<div id="adddiary" class="section disappear">
  添加日记<br/>
  标题: <input type="text" id="adddiary.title" size="24" value=""/><span style="color:red"> *</span><br/>
  经度: <input type="text" id="adddiary.lnt" size="14" value="" readonly="readonly"/><span style="color:red"> *</span><br/>
  纬度: <input type="text" id="adddiary.lat" size="14" value="" readonly="readonly"/><span style="color:red"> *</span><br/>
  tag: <input type="text" id="adddiary.tags" size="14" value=""/><br/>
  <br/>
  内容:<span style="color:red"> *</span><br/>
  <textarea id="adddiary.content"></textarea><br/>
  <input id="adddiary.submitbtn" type="button" value="提交"/>
</div>

<script>
  function AddDiaryDiv(){}
  
  Page.generateShowHideFunc(AddDiaryDiv, $("adddiary"), true);
  
  AddDiaryDiv.submitBtnOnClick = function() {
    if ($F("adddiary.lnt")=="" || $F("adddiary.lat")=="" || $F("adddiary.title")=="" ||
        $F("adddiary.content")=="" ) {
      alert("请选择地点并填写标题内容");
      return;
    }
    var lnt = Number($F("adddiary.lnt"));
    var lat = Number($F("adddiary.lat"));
    if (lnt==NaN || lat==NaN) {
      alert("请选择地点");
      return;
    }
    
    AjaxRequest.item.addDiary($F("adddiary.title"), $F("adddiary.content"), lnt, lat,  $F("adddiary.tags"),
      function(){
        $("adddiary.title").value="";
        $("adddiary.content").value="";
        $("adddiary.tags").value="";
        AddDiaryDiv.hide();
      }, 
      function(){
        alert("添加失败！");
    });
  }
  $("adddiary.submitbtn").onclick = AddDiaryDiv.submitBtnOnClick;
  
  UserFactory.registerLogoutListener(AddDiaryDiv.hide);
  WorldlogMapFactory.registerClickListener(function(o, p) {
    if (p == null) return;
	  $("adddiary.lat").value = p.y;
    $("adddiary.lnt").value = p.x;
  })
</script>