<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>
<br /><br /><br />
<h1>RMT 2</h1>
<hr />
<p>SIMULATION STATUS</p>

<!-- put this at the top of the page --> 
<?php 
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $starttime = $mtime; 
;?> 

<!-- put other code and html in here -->

<?php
	//CONNECT TO DATABASE
	require 'connection.php';
	require 'VirtualPULSE.php';
	echo '<pre>';

    //   $simulate_startTime = microtime(true);
	//ADD USER
	$userQuery = "INSERT INTO users (eMail) VALUES('$_POST[eMail]')";
	if (!mysql_query($userQuery,$con))
	{
		die('Error: ' . mysql_error());
	}

	$result = mysql_query("SELECT * FROM users WHERE eMail='$_POST[eMail]'");
	$row = mysql_fetch_array($result);
	$userID = $row['userID'];

	//ADD BUILDING
	$buildingQuery = "INSERT INTO buildings (buildingName, userSubmitted, locationID, functionID, roofMaterial, wallMaterial, floors, floorArea, windowPercent)
	VALUES ('$_POST[buildingName]', $userID, $_POST[locationID], $_POST[functionID], NULL, NULL, $_POST[floors], $_POST[floorArea], $_POST[windowPercent])";
	if (!mysql_query($buildingQuery,$con))
	{
		die('Error: ' . mysql_error());
	}
	
	//SELECT WEATHER FILE
	$result = mysql_query("SELECT * FROM locations WHERE locationID='$_POST[locationID]'");
	$row = mysql_fetch_array($result); 
	$city = $row['weatherFile'];
	
	// RENAME THE BUILDING NAME
	$result = mysql_query("SELECT * FROM buildings WHERE buildingName='$_POST[buildingName]'");
	$row = mysql_fetch_array($result); 
	$building = $row['buildingName'];
	$building = str_replace(' ', '_', $building);
	$modelName = $building.$userID;
	
	echo "<p>User Added ".$_POST[eMail]." [to database]<p/>";
	echo "<p>Building Added ".$building." [to database]<p/>";
	echo "<p>Weather File: ".$city.".epw [from database]<p/>";
	
	//////////////////////////////////// SET UP //////////////////////////////////////
	// Set Input Information For This Building Model
	$VP = new VirtualPULSE();
	$VP->setUser($_POST[eMail]);
	$VP->setBuilding($_POST[buildingName]);
	$VP->setCity($city);
	$VP->setArea($_POST[floorArea]);
	$VP->setNumFloors($_POST[floors]);	
	$VP->setBuildingType($_POST[functionID]);
	$VP->setRoof($_POST[roofMaterial]);
	$VP->setWall($_POST[wallMaterial]);
	$VP->setWWR($_POST[windowPercent]); 
	$VP->setUserID($userID);
	$VP->setModelName($modelName);
	
	// Create an idf
	$VP->runSimulation();

  ############ ORIGINAL SIMULATION CODE - COMMENTED OUT BY JIN AN #####################
    ////////////////////////////////// SIMULATION ///////////////////////////////////////
	//RUN ENERGYPLUS (SHELL CODE)
    echo "<p>EnergyPlus Terminal Output...<p/>";
	ini_set('max_execution_time', 120); //120 seconds = 2 minutes

	echo '<hr />';

	chdir('EnergyPlus-7-2-0');
	chdir('bin');

//########################################################################
    shell_exec('./runenergyplus ../../Buildings/' . $modelName. '.idf ../../Weather/' . $city . '.epw');
//########################################################################
 ############ END ORIGINAL SIMULATION CODE - COMMENTED OUT BY JIN AN #####################  	
	
	
//////////////////////////// HTML Code Submit to result.php ////////////////////////////////////////
	// OUT RESULT TO GRAPH
	echo '<form action="result.php" name="bform" method="post" onsubmit="return validateform()">';
	
	echo 'Model Name: <input type="text" name="modelName" value="'.$modelName.'"><br>';
	echo '<p>Query: <select name="queryType">
		  <option value="Summary"> Summary </option>
		  <option value="Natural_Gas"> Natural_Gas </option>
		  <option value="Electricity"> Electricity </option>
		  </select>
		  </p>';
	echo '<input type="submit" value="GO RESULT" />';
	echo '</form>';
	
	// CLOSE CONNECTION TO DATABASE
	mysql_close($con);
	
	echo "<br/>";

	// RESULT IN HTML TABLE 
    $resultTablePath = "./Buildings/Output/".$modelName."Table.html";
	echo $resultTablePath.'<br>';
    echo "<a href='".$resultTablePath."' target='_blank'>Results Table</a>";

    echo "<br/>";

?>

<!-- print the simulation time  -->
<?php 
   // total time result
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime);   
   
   echo "This page was created in ".$totaltime." seconds or ".($totaltime/60)." minutes<br>"; 
   echo "This energyplus was ran in ".$total_eptime." seconds or ".($total_eptime/60)." minutes<br>"; 
;?>

<div id="debug"></div>
<script language="javascript" type="text/javascript">
   $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: "energyPlusSim.php",
            success: function (data) {
                $('#debug').html(data);
            }
        });
   });
</script>
</body>


</html>
