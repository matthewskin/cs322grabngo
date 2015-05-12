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
			<!--<div id="horizontal-clear"></div>-->
                <form action="execute.php" method="post">
			    <p>Locations</p>
				<select name="location">
                    <option value="1">Post Breakfast</option>
                    <option value="2">Post Lunch</option>
                    <option value="3">Seymour Breakfast</option>
                    <option value="4">Seymour Lunch</option>
                </select><br>

                <div id="items-list">
                    <h5>Items</h5>
                    <div id="loaded-items"></div>
                </div>
            </div>

            <div id="clear-vertical"></div>

            <div id="column-right">
                <div id="add-item">
                	<input type="button" id="rules" onclick="damn()" value="Grab n Go rules">
                    <h6>Shopping Cart</h6>
                    <div id="horizontal-clear"></div>
                    <input type="hidden" name="mode" value="add-item">
                    </form>
                    <div id="horizontal-clear"></div>
                    	<div id="items-list">
                     	<h6>Items</h6>
                    	<?php
                    	$result = getItems();
                    	if($result == false){
                        	die("No items found.");
                    	}          
                    	$count = 0;
						// Change...
                    	//getting all items
                    	$totalpoints = 0;
                    	while ($row = $result->fetch_assoc()) {
                	?>
                    	<div class="item">
                        	<div class="item-display">
                            	<p id="item-name"><?php echo $row["item_name"] . " " . $row["item_point_value"]; ?></p>  
                            	<p id="allergen-info"><?php echo $row["item_allergen_info"]; ?></p>
                            	<div style="border-bottom:1px solid black"></div>
                            	<?php
                            	$totalpoints += $row["item_point_value"];
                            	?>
                            	<br>                  
                        	</div>
                    	</div>
                	<?php	
                    	}
                    	$count = $count + 1;                        
                	?>
                	</div>      
                </div>   
			<div id="add-item">
            
            Reminder: 18 points per swipe <br>
			<p>Swipes</p>
				<select name="Swipes">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="3">4</option>
                </select><br>
			<p> Total Points: <?php echo $totalpoints?> </p>				
			<br>
            <input type="submit" value="Submit Order">
            <input type="submit" value="Print Order">
            </form>
    </div>
</div>  
            </div>
        </div>

    </body>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".item-display", function(event) {
                $(this).parent().children(".item-info").slideToggle("100");
                return false;
            });
			
            //This function populates the item-list div with items
            jsListItems("student");
        });  
        function damn(){
        	window.open('http://localhost:8888/cs322grabngo/rules.png');
        }       
    </script>
    
</html>

