/*
Austen Lake
*/

var itemsList = {};
var locationsList = {};
var studentSelectedLocation = {};
var cartList = {};

var pointTotal = 0;
// Points per swipe; determined by time of day
// To add: make pointsMax determined by time of day or maybe bassed on location selected?
var pointsMax = 0;
var pointsRemaining = 0;

var swipesUsed = 1;
// Points remaining on a swipe


var pointsDiff;
var pointsItem;


var selectedItems = [];

//Navigate between tabs (Show and hide divs)
function changeTab(mode){
	if(mode === "Item"){
		//Check to see if the items panel is already selected.
		if($("#content #column-left #items-list").css("display") === "none"){
			if($("#content #column-right #edit-location").css("display") !== "none"){
				$("#content #column-right #edit-location").slideUp(300, function(){
					$("#content #column-right #add-item").slideDown(300);
				});
			} else {
				$("#content #column-right #add-location").slideUp(300, function(){
					$("#content #column-right #add-item").slideDown(300);
				});
			}
			$("#content #column-left #locations-list").slideUp(300, function(){
				$("#content #column-left #items-list").slideDown(300);
			});
		}		
	} else if (mode === "Location"){
		if($("#content #column-left #locations-list").css("display") === "none"){
			if($("#content #column-right #edit-item").css("display") !== "none"){
				$("#content #column-right #edit-item").slideUp(300, function(){
					$("#content #column-right #add-location").slideDown(300);
				});
			} else {
				$("#content #column-right #add-item").slideUp(300, function(){
					$("#content #column-right #add-location").slideDown(300);
				});
			}
			$("#content #column-left #items-list").slideUp(300, function(){
				$("#content #column-left #locations-list").slideDown(300);
			});
		}
	}
}

