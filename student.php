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