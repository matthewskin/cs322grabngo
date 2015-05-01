var itemsList = {};
var locationsList = {};

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

function addToItemList(items, mode){
	console.log(items);

	$.each(items, function(){

		var item_div = "<div class='item' id='item-" + this.item_pk + "'><div class='item-display'><p id='item-name'>" + 
			this.item_name + "</p><p id='item-points'>" + this.item_point_value + 
			"</p></div><div class='item-info'><p>" + this.item_desc + "</p><br><p id='allergen-info'>" + 
			this.item_allergen_info + "</p><br><form action='execute.php' method='post'><input type='hidden' name='item-id' value='" + 
			this.item_pk + "'><input type='hidden' name='mode' value='delete-item'><input type='submit' value='Delete Item'></form></div></div>";

		//Create new object and store item in global array

		newItem = {};

		newItem["item_pk"] = this.item_pk;
		newItem["item_name"] = this.item_name;
		newItem["item_point_value"] = this.item_point_value;
		newItem["item_desc"] = this.item_desc; 
		newItem["item_allergen_info"] = this.item_allergen_info; 
		newItem["item_div"] = item_div;

		itemsList[this.item_pk] = newItem;

		//---------------------------------------

		//console.log(item_div);
		
		if(mode === "new-item"){
        	$("#new-items").append(item_div);
        } else if (mode === "loaded-items"){
        	$("#loaded-items").append(item_div);
        }
    });
}

function jsAddItem(formDataInput){
	var json = {};

	jQuery.each(formDataInput, function() {
		json[this.name] = this.value || '';
	});

	console.log(json);
	
	jQuery.ajax({
		type: "POST",
		url: "jsapi.php",
		dataType: "json",

		data: json,

	    success: function (response) {
	    	if(response["status"] === "ERROR"){
	    		alert(response["message"]);
	    	} else {
	    		addToItemList(response, "new-item");
	    	}
		}		
	});	

}

function jsListItems(){
	var json = {};

	json["endpoint"] = "list-items";

	console.log(json);
	
	jQuery.ajax({
		type: "POST",
		url: "jsapi.php",
		dataType: "json",

		data: json,

	    success: function (response) {
	    	if(response["status"] === "ERROR"){
	    		alert(response["message"]);
	    	} else {
	    		addToItemList(response, "loaded-items");
	    	}
		}		
	});	
}

function jsAddLocation(){
	;
}

function jsListLocations(){
	;
}

function submitAddItemForm(){
	jsAddItem($("#add-item-form").serializeArray());
	return false;
}