//Add items returned by the server to the page and global array
function addToItemList(items, mode, user){

	// console.log(items);

	$.each(items, function(){
		var htmlID = "item-key-" + this.item_pk;
		var specialDiet;

		if(this.item_special_diet == null){
			specialDiet = "";
		} else {
			specialDiet = this.item_special_diet;
		}

		if(mode === "new-item" || mode === "update"){
			var item_div = "<div class='item' id='" + htmlID + "' style='display:none'><div class='item-display'><p id='item-name'>" + 
				this.item_name + "</p><p id='item-points'>" + this.item_point_value + "</p><p id='item-special-diet'>" + specialDiet +
				"</p><img src='./images/edit-pencil.png' alt='Edit' class='edit-pencil-item' /></div><div class='item-info'><div id='item-info-desc'><p>" + 
				this.item_desc + "</p></div><div id='item-info-options'><img src='./images/delete-button.png' alt='Delete' class='delete-button-item' /></div>" +
				"<div id='item-info-contains'><p id='allergen-info'>" + 
				this.item_allergen_info + "</p></div></div></div>";
		} else {
			if(user === "student"){
				var item_div = "<div class='item' id='" + htmlID + "'><div class='item-display'><p id='item-name'>" + 
					this.item_name + "</p><p id='item-points'>" + this.item_point_value + "</p><p id='item-special-diet'>" + specialDiet +
					"</p><img src='./images/add-items-button.png' alt='Add Items' class='add-item-cart-button' /></div><div class='item-info'><p>" + 
					this.item_desc + "</p><br><p id='allergen-info'>" + 
					this.item_allergen_info + "</p></div></div>";
			} else if(user === "admin"){
				var item_div = "<div class='item' id='" + htmlID + "'><div class='item-display'><p id='item-name'>" + 
					this.item_name + "</p><p id='item-points'>" + this.item_point_value + "</p><p id='item-special-diet'>" + specialDiet +
					"</p><img src='./images/edit-pencil.png' alt='Edit' class='edit-pencil-item' /></div><div class='item-info'><div id='item-info-desc'><p>" + 
					this.item_desc + "</p></div><div id='item-info-options'><img src='./images/delete-button.png' alt='Delete' class='delete-button-item' /></div>" +
					"<div id='item-info-contains'><p id='allergen-info'>" + 
					this.item_allergen_info + "</p></div></div></div>";
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
        } else if (mode === "update"){
        	var oldItem = $("#items-list #loaded-items #" + htmlID);
        	oldItem.after(item_div);
        	oldItem.slideUp(250, function() {
        		oldItem.remove();
        		$("#items-list #loaded-items #" + htmlID).slideDown(250);
        	});         	
        }
    });
}

//Add locations returned by the server to the page and global array
function addToLocationList(locations, mode){

	var locationKeys = [];

	// console.log(locations);

	$.each(locations, function(){
		locationKeys.push(this.location_pk);
		var htmlID = "location-key-" + this.location_pk;		

		if(mode === "new-location" || mode === "update"){
			var location_div = "<div class='location' id='" + htmlID + "' style='display:none'><div class='location-display'><p id='location-name'>" + 
				this.location_name + "</p><div id='location-times'><input type='time' readonly='readonly' value='" + this.location_time_open + "'> to " + 
	            "<input type='time' readonly='readonly' value='" + this.location_time_closed + 
	            "'></div><div id='max-points'>" + this.location_max_points + " Pt(s)</div><img src='./images/edit-pencil.png' alt='Edit' class='edit-pencil-location' /></div>" + 
	            "<div class='location-info'><div id='location-info-desc'><p>" + 
	            this.location_info + "</p></div>" + 
	            "<div id='location-info-options'><img src='./images/delete-button.png' alt='Delete' class='delete-button-location' /></div>" +
	            "<p id='items-title'>Items <img src='./images/add-items-button.png' alt='Add Items' class='add-item-button' /></p><div id='location-info-items'></div></div></div>";
	    } else {
	    	var location_div = "<div class='location' id='" + htmlID + "'><div class='location-display'><p id='location-name'>" + 
				this.location_name + "</p><div id='location-times'><input type='time' readonly='readonly' value='" + this.location_time_open + "'> to " + 
	            "<input type='time' readonly='readonly' value='" + this.location_time_closed + 
	            "'></div><div id='max-points'>" + this.location_max_points + " Pt(s)</div><img src='./images/edit-pencil.png' alt='Edit' class='edit-pencil-location' /></div>" + 
	            "<div class='location-info'><div id='location-info-desc'><p>" + 
	            this.location_info + "</p></div>" + 
	            "<div id='location-info-options'><img src='./images/delete-button.png' alt='Delete' class='delete-button-location' /></div>" +
	            "<p id='items-title'>Items <img src='./images/add-items-button.png' alt='Add Items' class='add-item-button' /></p><div id='location-info-items'></div></div></div>";
	    }	    

		//Create new object and store location in global array
		newLocation = {};

		newLocation["location_pk"] = this.location_pk;
		newLocation["location_name"] = this.location_name;
		newLocation["location_time_open"] = this.location_time_open;
		newLocation["location_time_closed"] = this.location_time_closed;
		newLocation["location_info"] = this.location_info;
		newLocation["location_max_points"] = this.location_max_points
		newLocation["location_div"] = location_div;
		newLocation["items"] = [];


		locationsList[this.location_pk] = newLocation;
		//-------------------------------------------------
		if(mode === "new-location"){
        	$("#loaded-locations").prepend(location_div);
        	$("#" + htmlID).slideDown(250);
        } else if (mode === "loaded-locations"){
        	$("#loaded-locations").append(location_div);
        } else if (mode === "update"){
        	var oldLocation = $("#locations-list #loaded-locations #" + htmlID);
        	oldLocation.after(location_div);
        	oldLocation.slideUp(250, function() {
        		oldLocation.remove();
        		$("#locations-list #loaded-locations #" + htmlID).slideDown(250);
        	});         	
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
		    		$("#location-key-" + value + " #location-info-items").empty();
		    		$.each(response, function(innerIndex, innerValue){
		    			var itemKey = itemsList[innerValue].item_pk;
		    			var itemName = itemsList[innerValue].item_name;
		    			var itemPointValue = itemsList[innerValue].item_point_value;
		    			var itemDescription = itemsList[innerValue].item_desc;

		    			var locationItemDiv = "<div class='location-item-display' id='item-key-" + itemKey + "'><p id='location-item-name'>"+ itemName +
		    			"</p><p id='location-item-points'>" + itemPointValue + "</p><p id='location-item-desc'>" + itemDescription + 
		    			"</p><img src='./images/delete-button.png' alt='Delete' class='delete-button-item-location'></div>"

		    			$("#location-key-" + value + " #location-info-items").append(locationItemDiv);
		    		});
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

	// console.log(json);
	
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
	    		$("#add-item-form")[0].reset();
	    	}
		}		
	});
}

