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
function addToItemList(items, mode, user){

	console.log(items);

	$.each(items, function(){
		var htmlID = "item-" + this.item_pk;
		var specialDiet;

		if(this.item_special_diet == null){
			specialDiet = "";
		} else {
			specialDiet = this.item_special_diet;
		}

		if(mode === "new-item"){
			var item_div = "<div class='item' id='" + htmlID + "' style='display:none'><div class='item-display'><p id='item-name'>" + 
				this.item_name + "</p><p id='item-points'>" + this.item_point_value + "</p><p id='item-special-diet'>" + specialDiet +
				"</p><img src='./images/edit-pencil.png' alt='Edit' class='edit-pencil' /></div><div class='item-info'><p>" + 
				this.item_desc + "</p><br><p id='allergen-info'>" + 
				this.item_allergen_info + "</p><br><form action='execute.php' method='post'><input type='hidden' name='item-id' value='" + 
				this.item_pk + "'><input type='hidden' name='mode' value='delete-item'><input type='submit' value='Delete Item'></form></div></div>";
		} else {
			if(user === "student"){
				var item_div = "<div class='item' id='" + htmlID + "'><div class='item-display'><p id='item-name'>" + 
					this.item_name + "</p><p id='item-points'>" + this.item_point_value + "</p><p id='item-special-diet'>" + specialDiet +
					"</p></div><div class='item-info'><p>" + 
					this.item_desc + "</p><br><p id='allergen-info'>" + 
					this.item_allergen_info + "</p></div></div>";
			} else if(user === "admin"){
				var item_div = "<div class='item' id='" + htmlID + "'><div class='item-display'><p id='item-name'>" + 
					this.item_name + "</p><p id='item-points'>" + this.item_point_value + "</p><p id='item-special-diet'>" + specialDiet +
					"</p><img src='./images/edit-pencil.png' alt='Edit' class='edit-pencil' /></div><div class='item-info'><p>" + 
					this.item_desc + "</p><br><p id='allergen-info'>" + 
					this.item_allergen_info + "</p><br><form action='execute.php' method='post'><input type='hidden' name='item-id' value='" + 
					this.item_pk + "'><input type='hidden' name='mode' value='delete-item'><input type='submit' value='Delete Item'></form></div></div>";
			}	
		}

		//Create new object and store item in global array

		newItem = {};

		newItem["item_pk"] = this.item_pk;
		newItem["item_name"] = this.item_name;
		newItem["item_point_value"] = this.item_point_value;
		newItem["item_desc"] = this.item_desc; 
		newItem["item_allergen_info"] = this.item_allergen_info;
		newItem["item_special_diet"] = this.item_special_diet;
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

	var locationKeys = [];

	console.log(locations);

	$.each(locations, function(){
		locationKeys.push(this.location_pk);
		var htmlID = "location-" + this.location_pk;		

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
		//-------------------------------------------------
		if(mode === "new-location"){
        	$("#loaded-locations").prepend(location_div);
        	$("#" + htmlID).slideDown(250);
        } else if (mode === "loaded-locations"){
        	$("#loaded-locations").append(location_div);
        }

    });
	
	//Need to do this in a separate function once everything has been created because Ajax is async.
	getLocationsItems(locationKeys);
}

function getLocationsItems(locationKeys){
	$.each(locationKeys, function(index, value) {
		//Get the items associated with this location.
	    var json = {"endpoint":"list-location-items", "location-pk":value};
		
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
		    		locationsList[value]["items"] = response;
		    	}
			}		
		});
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
function jsListItems(user){
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
	    		if(user === "student"){
	    			addToItemList(response, "loaded-items", "student");
	    		} else if (user === "admin"){
	    			addToItemList(response, "loaded-items", "admin");
	    		}
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

function jsEditItem(itemID){
	alert(itemID);
	return false;
}

var recursionCounter = 0;
function getItemID(selector, recursionDepth){
	var itemID = selector[0]["id"];
	if(itemID.indexOf("item-") != -1){
		itemID = itemID.split("-")[1];
		return itemID;
	} else {
		if(recursionCounter < recursionDepth){
			recursionCounter++;
			return getItemID(selector.parent(), recursionDepth);
		} else {
			recursionCounter = 0;
			alert("The element clicked does not belong to an item.");
			return false;
		}
	}
}




