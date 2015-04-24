

function changeTab(mode){
	if(mode === "Item"){
		$("#content #column-right #add-location").hide(0);
		$("#content #column-left #locations-list").hide(0);
		$("#content #column-right #add-item").show(0);
		$("#content #column-left #items-list").show(0);
	} else if (mode === "Location"){
		$("#content #column-right #add-location").show(0);
		$("#content #column-left #locations-list").show(0);
		$("#content #column-right #add-item").hide(0);
		$("#content #column-left #items-list").hide(0);
		

	}
}

function executePHP(functionName, argumentArray){
	JQuery.ajax({
		type: "POST",
		url: "jsapi.php",
		dataType: "json",

		data: {functionname: functionName, arguments: argumentArray},

	    success: function (obj, textstatus) {
			if( !('error' in obj) ) {
			  yourVariable = obj.result;
			}
			else {
			  console.log(obj.error);
			}
        }
	});	
}
