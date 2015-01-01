var YEAHEASY_SYSTEM = true;
function changeNodeInnerHTML(sourceId, targetId, valueArray)
{
	var sourceObj = document.getElementById(sourceId);
	
	var targetObj = document.getElementById(targetId);
	if(typeof(sourceObj)=='undefined' || typeof(targetObj)=='undefined')
	{		
		return false;
	}
	if(typeof(valueArray)!='undefined')
	{
				
		var key = "ye_"+sourceObj.value;
		targetObj.innerHTML = valueArray[key];
	};

}