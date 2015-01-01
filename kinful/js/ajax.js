var req;
function Initialize(){
	try{
		req=new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try{
			req=new ActiveXObject("Microsoft.XMLHTTP");
		}catch(oc){
			req=null;
		}
	}

	if(!req&&typeof XMLHttpRequest!="undefined"){
		req=new XMLHttpRequest();
	}
}

function SendQuery(url){
	Initialize();
	if(req!=null){
		req.onreadystatechange = Process;
		req.open("GET", url, true);
        req.send(null);
	}
}

function Process(){
	if(req.readyState == 4){
    // only if "OK"
		if (req.status == 200){
			if(req.responseText=="")
				HideDiv("showdiv");
			else{
				ShowDiv("showdiv");
				document.getElementById("showdiv").innerHTML =req.responseText;
			}
		}else {
			document.getElementById("showdiv").innerHTML="There was a problem retrieving data:<br>"+req.statusText;
		}
	}
}

function ShowDiv(divid) 
{
   if (document.layers) document.layers[divid].visibility="show";
   else document.getElementById(divid).style.visibility="visible";
}

function HideDiv(divid) 
{
   if (document.layers) document.layers[divid].visibility="hide";
   else document.getElementById(divid).style.visibility="hidden";
}
