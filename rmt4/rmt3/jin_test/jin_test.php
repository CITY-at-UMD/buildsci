<html>

<body>

<?php
    require 'VirtualPULSE.php';
	//echo $requestType;
	
	$VP = new VirtualPULSE();
	$VP->setModelName($_POST[search]);
?>

<style>
h2, h1 {
	text-align: center
}

#header {
	position: relative;
	top: 0;
	left: 0;
	
	border-style: groove;
	border-color: green;
	
	height: 100px;
	width: 1000px;
	
}

#main_frame {
	position: relative;
	height: 800px;
	width: 100px;
}

#profile_panel {
	position: relative;
	float: left;
	
	border-style: groove;
	border-color: green;
	
	height: 100%;
	width: 200px;
}

#result_panel {
	position: relative;
	left: 200px;
	height: 100%;
	width: 800px;
}

#left_up_panel {
	position: absolute;
	border-style: solid;

	height: 50%;
	width: 50%;
}

#right_up_panel {
	position: absolute;
	top: 0;
	left: 50%;
    border-style: solid;
	float: right;
	height: 50%;
	width: 50%;
}

#left_bottom_panel {
	position: absolute;
	top: 50%;
	
	
	border-style: solid;

	height: 50%;
	width: 50%;
}

#right_bottom_panel {
	position: absolute;
	top: 50%;
	left: 50%;
	
    border-style: solid;
	float: right;
	height: 50%;
	width: 50%;
}

#nav li{
	display: block;
	position: relative;
	
	padding: 8px 15px;
	text-decoration: none;
	font-weight: bold;
	color: #069;
	border-right: 1px solid #ccc;
}

button {
	opacity: 0.8;
	float: right;
}

</style>

<script>

	function fullScreen() {
		var screen0 = document.getElementById("left_up_panel");
		var screen1 = document.getElementById("right_up_panel");
		var screen2 = document.getElementById("left_bottom_panel");
		var screen3 = document.getElementById("right_bottom_panel");
		var A = document.getElementById("pie_chartdiv");
		
        screen0.style.height="100%";
		screen0.style.width="100%";
        A.style.height="100%";
        A.style.width="100%";
        
		screen1.style.display="none";
		screen2.style.display="none";
		screen3.style.display="none";
	}
	
	function restoreScreen() {
		var screen0 = document.getElementById("left_up_panel");
		var screen1 = document.getElementById("right_up_panel");
		var screen2 = document.getElementById("left_bottom_panel");
		var screen3 = document.getElementById("right_bottom_panel");
		
		screen0.style.height="50%";
		screen0.style.width="50%";
		
		screen1.style.display="block";
		screen2.style.display="block";
		screen3.style.display="block";
	}
    
    
</script>


<div id="header">
	<h1> RMT Test Version </h1>
</div>

<div id="main_frame">
	<div id="profile_panel">
		<h2> Profile </h2>
		<form action="jin_test.php" method="post">
			<input type="text" size="15" name="search">
			<input type="submit" value="Search">
		</form>
        
		<ul id="nav">
                <li><a href="#"> something here </a></li>
		</ul>
		
		
	</div>

	<div id="result_panel">
		<div id="left_up_panel">
			<button onclick="fullScreen()" > Full Screen </button>
			<button onclick="restoreScreen()" > Restore Screen </button>
		
            <?php  $VP->displayElectricity(); ?>
		
		</div>
		
		<div id="right_up_panel">
			<h2> End Use Electricity </h2>
            

		</div>

		<div id="left_bottom_panel">
			<h2> End Use Gas </h2>

		</div>
		
		<div id="right_bottom_panel">
			<h2> Monthly Cooling Report</h2>

		</div> 	
	</div>
    
</div>
</body>
</html>