//Send a request to the server to query and return all items
function jsListItems(user){
	var json = {};

	json["endpoint"] = "list-items";

	// console.log(json);
	
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

	// console.log(json);
	
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
	locationsList = {};
	var json = {};

	json["endpoint"] = "list-locations";

	// console.log(json);
	
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

//Generate the location items list by adding divs generate from itemsList
function createDialogItems(locationKey){
	$.each(itemsList, function() {
		if($.inArray(this["item_pk"], locationsList[locationKey]["items"]) === -1){		
			var htmlID = "item-key-" + this["item_pk"];

			var locationItemsDiv = "<div class='item' id='" + htmlID + "'><div class='item-display'><p id='item-name'>" + 
						this["item_name"] + "</p><p id='item-points'>" + this["item_point_value"] + "</p><p id='item-desc'>" + 
						this["item_desc"] + "</p></div></div>";

			$("#dialog #location-items-list").append(locationItemsDiv);
		}
	});
}

//Add items that have been selected from dialog to the location join (Preforms the query)
function addLocationItems(locationKey){	
	$.each(selectedItems, function(index, value){
		json = {};

		json["endpoint"] = "add-location-item";
		json["location-key"] = locationKey;
		json["item-key"] = value;

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
		    		console.log(response);
		    		getLocationsItems([locationKey]);
		    	}
			}		
		});
	});	
}

//Serialize the add form and pass it to the add item handling function
function submitAddItemForm(){
	jsAddItem($("#add-item-form").serializeArray());
	return false;
}

function submitEditItemForm(){
	jsEditItem($("#edit-item-form").serializeArray());
	return false;
}

//Serialize the location form and pass it to the add location handling function
function submitAddLocationForm(){
	jsAddLocation($("#add-location-form").serializeArray());
	return false;
}

function submitEditLocationForm(){
	jsEditLocation($("#edit-location-form").serializeArray());
	return false;
}

function jsEditItemTab(itemID) {
	if($("#content #column-right #edit-item").css("display") !== "none"){
		$("#content #column-right #edit-item").slideUp(300, function(){
			$("#content #column-right #edit-item").slideDown(300);
			document.forms['edit-item-form'].elements['item-pk'].value = itemID;
			document.forms['edit-item-form'].elements['item-name'].value = itemsList[itemID]["item_name"];
			document.forms['edit-item-form'].elements['item-desc'].value = itemsList[itemID]["item_desc"];
			document.forms['edit-item-form'].elements['point-value'].value = itemsList[itemID]["item_point_value"];
			document.forms['edit-item-form'].elements['allergen-info'].value = itemsList[itemID]["item_allergen_info"];
			document.forms['edit-item-form'].elements['item-special-diet'].value = itemsList[itemID]["item_special_diet"];
		});
	} else {
		$("#content #column-right #add-item").slideUp(300, function(){
			$("#content #column-right #edit-item").slideDown(300);
			document.forms['edit-item-form'].elements['item-pk'].value = itemID;
			document.forms['edit-item-form'].elements['item-name'].value = itemsList[itemID]["item_name"];
			document.forms['edit-item-form'].elements['item-desc'].value = itemsList[itemID]["item_desc"];
			document.forms['edit-item-form'].elements['point-value'].value = itemsList[itemID]["item_point_value"];
			document.forms['edit-item-form'].elements['allergen-info'].value = itemsList[itemID]["item_allergen_info"];
			document.forms['edit-item-form'].elements['item-special-diet'].value = itemsList[itemID]["item_special_diet"];
		});
	}
}

function jsEditLocationTab(locationID) {
	if($("#content #column-right #edit-location").css("display") !== "none"){
		$("#content #column-right #edit-location").slideUp(300, function(){
			$("#content #column-right #edit-location").slideDown(300);
			document.forms['edit-location-form'].elements['location-pk'].value = locationID;
			document.forms['edit-location-form'].elements['location-name'].value = locationsList[locationID]["location_name"];
			document.forms['edit-location-form'].elements['location-open-time'].value = locationsList[locationID]["location_time_open"];
			document.forms['edit-location-form'].elements['location-close-time'].value = locationsList[locationID]["location_time_closed"];
			document.forms['edit-location-form'].elements['location-swipe-points'].value = locationsList[locationID]["location_max_points"];
			document.forms['edit-location-form'].elements['location-info'].value = locationsList[locationID]["location_info"];
		});
	} else {
		$("#content #column-right #add-location").slideUp(300, function(){
			$("#content #column-right #edit-location").slideDown(300);
			document.forms['edit-location-form'].elements['location-pk'].value = locationID;
			document.forms['edit-location-form'].elements['location-name'].value = locationsList[locationID]["location_name"];
			document.forms['edit-location-form'].elements['location-open-time'].value = locationsList[locationID]["location_time_open"];
			document.forms['edit-location-form'].elements['location-close-time'].value = locationsList[locationID]["location_time_closed"];
			document.forms['edit-location-form'].elements['location-swipe-points'].value = locationsList[locationID]["location_max_points"];
			document.forms['edit-location-form'].elements['location-info'].value = locationsList[locationID]["location_info"];
		});
	}
}

