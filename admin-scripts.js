var itemsList = {};
var locationsList = {};

//Navigate between tabs (Show and hide divs)
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

//Add items returned by the server to the page and global array
function addToItemList(items, mode){

	console.log(items);

	var htmlID = "item-" + this.item_pk;

	$.each(items, function(){
		if(mode === "new-item"){
			var item_div = "<div class='item' id='" + htmlID + "' style='display:none'><div class='item-display'><p id='item-name'>" + 
				this.item_name + "</p><p id='item-points'>" + this.item_point_value + 
				"</p></div><div class='item-info'><p>" + this.item_desc + "</p><br><p id='allergen-info'>" + 
				this.item_allergen_info + "</p><br><form action='execute.php' method='post'><input type='hidden' name='item-id' value='" + 
				this.item_pk + "'><input type='hidden' name='mode' value='delete-item'><input type='submit' value='Delete Item'></form></div></div>";
		} else {
			var item_div = "<div class='item' id='" + htmlID + "'><div class='item-display'><p id='item-name'>" + 
				this.item_name + "</p><p id='item-points'>" + this.item_point_value + 
				"</p></div><div class='item-info'><p>" + this.item_desc + "</p><br><p id='allergen-info'>" + 
				this.item_allergen_info + "</p><br><form action='execute.php' method='post'><input type='hidden' name='item-id' value='" + 
				this.item_pk + "'><input type='hidden' name='mode' value='delete-item'><input type='submit' value='Delete Item'></form></div></div>";
		}

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
        	$("#loaded-items").prepend(item_div);
        	$("#" + htmlID).slideDown(250);
        } else if (mode === "loaded-items"){
        	$("#loaded-items").append(item_div);
        }
    });
}

//Add locations returned by the server to the page and global array
function addToLocationList(locations, mode){

	console.log(locations);

	var htmlID = "location-" + this.location_pk;

	$.each(locations, function(){

		if(mode === "new-location"){
			var location_div = "<div class='location' id='" + htmlID + "' style='display:none'><div class='location-display'><p id='location-name'>" + 
				this.location_name + "</p><input type='time' readonly='readonly' value='" + this.location_time_open + "'> to " + 
	            "<input type='time' readonly='readonly' value='" + this.location_time_closed + "'></div><div class='location-info'><p>" + 
	            this.location_info + "</p><br><form action='execute.php' method='post'><input type='hidden' name='location-id' value='" + 
	            this.location_pk + "'><input type='hidden' name='mode' value='delete-location'>" +
	            "<input type='submit' value='Delete Location'></form></div></div>";
	    } else {
	    	var location_div = "<div class='location' id='" + htmlID + "'><div class='location-display'><p id='location-name'>" + 
				this.location_name + "</p><input type='time' readonly='readonly' value='" + this.location_time_open + "'> to " + 
	            "<input type='time' readonly='readonly' value='" + this.location_time_closed + "'></div><div class='location-info'><p>" + 
	            this.location_info + "</p><br><form action='execute.php' method='post'><input type='hidden' name='location-id' value='" + 
	            this.location_pk + "'><input type='hidden' name='mode' value='delete-location'>" +
	            "<input type='submit' value='Delete Location'></form></div></div>";
	    }

		//Create new object and store location in global array

		newLocation = {};

		newLocation["location_pk"] = this.location_pk;
		newLocation["location_name"] = this.location_name;
		newLocation["location_time_open"] = this.location_time_open;
		newLocation["location_time_closed"] = this.location_time_closed;
		newLocation["location_info"] = this.location_info;
		newLocation["location_div"] = location_div;

		locationsList[this.location_pk] = newLocation;

		//---------------------------------------

		//console.log(item_div);
		
		if(mode === "new-location"){
        	$("#loaded-locations").prepend(location_div);
        	$("#" + htmlID).slideDown(250);
        } else if (mode === "loaded-locations"){
        	$("#loaded-locations").append(location_div);
        }
    });
}

//Send a request to the server to create and return an item
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
	    		console.log(response);
	    		alert(response["message"]);
	    	} else {
	    		addToItemList(response, "new-item");
	    	}
		}		
	});
}

//Send a request to the server to query and return all items
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
	    		console.log(response);
	    		alert(response["message"]);
	    	} else {
	    		addToItemList(response, "loaded-items");
	    	}
		}		
	});	
}

//Send a request to the server to create and return a location
function jsAddLocation(formDataInput){
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
	    		console.log(response);
	    		alert(response["message"]);
	    	} else {
	    		addToLocationList(response, "new-location");
	    	}
		}		
	});
}

//Send a request to the server to query and return all locations
function jsListLocations(){
	var json = {};

	json["endpoint"] = "list-locations";

	console.log(json);
	
	jQuery.ajax({
		type: "POST",
		url: "jsapi.php",
		dataType: "json",

		data: json,

	    success: function (response) {
	    	if(response["status"] === "ERROR"){
	    		console.log(response);
	    		alert(response["message"]);
	    	} else {
	    		addToLocationList(response, "loaded-locations");
	    	}
		}		
	});
}

//Serialize the add form and pass it to the add item handling function
function submitAddItemForm(){
	jsAddItem($("#add-item-form").serializeArray());
	return false;
}

//Serialize the location form and pass it to the add location handling function
function submitAddLocationForm(){
	jsAddLocation($("#add-location-form").serializeArray());
	return false;
}




