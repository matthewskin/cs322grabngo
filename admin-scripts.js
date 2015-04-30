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

function executePHP(argumentArray){
	jQuery.ajax({
		type: "POST",
		url: "jsapi.php",
		dataType: "json",

		data: argumentArray,

	    success: function (response) {
	    	console.log(response);
	    	if(response["status"] === "ERROR"){
	    		alert(response["message"]);
	    	} else {
	    		addToItemList(response);
	    	}
		}		
	});	
}

function addToItemList(items){
	$.each(items, function(){
		var item_div = "<div class='item'><div class='item-display'><p id='item-name'>" + 
			items[0].item_name + "</p><p id='item-points'>" + items[0].item_point_value + 
			"</p></div><div class='item-info'><p>" + items[0].item_desc + "</p><br><p id='allergen-info'>" + 
			items[0].item_allergen_info + "</p><br><form action='execute.php' method='post'><input type='hidden' name='item-id' value='" + 
			items[0].item_pk + "'><input type='hidden' name='mode' value='delete-item'><input type='submit' value='Delete Item'></form></div></div>";

		console.log(item_div);
        $("#new-items").append(item_div);
    });
}

function jsAddItem(formDataInput){
	var json = {};

	jQuery.each(formDataInput, function() {
		json[this.name] = this.value || '';
	});

	console.log(json);
	var returnItem = executePHP(json);

}

function submitAddItemForm(){
	jsAddItem($("#add-item-form").serializeArray());
	return false;
}


