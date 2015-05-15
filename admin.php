<?php
    /*
    Matt Skinner
    CS320 Databases
    */


    require_once("admin-utils.php");
	require_once("header.php");
?>


            <div id="menu">
                <ul>
                  <li><a id="menu-button-item" onclick="changeTab('Item'); return false;" href="">Items</a></li>
                  <li><a id="menu-button-location" onclick="changeTab('Location'); return false;" href="">Locations</a></li>
                  <li id="menu-button-logout"><a href="login.php">Logout</a></li>
                </ul>
            </div>

            <div id="column-left">
                <div id="items-list">
                    <h5>Items</h5>
                    <div id="loaded-items"></div>
                </div>

                <div id="locations-list">
                    <h5>Locations</h5>
                    <div id="loaded-locations"></div>                       
                </div>
            </div>

            <div id="clear-vertical"></div>

            <div id="column-right">
                <div id="add-item">
                    <h6>Add An Item</h6>
                    <div id="horizontal-clear"></div>
                    <form id="add-item-form">
                        <input type="hidden" name="endpoint" value="add-item">
                        <p>Item Name</p><input type="text" name="item-name"><br>
                        <p>Description</p><input type="text" name="item-desc"><br>                    
                        <p>Point Value</p>
                        <select name="point-value">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                        </select><br>
                        <p>Allergen Information</p><input type="text" id="allergen-info" name="allergen-info" value="Contains: "><br>
                        <p>Special Diet</p>
                        <select name="item-special-diet" value="">
                        	<option selected value="none">None</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                            <option value="gluten free">Gluten Free</option>                            
                        </select><br>
                        <input id="submit-button" type="button" onclick="return submitAddItemForm()" value="Add Item">
                    </form>
                    <div id="horizontal-clear"></div>
                </div>

                <div id="edit-item">
                    <h6>Edit Item</h6>
                    <div id="horizontal-clear"></div>
                    <form id="edit-item-form">
                        <input type="hidden" name="endpoint" value="edit-item">                        
                        <input type="hidden" name="item-pk" value="">
                        <p>Item Name</p><input type="text" name="item-name"><br>
                        <p>Description</p><input type="text" name="item-desc"><br>                    
                        <p>Point Value</p>
                        <select name="point-value">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                        </select><br>
                        <p>Allergen Information</p><input type="text" id="allergen-info" name="allergen-info" value="Contains: "><br>
                        <p>Special Diet</p>
                        <select name="item-special-diet" value="">
                            <option selected value="none">None</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                            <option value="gluten free">Gluten Free</option>                            
                        </select><br>
                        <input id="submit-button" type="button" onclick="return submitEditItemForm()" value="Update Item">
                        <input id="submit-button" type="button" onclick="return cancelEdit('item')" value="Cancel">
                    </form>
                    <div id="horizontal-clear"></div>
                </div>

                <div id="add-location">
                    <h6>Add A Location</h6>
                    <div id="horizontal-clear"></div>
                    <form id="add-location-form">
                        <input type="hidden" name="endpoint" value="add-location">
                        <p>Location Name</p><input type="text" name="location-name"><br>
                        <p>Location Hours</p><input type="time" id="location-open-time" value="07:30:00" name="location-open-time">
                        to<input type="time" id="location-close-time" value="14:30:00" name="location-close-time"><br>                    
                        <p>Additional Information</p><input type="text" name="location-info"><br>
                        <input id="submit-button" type="button" onclick="return submitAddLocationForm()" value="Add Location">
                    </form>
                    <div id="horizontal-clear"></div>                    
                </div>             
            </div>
            <div id="dialog" title="Select Item(s)">
            	<div id="location-items-list">
            		
            	</div>
            </div>
            <div id="dialog-confirm" title="Confirm...">
            
            </div>
        </div>
    </body>
    <?php
        if($_GET["mode"] == "locations"){
    ?>
        <script>
            changeTab('Location');
        </script>
    <?php
        }
    ?>
    
    <script>
        $(document).ready(function() {

            $(document).on("click", ".item-display", function(event) {
                $(this).parent().children(".item-info").slideToggle("100");
                $(this).toggleClass("dark-background");
                return false;
            });

            $(document).on("click", ".location-display", function(event) {
                $(this).parent().children(".location-info").slideToggle("100");
                $(this).toggleClass("dark-background");
                return false;
            });

            $(document).on("click", ".edit-pencil-item", function(event) {
                //Use helper function to get the id of the surrounding div then pass it to the function
                var itemID = getElementID($(this), 10, "item-key-");
                jsEditItemTab(itemID);
                return false;
            });

            $(document).on("click", ".edit-pencil-location", function(event) {
                //Use helper function to get the id of the surrounding div then pass it to the function
                var locationID = getElementID($(this), 10, "location-key-");
                jsEditLocation(locationID);
                return false;
            });

            $(document).on("click", ".delete-button-item", function(event) {
                //Use helper function to get the id of the surrounding div then pass it to the function
                var itemID = getElementID($(this), 10, "item-key-");
                $("#dialog-confirm").append("<p>Are you sure you would like to delete this item?</p>");

                $( "#dialog-confirm" ).dialog({
                  resizable: false,
                  height:230,
                  modal: true,
                  buttons: {
                    "Delete": function() {                        
                        $( this ).dialog( "close" );
                        $("#dialog-confirm").empty();
                        jsDeleteItem(itemID);
                        return false;
                    },
                    Cancel: function() {
                      $( this ).dialog( "close" );
                      $("#dialog-confirm").empty();
                      return false;
                    }
                  }
                });
                return false;
            });

            $(document).on("click", ".delete-button-location", function(event) {
                //Use helper function to get the id of the surrounding div then pass it to the function
                var locationID = getElementID($(this), 10, "location-key-");
                $("#dialog-confirm").append("<p>Are you sure you would like to delete this location?</p>");

                $( "#dialog-confirm" ).dialog({
                  resizable: false,
                  height:230,
                  modal: true,
                  buttons: {
                    "Delete": function() {                        
                        $( this ).dialog( "close" );
                        $("#dialog-confirm").empty();
                        jsDeleteLocation(locationID);
                        return false;
                    },
                    Cancel: function() {
                      $( this ).dialog( "close" );
                      $("#dialog-confirm").empty();
                      return false;
                    }
                  }
                });
                return false;
            });

            $(document).on("click", ".delete-button-item-location", function(event) {
                //Use helper function to get the id of the surrounding div then pass it to the function
                var itemID = getElementID($(this), 10, "item-key-");
                var locationID = getElementID($(this), 10, "location-key-");

                $("#dialog-confirm").append("<p>Are you sure you would like to unlink this item from this location?</p>");

                $( "#dialog-confirm" ).dialog({
                  resizable: false,
                  height:230,
                  modal: true,
                  buttons: {
                    "Delete": function() {                        
                        $( this ).dialog( "close" );
                        $("#dialog-confirm").empty();
                        jsDeleteLocationItem(locationID, itemID);
                        return false;
                    },
                    Cancel: function() {
                      $( this ).dialog( "close" );
                      $("#dialog-confirm").empty();
                      return false;
                    }
                  }
                });
                return false;
            });

            $(document).on("click", ".add-item-button", function(event) {
                //Use helper function to get the id of the surrounding div then pass it to the function
                var locationID = getElementID($(this), 10, "location-key-");
                createDialogItems(locationID);
                //Open the dialog
                $( "#dialog" ).dialog({
				    modal: true,
				    draggable: false,
				    resizable: false,
				    show: 'blind',
				    hide: 'blind',
				    width: 800,
				    dialogClass: 'ui-dialog-osx',
				    buttons: {
				        "Add Item(s)": function() {
				        	addLocationItems(locationID);
				            $(this).dialog("close");
							selectedItems = [];
				        }
				    },
				    close: function(){
				    	$("#dialog #location-items-list").empty();
				    	selectedItems = [];
				    }
                });

                return false;
            });

            $(document).on("click", "#dialog #location-items-list .item .item-display", function(event) {
            	$("this").toggleClass("dark-background");
            	var itemID = getElementID($(this), 10, "item-key-");
            	if($.inArray(itemID, selectedItems) !== -1){
            		selectedItems.remove(itemID);
            	} else {
            		selectedItems.push(itemID);
            	}            	
            });

            //List grab initial lists of items and locations
            jsListItems("admin");
            jsListLocations();
        });
    </script>
    
</html>