function cancelEdit(editForm) {
	if(editForm === "item"){
		$("#content #column-right #edit-item").slideUp(300, function(){
			$("#content #column-right #add-item").slideDown(300);
		});
	} else if(editForm === "location"){
		$("#content #column-right #edit-location").slideUp(300, function(){
			$("#content #column-right #add-location").slideDown(300);
		});
	}

	return false;
}

function jsEditItem(formDataInput){
	var json = {};

	jQuery.each(formDataInput, function() {
		json[this.name] = this.value || '';
	});

	var itemID = json["item-pk"];
	
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
	    		cancelEdit("item");
	    		addToItemList(response, "update", "admin");

	    		//Repaint the locations/items divs to reflect changes to the items
    			var locationKeys = [];
    			$.each(locationsList, function() {
    				locationKeys.push(this["location_pk"]);
    			});
    			getLocationsItems(locationKeys);

    			$("#edit-item-form")[0].reset();
	    	}
		}		
	});
}

function jsEditLocation(formDataInput){
	var json = {};

	jQuery.each(formDataInput, function() {
		json[this.name] = this.value || '';
	});

	console.log(json);
	var locationID = json["location-pk"];
	
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
	    		cancelEdit("location");
	    		addToLocationList(response, "update");

    			$("#edit-location-form")[0].reset();
	    	}
		}		
	});
}

function getItemsFromLocation(locationID){
	json = {};

	json["endpoint"] = "get-items-from-location";
	json["location-pk"] = locationID;
	
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
				console.log(response);
				addToItemList(response, "loaded-items", "student");
			}
		}		
	});
}

function getLocation(locationID){
	json = {};

	json["endpoint"] = "get-location";
	json["location-pk"] = locationID;

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
				console.log(response);
				studentSelectedLocation = response[0];

				pointsMax = pointsRemaining = response[0]["location_max_points"];
				reloadCart();
			}
		}		
	});
}

function jsDeleteItem(itemID){
	var json = {};

	json["endpoint"] = "delete-item";
	json["item_pk"] = itemID;

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
	    		console.log(response);
	    		
	    		delete itemsList[itemID];

	    		$("#item-key-" + itemID + ".item").slideUp(300, function() { 
	    			$(this).remove();
	    		});

    			//Repaint the locations/items divs to remove the deleted item
    			var locationKeys = [];
    			$.each(locationsList, function() {
    				locationKeys.push(this["location_pk"]);
    			});
    			getLocationsItems(locationKeys);
	    	}
		}		
	});
}

function jsDeleteLocation(locationID){

	var json = {}; 
	
	json["endpoint"] = "delete-location";
	json["location_pk"] = locationID;
 
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
	    		console.log(response);
	    		
	    		delete locationsList[locationID];

	    		$("#location-key-" + locationID).slideUp(300, function() { 
	    			$(this).remove();
	    		});
	    	}
		}		
	});
}

function jsDeleteLocationItem(locationID, itemID){

	var json = {};

	json["endpoint"] = "delete-location-item";
	json["location_pk"] = locationID;
	json["item_pk"] = itemID;

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
	    		getLocationsItems([locationID]);
	    	}
		}		
	});	

}

var recursionCounter = 0;
function getElementID(selector, recursionDepth, searchString){
	var elementID = selector.attr("id");
	if(elementID === undefined){
		elementID = "";
	}
	if(elementID.indexOf(searchString) !== -1){
		elementID = elementID.split("-")[2];
		recursionCounter = 0;
		return elementID;
	} else {
		if(recursionCounter < recursionDepth){
			recursionCounter++;
			return getElementID(selector.parent(), recursionDepth, searchString);
		} else {
			recursionCounter = 0;
			alert("The element clicked does not have an associated key.");
			return false;
		}
	}
}

Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

