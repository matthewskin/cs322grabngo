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
			  <li id="menu-button-logout"><a href="login.php">Logout</a></li>
			</ul>
		</div>

		<div id="column-left">
			<div id="horizontal-clear"></div>
		
			<p>Locations</p>
			<select name="location">
				<option value=""></option>
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
			<div id="horizontal-clear"></div>
		
			<div id="cart-items-list">
			<center><input type="button" id="rules" onclick="damn()" value="Grab n Go rules" > </center>
				<h6>Shopping Cart</h6>
				<div>Points / Swipe: <span id="points-per">X</span><span style="float: right">Max # Of Swipes: 4</span></div>
				<div id="horizontal-clear"></div>
				<br />
				
				<div>Points Remaining: <span id="points-remain">X</span><span id="swipes-used" style="float: right">X</span><span style="float: right">Swipe #</span></div>
				<div id="horizontal-clear"></div>
				<br />
				
				<div id="cart-loaded-items"></div>
				
				<div id="dialog" title="Submit Order" style="display: none">
 					<p>Are you sure you would like to submit this order?</p>
				</div>
				<button type="button" id="submit-order">Submit Order</button>
			</div>      
			
			<div id="horizontal-clear"></div>
			
		</div>
	</body>
	
	<script>
		function damn(){
        		window.open('http://localhost:8888/cs322grabngo/rules.png');
        	} 
	</script>

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
            
            function damn(){
        	window.open('http://localhost:8888/cs322grabngo/rules.png');
        }       
			
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
            
            // Initially sets shopping cart information
            document.getElementById("points-per").innerHTML = pointsMax;
            document.getElementById("points-remaining").innerHTML = pointsRemain;
            document.getElementById("swipes-used").innerHTML = swipesUsed;
     
        });         
    </script>
</html>