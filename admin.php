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
                  <li id="menu-button-logout"><a href="">Logout</a></li>
                </ul>
            </div>

            <div id="column-left">
                <div id="items-list">
                    <h5>Items</h5>
                    <?php
                    $result = getItems();
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
                        </div>

                        <div class="item-info">
                            <p><?php echo $row["item_desc"]; ?></p><br>
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
                    <h6>Add An Item</h6>

                    <form action="execute.php" method="post">
                    Item Name: <input type="text" name="item-name"><br>
                    Description: <input type="text" name="item-desc"><br>
                    <input type="hidden" name="mode" value="add-item">
                    <input type="submit" value="Add Item">
                    </form>

                </div>

                <div id="add-location">
                    <h6>Add A Location</h6>
                    
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

