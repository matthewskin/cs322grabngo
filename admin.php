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
                return false;
            });

            $(document).on("click", ".location-display", function(event) {
                $(this).parent().children(".location-info").slideToggle("100");
                return false;
            });

            $(document).on("click", ".edit-pencil", function(event) {
            	jsEditItem($(this).parent().parent().attr("id"));
            	return false;
            });
            //List grab initial lists of items and locations
            jsListItems();
            jsListLocations();
        });
    </script>
    
</html>

