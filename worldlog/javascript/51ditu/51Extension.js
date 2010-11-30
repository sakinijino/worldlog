function LTTypeSelectorControl() {
}

LTTypeSelectorControl.prototype.initialize = function(map) {
  var control = this;
  control.div = document.createElement("div");
  control.div.style.backgroundColor = "white";
  control.div.style.border = "1px solid black";
  control.div.style.border = "1px solid black";
  control.div.style.paddingLeft = "2px";
  control.div.style.paddingRight = "6px";
  control.div.style.paddingTop = "1px";
  control.div.style.paddingBottom = "0px";
  control.div.style.position = "absolute";
  control.div.style.right = "5%";
  control.div.style.top = "35px";
  control.div.style.zIndex = "90";
  
  map.itemtypes.values().each(function(it){
    var input = document.createElement('input');
    input.setAttribute('type', 'checkbox');
    input.onclick = function (){map.setTypeVisible(it.name, input.checked)}
    input.checked = true;
    control.div.appendChild(input);
    var img = document.createElement('img');
    img.style.width = '16px';
    img.style.height = '16px';
    img.style.border = 0;
    img.src = it.icon;
    control.div.appendChild(img);
    control.div.appendChild(document.createTextNode(it.humanname+' '));
  });
}

LTTypeSelectorControl.prototype.getObject = function() {
  return this.div;
}