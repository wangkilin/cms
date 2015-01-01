
// 自动 COPY 代码开始
function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}
function JM_cc(ob){
	var obj=MM_findObj(ob); if (obj) { 
	obj.select();js=obj.createTextRange();js.execCommand("Copy");}
	alert("地址复制成功，您现在可以粘贴到QQ/MSN/论坛等任何地方！");
}

// 自动 COPY 代码结束
document.write('<input name="page_url" value="'+window.location.href+'" size="50" onfocus="this.select()"> <input type="button" name="Button" class="myinput" value="点击复制地址" onClick=JM_cc("page_url")> 复制本页地址给好友');
