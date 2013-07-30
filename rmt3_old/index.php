<html land="en">
<head>
<meta charset="utf-8"/>
<title> RMT 3 </title>
    
<!-- JQuery -->
<link rel="stylesheet" type="text/css" href="css/theme.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script src="js/amcharts.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>

<?php
    require 'VirtualPULSE.php';
    require 'database_test.php';
    include 'sql_functions.php';
    
?>

<script type="text/javascript">
    // resizable for sub panels
    $(document).ready(function(){
        $(".resizable").resizable({
            containment: "parent"
        });
    });
    
    // sortable for accordion
	$(function() {
		$( ".sortable" ).sortable();
		$( ".sortable" ).disableSelection();
	});

    // draggable for sub panels
	$(function() {
		$( ".draggable" ).draggable( {containment: "parent", stack: ".draggable" } );
	});

    // menu option
	$(function() {
		$( ".menu" ).menu(); 
	});
	
    // accordion
	$(function() { $( "#accordion" ).accordion({
			header: "> div > h3",
			heightStyle: "fill"
		}).sortable({
			axis: "y",
			handle: "h3",
			containment: "parent",
			stop: function( event, ui ) {
				// IE doesn't register the blur when sorting
				// so trigger focusout handlers to remove .ui-state-focus
				ui.item.children( "h3" ).triggerHandler( "focusout" );
			}
	});
});
</script>

<style>
.menu {
    border: none;
    width: 110%;
    padding: none;
    margin: none;
}

ul {
    list-style: none;
    padding: 0px;
	margin: 0px;
	border: 0px;
}

li {
	padding: 0px;
	margin: 0px;
	font-color: blue;
}

h2{
	text-align: center
}

.group { zoom: 1 }

.header {
    border: medium solid #3399ee;
	position: absolute;
	top: 0;
	left: 0;
	background-color: #3399ee;
    border-bottom: medium solid #eee;	
	color: white;
	width: 100%;
	min-width: 800px;
    min-height: 100px;
}

.main_frame {
	position: absolute;
    margin-top: 90px;
    margin-bottom: 0px;
    left: 0px;
	height: 95%;
	width: 100%;
	min-width: 680px;
	min-height: 800px;
	max-width: 1280px;
    border: medium solid #3399ee;
    border-top: none;
}

.profile_panel {
	position: absolute;
    border-right: medium solid #3399ee;    
	float: left;
	height: 100%;
	width: 350px;
}

#result_panel {
	position: absolute;
    margin-left: 350px;
	
	min-width: 50%;
	min-height: 50%;
	max-height: 800px;
    max-width: 998px;
}

#input_panel {
	position: absolute;
	left: 305px;
	background-color: white;
    border-style: solid;
	border-color: #D3D3D3;
	color: black;
	
	min-width: 50%;
	min-height: 50%;
	max-height: 800px;
	display: none;
}

.panel_type {
    position: absolute;
	top: 50%;
	left: 50%;
	background-color: #FFF8DC;
    border-style: solid;
	border-color: #D3D3D3;
	color: black;
	float: right;
	height: 50%;
	width: 50%;
	min-width: 25%;
	min-height: 25%;
	max-height: 800px;
    display: none;
}

.sub_header {
	border: 1px black solid;
	height: 25px;
	background-color: #4169E1; 
	color: white;
	padding: 2px;
	opacity: 0.9;
	cursor: move;
}


