<html>
	<head>
		<title>Grab N' Go Online</title>
		<link rel="stylesheet" href="printStyles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="205228710307-4b0jdecq96lg14643j1ebho8jv6k6cm1.apps.googleusercontent.com">
        <script>
        	var cartInfo = window.opener.submitOrderVariables;
        </script>
	</head>
	<body>
		<div id='print-page'>
			<h1>Grab N' Go Online</h1>
			<div id="cart-info">
				
			</div>
			<div id='horizontal-clear'></div>
			<div id="cart-items">
				<div id='cart-item'>
					<div id='item-name'><p><h5>Item Name</h5></p></div><div id='item-count'><p><h5>Item Count</h5></p></div><div id='item-point-value'><p><h5>Point Value</h5></p></div>
        		</div>
			</div>
		</div>
    </body>
    
    <script>
    	var currentTime = new Date();
    	var locationName = cartInfo["locationName"];
    	var pointsUsed = cartInfo["pointsUsed"];
    	var pointsMax = cartInfo["pointsMax"];
    	var pointsRemaining = cartInfo["pointsRemaining"];
    	var swipesUsed = cartInfo["swipesUsed"];

    	var cartInfoDiv = "<div id='location-name'><h4>" + locationName + "</h4></div><div id='points-info'><p>" + pointsUsed + "/" + pointsMax + " Pt(s) Used -- " + swipesUsed + " Swipe(s)</p></div>"; 

    	$("#cart-info").append(cartInfoDiv);

        $(document).ready(function() {
        	jQuery.each(cartInfo["cartItems"], function(){   
        		var printItemDiv = "<div id='cart-item'><div id='item-name'><p>" + this.item_name + "</p></div><div id='item-count'><p> x " + this.count + 
        		"</p></div><div id='item-point-value'><p>" + this.item_point_value + 
        		" Pt(s)</p></div><div id='item-description'><p><i>" + this.item_desc + "</i></p></div></div>";

        		$("#cart-items").append(printItemDiv);
        	});
        });
    </script>    
</html>

