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
				<?php
					$location = array(
						"PB" => "Post Breakfast",
						"PL" => "Post Lunch",
						"SB" => "Seymour Breakfast",
						"SL" => "Seymour Lunch"
					);
					$locValue = "";
					foreach ($location as $key => $value) {	
					$locValue = $value;	
					if (isset($_GET['location']) && $_GET['location'] == $key) {							
							echo "<option value='$key' selected> $value </option>";	
												
						} else {
							echo "<option value='$key'> $value </option>";
						}
					}
				?>
				<select name="location">
                <div id="items-list">
                     <h5>Items</h5>
                    <?php
					echo "locValue=$locValue<br>";
                    $result = getItemsFromLocation($locValue);
					//echo "key $key value $value locValue $locValue <br> result is -$result-";
                    if($result == false){		
                        die("No items found.");
                    }          
                    $count = 0;
                    //Loop through all results
                    while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="item">
                        <div class="item-display">
                            <p id="item-name"><?php echo $row["item_name"]; ?></p>  
                            <p id="item-points"><?php echo $row["item_point_value"]; ?></p>                       
						</div>
						

                        <div class="item-info">
                            <p><?php echo $row["item_desc"]; ?></p><br>
                            <p id="allergen-info"><?php echo $row["item_allergen_info"]; ?></p><br>
                        </div>
                    </div>
                <?php
                    }
                    $count = $count + 1;                        
                ?>
                </div>
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
            $(document).on("click", ".item-display", function(event) {
                $(this).parent().children(".item-info").slideToggle("100");
                return false;
            });

            //This function populates the item-list div with items
            jsListItems("student");
        });         
    </script>
    
</html>