.myButton {
    -moz-box-shadow: 0px 10px 14px -7px #3e7327;
    -webkit-box-shadow: 0px 10px 14px -7px #3e7327;
    box-shadow: 0px 10px 14px -7px #3e7327;
    
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #77b55a), color-stop(1, #72b352));
    background:-moz-linear-gradient(top, #77b55a 5%, #72b352 100%);
    background:-webkit-linear-gradient(top, #77b55a 5%, #72b352 100%);
    background:-o-linear-gradient(top, #77b55a 5%, #72b352 100%);
    background:-ms-linear-gradient(top, #77b55a 5%, #72b352 100%);
    background:linear-gradient(to bottom, #77b55a 5%, #72b352 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#77b55a', endColorstr='#72b352',GradientType=0);
    
    background-color:#77b55a;
    
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;
    
    border:1px solid #4b8f29;
    
    display:inline-block;
    color:#ffffff;
    font-family:arial;
    font-size:13px;
    font-weight:bold;
    padding:6px 12px;
    text-decoration:none;
    
    text-shadow:0px 1px 0px #5b8a3c;
    
}

.myButton:hover {
    
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #72b352), color-stop(1, #77b55a));
    background:-moz-linear-gradient(top, #72b352 5%, #77b55a 100%);
    background:-webkit-linear-gradient(top, #72b352 5%, #77b55a 100%);
    background:-o-linear-gradient(top, #72b352 5%, #77b55a 100%);
    background:-ms-linear-gradient(top, #72b352 5%, #77b55a 100%);
    background:linear-gradient(to bottom, #72b352 5%, #77b55a 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#72b352', endColorstr='#77b55a',GradientType=0);
    
    background-color:#72b352;
}

.myButton:active {
    position:relative;
    top:1px;
}
</style>
</head>

<style>

</style>

<script>
function fullScreen(selectedScreen) {
	var screen0 = document.getElementById(selectedScreen);
	
	if(screen0.style.height == "100%" && screen0.style.width == "100%")
	{
		screen0.style.height = "50%";
		screen0.style.width = "50%";
		
	}else{
		// maxize the selected screen
		screen0.style.height="100%";
		screen0.style.width="100%";
		screen0.style.top = "0";
		screen0.style.left="0";
		screen0.style.display = "block";
	}
}

function restoreAllScreens() {
	var screen0 = document.getElementById("left_up_panel");
	var screen1 = document.getElementById("right_up_panel");
	var screen2 = document.getElementById("left_bottom_panel");
	var screen3 = document.getElementById("right_bottom_panel");
	
	screen0.style.height="50%";
	screen0.style.width="50%";
	screen0.style.top = "0";
	screen0.style.left= "0";
	
	screen1.style.height="50%";
	screen1.style.width="50%";
	screen1.style.top = "0";
	screen1.style.left= "50%";
	
	screen2.style.height="50%";
	screen2.style.width="50%";
	screen2.style.top = "50%";
	screen2.style.left= "0";
	
	screen3.style.height="50%";
	screen3.style.width="50%";
	screen3.style.top = "50%";
	screen3.style.left= "50%";
	
	screen0.style.display="block";
	screen1.style.display="block";
	screen2.style.display="block";
	screen3.style.display="block";
}

function restoreScreen(selectedScreen) {
	var screen0 = document.getElementById(selectedScreen);
	
	screen0.style.height="50%";
	screen0.style.width="50%";
	screen0.style.display="block";
}

function hideScreen(selectedScreen) {
	var screen0 = document.getElementById(selectedScreen);
	screen0.style.display = "none";
}

function showScreen(selectedScreen) {
	var screen0 = document.getElementById(selectedScreen);
	screen0.style.display = "block";
}

function showSubmitForm() {
	hideScreen("result_panel");
	showScreen("input_panel");
}

function showResultPanel() {
	hideScreen("input_panel");
	showScreen("result_panel");
}

function submitForm(modelName) {
    document.getElementById("search_text").value = modelName;
    document.getElementById("searchForm").submit();
}
</script>

<body>
<!-- header -->
<div class="header">
    <p style="position: absolute; font-size: 50px; "> RMT 3</p>
	<button class="myButton" style="float: right;" onclick="showResultPanel()"> RESULT </button>
    <button class="myButton" style="float: right;" onclick="showSubmitForm()"> BASELINE FORM </button>
</div>


<div class="main_frame" >
    <!-- Profile Panel -->
	<div class="profile_panel" >
		<h2> Profile </h2><hr>
		
		<div>
			<form action="index.php" id="searchForm" name="searchForm" method="post" >
				<input style="color: grey; margin: 10px 10px;" id="search_text" type="text" size="30" value="" placeholder="search a model" name="search" />
				<input type="submit" value="Search" />
			</form>
		</div>

		<div id="accordion" style="wdith: 90%; height: 500px;">
			<div class="group">
				<h3>All Building Models</h3>
				
                <div>          
                    <?php
                        listBuildingModel();
                    ?>
				</div>
			</div>
		</div>
	</div>

    <!-- input form panel is alternated with result panel -->
	<div id="input_panel" >
		<div id="basic_form" >
		</div>
      
        <iframe scrolling="yes" src="inputForm.php">
        </iframe>
	</div>
	
    <!-- result form panel is alternated with input panel -->
	<div id="result_panel" > 	
		<div style="overflow:scroll; ">
            <?php
                display_results($_POST['search']);
            ?>
		</div>
	</div>
</div>
</body>

</html>