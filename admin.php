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
                    <?php
                    $result = getItems();
                    if($result == false){
                        break;
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
                    <?php
                    $result = getLocations();
                    if($result == false){
                        break;
                    }          
                    $count = 0;
                    //Loop through all results
                    while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="location">
                        <div class="location-display">
                            <p id="location-name"><?php echo $row["location_name"]; ?></p>  
                            <input type="time" readonly="readonly" value="<?php echo $row["location_time_open"]; ?>"> to
                            <input type="time" readonly="readonly" value="<?php echo $row["location_time_closed"]; ?>">               
                        </div>

                        <div class="location-info">
                            <p><?php echo $row["location_info"]; ?></p><br>
                            
                            <form action="execute.php" method="post">
                                <input type="hidden" name="location-id" value="<?php echo $row["location_pk"]; ?>">
                                <input type="hidden" name="mode" value="delete-location">
                                <input type="submit" value="Delete Location">
                            </form>
                            <div id="items-list">
                            <?php 
                                $location_items = getLocationItems($row["location_pk"]);
                                if($location_items == false){
                                    ;
                                } else {
                                $inner_count = 0;
                                //Loop through all results
                                while ($inner_row = $location_items->fetch_assoc()){
                            ?>
                                <div id="location-item">
                                    <?php echo $inner_row["item_name"]; ?>
                                    <form action="execute.php" method="post">
                                        <input type="hidden" name="location-id" value="<?php echo $row["location_pk"]; ?>">
                                        <input type="hidden" name="item-id" value="<?php echo $row_inner["item_pk"]; ?>">
                                        <input type="hidden" name="mode" value="delete-location-item">
                                        <input type="submit" value="Delete Location">
                                    </form>
                                </div>
                            <?php
                                    }
                                }
                                $inner_count = $inner_count + 1;
                            ?>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                    $count = $count + 1;                        
                ?>
                </div>
            </div>

            <div id="clear-vertical"></div>

            <div id="column-right">
                <div id="add-item">
                    <h6>Add An Item</h6>
                    <div id="horizontal-clear"></div>
                    <form id="add-item-form" method="post">
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
                        <input id="submit-button" type="submit" value="Add Item">
                    </form>
                    <div id="horizontal-clear"></div>
                </div>

                <div id="add-location">
                    <h6>Add A Location</h6>
                    <div id="horizontal-clear"></div>
                    <form action="execute.php" method="post">
                    <input type="hidden" name="mode" value="add-location">
                    <p>Location Name</p><input type="text" name="location-name"><br>
                    <p>Location Hours</p><input type="time" id="location-open-time" value="07:30:00" name="location-open-time">
                    to<input type="time" id="location-close-time" value="14:30:00" name="location-close-time"><br>                    
                    <p>Additional Information</p><input type="text" name="location-info"><br>
                    <input id="submit-button" type="submit" value="Add Location">
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
            $(".item-display").click(function(event) {
                $(this).parent().children(".item-info").slideToggle("100");
                return false;
            });

            $(".location-display").click(function(event) {
                $(this).parent().children(".location-info").slideToggle("100");
                return false;
            });
            $("#add-item-form").on('submit', function() {
                jsAddItem($(this).serializeArray());
                return false;
            });
        });
    </script>
    
</html>

