function add() {
	var d=document.createElement('div');
	var o=document.getElementById('查询框');
	var f=document.createElement('form');
	var u=document.createElement('ul');
	
	var li1=document.createElement('li');
	var li2=document.createElement('li');
	var li3=document.createElement('li');
	var li4=document.createElement('li');
	var li5=document.createElement('li');
	
	var i1=document.createElement('input');
	var i2=document.createElement('input');
	var i3=document.createElement('input');
	var i4=document.createElement('input');
	var ok=document.createElement('input');
	
	d.setAttribute("class","list1");
	ok.setAttribute("type","submit");
	ok.setAttribute("name","add");
	ok.setAttribute("value","添加该课程");
	
	i1.setAttribute("type","text");
	i1.setAttribute("name","kch");
	i1.setAttribute("placeholder","请输入课程号");
	i1.setAttribute("required","required");
	
	i2.setAttribute("type","text");
	i2.setAttribute("name","kcm");
	i2.setAttribute("placeholder","请输入课程名");
	i1.setAttribute("required","required");
	
	i3.setAttribute("type","text");
	i3.setAttribute("name","xs");
	i3.setAttribute("placeholder","请输入学时");
	i1.setAttribute("required","required");
	
	i4.setAttribute("type","text");
	i4.setAttribute("name","xf");
	i4.setAttribute("placeholder","请输入学分");
	i1.setAttribute("required","required");
	
	f.setAttribute("method","post");
	f.setAttribute("action","t_xs_kc_mgr.php");
	
	u.appendChild(li1);
	li1.appendChild(i1);
	
	u.appendChild(li2);
	li2.appendChild(i2);
	
	u.appendChild(li3);
	li3.appendChild(i3);
	
	u.appendChild(li4);
	li4.appendChild(i4);
	
	u.appendChild(li5);
	li5.appendChild(ok);
	
	f.appendChild(u);
	d.appendChild(f);
	o.appendChild(d);
}
function update(i) {
  var c=document.getElementsByClassName('list1')[i].children[0].children[0];
  var text=document.getElementsByClassName('list1')[i].children[0].children[0].innerHTML;
  
  var cc=c.childNodes[0];
  var ok=document.createElement('input');
  ok.setAttribute("type","text");
  ok.setAttribute("name","kch");
  ok.setAttribute("disabled","disabled");
  ok.setAttribute("value",text);
  c.replaceChild(ok,cc);
  //------
  var c=document.getElementsByClassName('list1')[i].children[0].children[1];
  var text=document.getElementsByClassName('list1')[i].children[0].children[1].innerHTML;
  
  var cc=c.childNodes[0];
  var ok=document.createElement('input');
  ok.setAttribute("type","text");
  ok.setAttribute("name","kcm");
  ok.setAttribute("value",text);
  c.replaceChild(ok,cc);
  //------
  var c=document.getElementsByClassName('list1')[i].children[0].children[2];
  var text=document.getElementsByClassName('list1')[i].children[0].children[2].innerHTML;
  
  var cc=c.childNodes[0];
  var ok=document.createElement('input');
  ok.setAttribute("type","text");
  ok.setAttribute("name","xs");
  ok.setAttribute("value",text);
  c.replaceChild(ok,cc);
  //------
  var c=document.getElementsByClassName('list1')[i].children[0].children[3];
  var text=document.getElementsByClassName('list1')[i].children[0].children[3].innerHTML;
  
  var cc=c.childNodes[0];
  var ok=document.createElement('input');
  ok.setAttribute("type","text");
  ok.setAttribute("name","xf");
  ok.setAttribute("value",text);
  c.replaceChild(ok,cc);
  //------
  var c=document.getElementsByClassName('list1')[i].children[0].children[4];
  
  var cc=c.childNodes[0];
  var zong=document.createElement('span');
  var ok=document.createElement('input');
  ok.setAttribute("type","button");
  ok.setAttribute("name","tijiao");
  ok.setAttribute("value","确定");
  var de=document.createElement('input');
  de.setAttribute("type","button");
  de.setAttribute("name","shanchu");
  de.setAttribute("value","删除");
  var k=document.createTextNode(" ");
  zong.appendChild(ok);
  zong.appendChild(k);
  zong.appendChild(de);
  c.replaceChild(zong,cc);
  var v="transfer("+i+",1)";
  ok.setAttribute("onclick",v);
  var v="transfer("+i+",0)";
  de.setAttribute("onclick",v);
}
function transfer(i,cmd) {
	var text=document.getElementsByClassName('list1')[i].children[0].children[0].childNodes[0].value;
	document.getElementById('kch0').setAttribute("value",text);
	var text=document.getElementsByClassName('list1')[i].children[0].children[1].childNodes[0].value;
	document.getElementById('kcm0').setAttribute("value",text);
	var text=document.getElementsByClassName('list1')[i].children[0].children[2].childNodes[0].value;
	document.getElementById('xs0').setAttribute("value",text);
	var text=document.getElementsByClassName('list1')[i].children[0].children[3].childNodes[0].value;
	document.getElementById('xf0').setAttribute("value",text);
	
	document.getElementById('cmd').setAttribute("value",cmd);
	//document.getElementById('up').submit();
	if(cmd=='0'){
	  var r=confirm("确定删除？");
	  if (r == true) {
		  document.getElementById('submit0').click();
		  } 
	}
	if(cmd=='1'){
		var r=confirm("确定修改？");
		if (r == true) {
		  document.getElementById('submit0').click();
		  } 
	}
  
}