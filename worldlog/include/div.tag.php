<div id="tag" class="section disappear">
  <span id="tag.currenttag"></span>
  tag <input type="text" id="tag.search" size="8" value=""/>
  <input id="tag.searchbtn" type="button" value="搜索"/>
  <input id="tag.selectbtn" type="button" value="过滤地图"/><br/><br/>
  所有tag分类: 
  <div id="tag.list"></div>
</div>

<script>
  function TagDiv(){}
  
  Page.generateShowHideFunc(TagDiv, $("tag"), true, function(){
    $("tag.list").innerHTML = "";
    AjaxRequest.tag.getAll(function(arr){
      arr.each(function(tag){
        var spn = tag.getTagSpan();
        $("tag.list").appendChild(spn);
        $("tag.list").appendChild(document.createTextNode(' '));
      });
    });
  });
  
  TagFactory.registerSelectListener(function(t){
    $("tag.currenttag").innerHTML ="";
    $("tag.currenttag").appendChild(document.createTextNode("当前Tag："+t.name+" "));
    var spn = document.createElement('span');
    spn.className = "link";
    spn.innerHTML = "[取消选择]";
    spn.onclick = function(){
      t.onUnSelect();
    }
    $("tag.currenttag").appendChild(spn);
    $("tag.currenttag").appendChild(document.createElement('br'));
    $("tag.currenttag").appendChild(document.createElement('br'));
    TagDiv.show();
  });
  TagFactory.registerUnSelectListener(function(t){
    $("tag.currenttag").innerHTML ="";
  });
  
  $('tag.searchbtn').onclick = function(){
    if ($F("tag.search")=="") {
      alert("请填写希望搜索的tag");
      return;
    }
    var tag = TagFactory.Create();
    tag.name = $F("tag.search");
    tag.onSearch();
  };
  
  $('tag.selectbtn').onclick = function(){
    if ($F("tag.search")=="") {
      alert("请填写希望搜索的tag");
      return;
    }
    var tag = TagFactory.Create();
    tag.name = $F("tag.search");
    tag.onSelect();
  };
</script>