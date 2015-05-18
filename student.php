<?php
    /*
    Matt Skinner
	Austen Lake
    */
    require_once("admin-utils.php");
	require_once("header.php");
?>

		<div id="menu">
			<ul>
			  <li><a id="menu-button-item" onclick="changeTab('Item'); return false;" href="">Items</a></li>
			  <li><a id="menu-button-rules" target="_blank" href="./rules.png">Rules</a></li>
			  <li id="menu-button-logout"><a href="login.php">Logout</a></li>
			</ul>
		</div>

		<div id="column-left">
			<div id="horizontal-clear"></div>
			<div id="items-list">
				<select id="select-location" name="location">
					<option value="" disabled selected>Select a Location</option>
					<?php
						$statement = "SELECT * from locations ORDER BY locations.location_name";
    					$result = executeQuery($statement);

    					while($row = $result->fetch_assoc()){
					?>
						<option value="<?php echo $row["location_pk"]; ?>"><?php echo $row["location_name"]; ?></option>
					<?php
						}
					?>
				</select>
				<h5>Items</h5>
				<div id="loaded-items"></div>
			</div>
		</div>

		<div id="clear-vertical"></div>

		<div id="column-right">
			<div id="horizontal-clear"></div>
		
			<div id="cart-items-list">			
				<h6>Shopping Cart</h6>
				<div>Points / Swipe: <span id="points-per">X</span><span style="float: right">Max # Of Swipes: 4</span></div>
				<div id="horizontal-clear"></div>
				<br />
				
				<div>Points Remaining: <span id="points-remain">X</span><span id="swipes-used" style="float: right">X</span><span style="float: right">Swipe #</span></div>
				<div id="horizontal-clear"></div>
				<br />
				
				<div id="cart-loaded-items"></div>
				
				
				<button type="button" id="submit-order">Submit Order</button>
			</div>      
			
			<div id="horizontal-clear"></div>
			
		</div>
		<div id="dialog" title="Submit Order" style="display: none">
			<p>Are you sure you would like to submit this order?</p>
		</div>
		<div id="dialog-confirm" title="Confirm...">
    
    	</div>
	</body>

    <script>
		$(document).ready(function() {
			$(document).on("click", "#submit-order", function(event) {
				$("#dialog").dialog({
					modal: true,
					draggable: true,
					resizable: false,
					show: 'blind',
					hide: 'blind',
					width: 400,
					buttons: {
						"Submit Order": function(){
							submitOrder();
							$(this).dialog("close");
						},
						"Go Back": function(){
							$(this).dialog("close");
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
			
			$(document).on("click", ".add-item-cart-button", function(event) {
                //Use helper function to get the id of the surrounding div then pass it to the function
                var itemID = getElementID($(this), 10, "item-key-");
                
				//Where the itemID needs to be sent to the order database to be sent to the shopping cart
				addItemToCart(itemID);
                return false;
            });
			
            $(document).on("click", ".item-display", function(event) {
                $(this).parent().children(".item-info").slideToggle("100");
                return false;
            });     
			
			var locationName = "";
			$( "select" ).change(function () {
				var location = $(this);

				if(jQuery.isEmptyObject(cartList) === false){
					$("#dialog-confirm").append("<p>All items in the cart will be lost...</p>");

	                $( "#dialog-confirm" ).dialog({
	                  resizable: false,
	                  width: 400,
	                  modal: true,
	                  buttons: {
	                    Confirm: function() {                        
	                        $( this ).dialog( "close" );
	                        $("#dialog-confirm").empty();
	                        
	                        cartList = {};
	                        $("#cart-loaded-items").empty();
	                        $("#items-list #loaded-items").empty();
							
							getItemsFromLocation(location.val());
							getLocation(location.val());
	                      
	                      	return false;
	                    },
	                    Cancel: function() {
	                      $( this ).dialog( "close" );
	                      $("#dialog-confirm").empty();
	                      location.val( studentSelectedLocation['location_pk'] );
	                      return false;
	                    }
	                  }
	                });
				} else {
					cartList = {};
					$("#items-list #loaded-items").empty();
					
					getItemsFromLocation(location.val());
					getLocation(location.val());
				}

			});

            //This function populates the item-list div with items
            //jsListItems("student");
            
            // Initially sets shopping cart information
            document.getElementById("points-per").innerHTML = pointsMax;
            // document.getElementById("points-remaining").innerHTML = pointsRemain;
            document.getElementById("swipes-used").innerHTML = swipesUsed;
        });         
    </script>
</html>