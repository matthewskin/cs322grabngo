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
                    <?php
                    $result = getItems();
                    if($result == false){
                        die("No items found.");
                    }          
                    $count = 0;
					// Change...
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
                            <form action="execute.php" method="post">
                                <input type="hidden" name="item-id" value="<?php echo $row["item_pk"]; ?>">
                                <input type="hidden" name="mode" value="delete-item">
                                <input type="submit" value="Delete Item">
                            </form>
                        </div>
                    </div>
                <?php
                    }
                    $count = $count + 1;                        
                ?>
                </div>

                <div id="locations-list">
                    <h5>Locations</h5>
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
            $(".item-display").click(function(event) {
                $(this).parent().children(".item-info").slideToggle("100");
            });
        });         
    </script>
    
</html>