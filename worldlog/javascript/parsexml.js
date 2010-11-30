function XmlParserHelper(){}

XmlParserHelper.objPropXmlElemMapping = function(obj, xml, propname, issubdom) {
  var elem = xml.getElementsByTagName(propname)[0];
  if (elem!=null && elem.firstChild!=null) {
    if (issubdom) obj[propname] = elem;
    else obj[propname] = elem.firstChild.nodeValue;
  }
  else obj[propname] = "";
}

XmlParserHelper.parseDateString = function(str) {
  var tmp = str.split(' ');
  var date = tmp[0];
  var time = tmp[1];
  tmp=date.split('-');
  var y=Number(tmp[0]);
  var m=Number(tmp[1]);
  var d=Number(tmp[2]);
  tmp=time.split(':');
  var h=Number(tmp[0]);
  var min=Number(tmp[1]);
  var s=Number(tmp[2]);
  return new Date(y,m-1,d,h,min,s);//month need dec, bug?
}