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
                  <li id="menu-button-logout"><a href="login.php">Logout</a></li>
                </ul>
            </div>

            <div id="column-left">
			<div id="horizontal-clear"></div>
                
			    <p>Locations</p>
				<select name="location">
					<option value="Post Breakfast">Post Breakfast</option>
					<option value="Post Lunch">Post Lunch</option>
					<option value="Seymour Breakfast">Seymour Breakfast</option>
					<option value="Seymour Lunch">Seymour Lunch</option>
				</select>
               
                <div id="items-list">
                    <h5>Items</h5>
                    <div id="loaded-items"></div>
                </div>
            </div>

            <div id="clear-vertical"></div>

            <div id="column-right">
                <div id="add-item">
                    <h6>Shopping Cart</h6>
                    <div id="horizontal-clear"></div>
                    <form action="execute.php" method="post">
                    <input type="hidden" name="mode" value="add-item">
                    </form>
                    <div id="horizontal-clear"></div>
                </div>           
            </div>
        </div>

    </body>

    <script>
		$(document).ready(function() {
		
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
			
			$(document).on("click", ".add-item-cart-button", function(event) {
                //Use helper function to get the id of the surrounding div then pass it to the function
                var itemID = getElementID($(this), 10, "item-key-");
                jsEditItem(itemID);
				//Where the itemID needs to be sent to the order database to be sent to the shopping cart
				window.alert(itemID);
                return false;
            });
			
            $(document).on("click", ".item-display", function(event) {
                $(this).parent().children(".item-info").slideToggle("100");
                return false;
            });
			
			var locationName = "";
			$( "select" ).change(function () {
				$("#items-list #loaded-items").empty();
				var str = "";
				$( "select option:selected" ).each(function() {
				  str += $( this ).text() + " ";
				});
				locationName = str;
				
				getItemsFromLocation(locationName);
			});

            //This function populates the item-list div with items
            //jsListItems("student");
        });         
    </script>
    
</html>