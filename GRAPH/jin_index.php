<html land="en">
<head>
    <meta charset="utf-8"/>
	<title> RMT </title>
	
	<!-- JQuery -->
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="./amcharts.js" type="text/javascript"></script>
    
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	
    <?php
        require 'VirtualPULSE.php';
        require 'database_test.php';
        
        $VP = new VirtualPULSE();
       
	    $VP->setModelName($_POST["search"]);
    ?>
    
    
	<script type="text/javascript">
        $(document).ready(function(){
            $(".resizable").resizable({
                containment: "parent"
            });
        });
		
		$(function() {
			$( ".sortable" ).sortable();
			$( ".sortable" ).disableSelection();
		});

		$(function() {
			$( ".draggable" ).draggable( {containment: "parent", stack: ".draggable" } );
		});
	
		$(function() {
			$( "#menu" ).menu();
		});
		
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
</head>



<style>
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

#header {
	position: absolute;
	top: 0;
	left: 0;
	background-color: #4169E1;
	padding: 10px;
	border-style: groove;
	border-color: #D3D3D3;
	
	color: white;
	height: 80px;
	width: 100%;
	min-width: 200px;
    max-width: 1280px;
}

#main_frame {
	position: absolute;
	top: 105px;
    left: 0px;
	height: 800px;
	width: 100%;
	
	min-width: 25%;
	min-height: 25%;
	max-width: 1280px;
	max-height: 800px;
}

#profile_panel {
	position: absolute;
	float: left;
	background-color: #D3D3D3;
	border-style: groove;
	border-color: #C0C0C0;
	padding: 10px;
	height: 97.5%;
	width: 280px;
}

#result_panel {
	position: absolute;
	margin-left: 305px;
	height: 100%;
    width: 100%;
	
	min-width: 50%;
	min-height: 50%;
	max-height: 800px;
    max-width: 998px;

}

#input_panel {
	position: absolute;
	left: 305px;
	height: 100%;
	width: 77.5%;
	
	background-color: #FFF8DC;
    border-style: solid;
	border-color: #D3D3D3;
	color: black;
	
	min-width: 50%;
	min-height: 50%;
	max-height: 800px;
	display: none;
}

#left_up_panel {
	position: absolute;
	border-style: solid;
	border-color: #D3D3D3;
    color: black;
	background-color: #FFF8DC;
	
	height: 50%;
	width: 50%;
	min-width: 25%;
	min-height: 25%;
	max-height: 800px;
}

#right_up_panel {
	position: absolute;
	top: 0;
	left: 50%;
    border-style: solid;
	border-color: #D3D3D3;

	color: black;
	float: right;
	background-color: #FFF8DC;
	height: 50%;
	width: 50%;
	min-width: 25%;
	min-height: 25%;
	max-height: 800px;
}

#left_bottom_panel {
	position: absolute;
	top: 50%;
	left: 0%;
	background-color: #FFF8DC;
	border-style: solid;
	border-color: #D3D3D3;

	color: black;
	height: 50%;
	width: 50%;
	min-width: 25%;
	min-height: 25%;
	max-height: 800px;
}

#right_bottom_panel {
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
}

button {
	opacity: 0.8;
	float: right;
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

</style>

<script>

	function fullScreen(selectedScreen) {
		var screen0 = document.getElementById(selectedScreen);
		
		// hide all screens
		//hideScreen("left_up_panel");
		//hideScreen("right_up_panel");
		//hideScreen("left_bottom_panel");
		//hideScreen("right_bottom_panel");
		
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
	

</script>

<body>
<div id="header">
	<font size=1.5em> RMT </font>
	<button style="float: left;" onclick="restoreAllScreens()"> RESET </button>
	<button style="float: left;" onclick="showSubmitForm()"> ENTER SUBMIT FORM </button><br><br>
	<button style="float: left;" onclick="showResultPanel()"> QUERY SIMULATION RESULT </button>
</div>

<div id="main_frame" >
	<div id="profile_panel" class="none">
		<h2> Profile </h2><hr>
		
		<div>
			<form action="jin_index.php" name="searchForm" method="post" >
				<input type="text" size="28" value="JinAnTestBuilding168" name="search">
				<input type="submit" value="Search">
			</form>
		</div>

		<div id="accordion">
			<div class="group">
				<h3>My Building Models</h3>
				
                <div>          
                    <?php
                        listBuildingModel();
                    ?>
				</div>
			</div>
			
             <div class="group">
        		<h3>Shared Building Models</h3>
				<div>
				</div>
			</div>
            
			<div class="group">
				<h3>Building Data</h3>
				<div>
				</div>
			</div>
			
			<div class="group">
				<h3>Weather Data</h3>
				<div>
				</div>
			</div>
            
            <div class="group">
				<h3>Setting</h3>
				<div>
				</div>
			</div>
           
		</div>
	</div>

	<div id="input_panel" >
		<div id="basic_form" >
			<div class="sub_header">
					<button onclick="hideScreen('input_panel')" > X </button>
					<b> Basic Form </b>
			</div>
		</div>
      
        <iframe width="100%" height="95%" scrolling="yes" src="inputForm.php">
        </iframe>
       
	</div>
	
	<div id="result_panel" >
		<div id="left_up_panel" class="draggable resizable panel" >
			<div class="sub_header">
				<button onclick="hideScreen('left_up_panel')" > X </button>
				<button onclick="fullScreen('left_up_panel')" > Full Screen </button>
				<b> Information of Building </b>
			</div>
			
			<div style="height: auto; width: 100%">
                
			</div>
		</div>
		
		<div id="right_up_panel" class="draggable resizable panel">
			<div class="sub_header">
				<button onclick="hideScreen('right_up_panel')" > X </button>
				<button onclick="fullScreen('right_up_panel')" > Full Screen </button>
				<b> End Use Electricity </b>
			</div>
            <div>
                <?php
                    $VP->displayElectricity();
                ?>
            </div>
		</div>

		<div id="left_bottom_panel" class="draggable resizable panel" >
			<div class="sub_header">
				<button onclick="hideScreen('left_bottom_panel')" > X </button>
				<button onclick="fullScreen('left_bottom_panel')" > Full Screen </button>
				<b> Monthly Cooling Comparison </b>
			</div>
            
            <div>
                <?php
                    $VP->displayZoneMonthlyComparision(2,3);
                ?>
            
            </div>
            
		</div>
		
		<div id="right_bottom_panel" class="draggable resizable panel">
			<div class="sub_header">
				<button onclick="hideScreen('right_bottom_panel')" > X </button>
				<button onclick="fullScreen('right_bottom_panel')" > Full Screen </button>
				<b> Monthly Cooling Report</b>
            </div>
            
            <div>
                <?php
                    $VP->displayMonthlyData(3);
                ?>
            </div>
                
                
			
		</div> 
	</div>
</div>
<body>
</html>