function addItemToCart(itemID){
	pointsItem = Number(itemsList[itemID]["item_point_value"]);
	pointTotal += pointsItem; //This line is doing 2+4=24 I think
	if(pointsItem < pointsRemaining){
		pointsRemaining = pointsRemaining - pointsItem;
		if (cartList[itemID] !== undefined) {
			cartList[itemID]["count"] += 1;
			//Increase value by 1
			//cartList[itemID]["count"] = 1;
			//Need to figure out how to add a number of items column for each item
		} else {
			cartList[itemID] = itemsList[itemID];
			cartList[itemID]["count"] = 1;
		}
		reloadCart();
	} else if(pointsItem == pointsRemaining) {
		pointsRemaining = 0;
		if (cartList[itemID] !== undefined) {
			cartList[itemID]["count"] += 1;
			//Increase value by 1
			//cartList[itemID]["count"] = 1;
			//Need to figure out how to add a number of items column for each item
		} else {
			cartList[itemID] = itemsList[itemID];
			cartList[itemID]["count"] = 1;
		}
		reloadCart();
	} else if(swipesUsed < 4) {
		pointsDiff = pointsItem - pointsRemaining;
		swipesUsed = swipesUsed + 1;
		pointsRemaining = pointsMax - pointsDiff;
		
		if (cartList[itemID] !== undefined) {
			cartList[itemID]["count"] += 1;
			//Increase value by 1
			//cartList[itemID]["count"] = 1;
			//Need to figure out how to add a number of items column for each item
		} else {
			cartList[itemID] = itemsList[itemID];
			cartList[itemID]["count"] = 1;
		}
		reloadCart();
		
	} else {
		alert("Cannot add item; insufficient points remaining.");
	}

	//alert("Point total (test)=" + pointTotal);
}

function deleteItemFromCart(itemID){
	cartList[itemID] = "";
	pointTotal -= Number(itemsList[itemID]["item_point_value"]);
	//cartList[itemID]["count"] = 1;
	reloadCart();
}

//Create cart divs from cartItems list
function reloadCart(){
	$("#cart-loaded-items").empty();
	$.each(cartList, function() {
				
		var htmlID = "item-key-" + this["item_pk"];

		var cartItemsDiv = "<div class='item' id='" + htmlID + "'><div class='item-display'><span id='item-count'>" + this["count"] + "</span><span> x </span><span id='item-name'>" + 
					this["item_name"] + "</span><span><img style='float: right' src='images/delete-button.png' height='18' width='18' alt='Delete Item' class='delete-item-cart-button'></img></span><span id='item-points' style='float:right'>" + this["item_point_value"] * this["count"] + 
					"</span></div></div><br />";
		
		
		/*
		"<div class='item' id='" + htmlID + "'>
			<div class='item-display'>
				<span id='item-count'>" + this["count"] + "</span>
				<span> x </span><span id='item-name'>" + this["item_name"] + "</span>
				<span id='item-points' style='float:right'>" + this["item_point_value"] * this["count"] + "</span>
			</div>
		</div>
		<br />";
		
		
		*/
		$("#cart-loaded-items").append(cartItemsDiv);		
	});
	// Update shopping cart information	
	document.getElementById("points-remain").innerHTML = pointsRemaining;
	document.getElementById("points-per").innerHTML = pointsMax;
	document.getElementById("swipes-used").innerHTML = swipesUsed;
}

function submitOrder(){
	var orderStr = "Items:\n";
	$.each(cartList, function() {
		orderStr = orderStr + " " + this["count"] + " x " + this["item_name"] + "\n";
	});
	orderStr = orderStr + "\nPoints: " + pointTotal + " Swipes: " + swipesUsed;
	alert(orderStr);
}

function onSignInCallback(authResult){
	if (authResult['status']['signed_in']) {
		alert("Login Successful");
		// Update the app to reflect a signed in user
		// Hide the sign-in button now that the user is authorized, for example:
		document.getElementById('signinButton').setAttribute('style', 'display: none');
	} else {
		// Update the app to reflect a signed out user
		// Possible error values:
		//   "user_signed_out" - User is signed-out
		//   "access_denied" - User denied access to your app
		//   "immediate_failed" - Could not automatically log in the user
		
		console.log('Sign-in state: ' + authResult['error']);
	}
}

function logoutGoogle(){
    gapi.auth.signOut();
    window.location.href = "http://cs.knox.edu/grabngo/login.php";
}	