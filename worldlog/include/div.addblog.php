<div id="addblog" class="section disappear">
  如果您想在地图上显示您的Blog,在这里添加.<br/>
  请输入Blog订阅的RSS地址:<br/>
  RSS地址: <input type="text" id="addblog.rss" size="24" value=""/><span style="color:red"> *</span><br/>
  标题: <input type="text" id="addblog.title" size="14" value=""/><br/>
  经度: <input type="text" id="addblog.lnt" size="14" value="" readonly="readonly"/><span style="color:red"> *</span><br/>
  纬度: <input type="text" id="addblog.lat" size="14" value="" readonly="readonly"/><span style="color:red"> *</span><br/>
  tag: <input type="text" id="addblog.tags" size="14" value=""/><br/>
  <br/>
  在地图上选择地点,然后点击"提交Rss"完成添加.<br/>
  <input id="addblog.submitbtn" type="button" value="提交Rss"/>
</div>

<script>
  function AddBlogDiv(){}
  
  Page.generateShowHideFunc(AddBlogDiv, $("addblog"), true);
  
  AddBlogDiv.submitBtnOnClick = function() {
    if ($F("addblog.lnt")=="" || $F("addblog.lat")=="" || $F("addblog.rss")=="" ) {
      alert("请选择地点并填写rss地址");
      return;
    }
    var lnt = Number($F("addblog.lnt"));
    var lat = Number($F("addblog.lat"));
    if (lnt==NaN || lat==NaN) {
      alert("请选择地点");
      return;
    }
    
    AjaxRequest.item.addBlog(lnt, lat, $F("addblog.rss"), $F("addblog.title"), $F("addblog.tags"),
      function(){
        $("addblog.rss").value="";
        $("addblog.title").value="";
        $("addblog.tags").value="";
        AddBlogDiv.hide();
      }, 
      function(){
        alert("添加失败！");
    });
  }
  $("addblog.submitbtn").onclick = AddBlogDiv.submitBtnOnClick;
  
  UserFactory.registerLogoutListener(AddBlogDiv.hide);
  WorldlogMapFactory.registerClickListener(function(o, p) {
    if (p == null) return;
	  $("addblog.lat").value = p.y;
    $("addblog.lnt").value = p.x;
  })
</script>