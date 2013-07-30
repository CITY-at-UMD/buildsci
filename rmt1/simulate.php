<html>
<br><br><br><br>;

<h1>RMT 1</h1>

<hr />
<p>SIMULATION STATUS</p>

<?php
	//CONNECT TO DATABASE
	require 'connection.php';
	require 'VirtualPULSE.php';
	echo '<pre>';

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
	
	//echo '####################### Testing #################<br>';
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


$time_start = microtime(true); //place this before any script you want to calculate time
	//Running simulation
	echo $VP->runSimulation();
$time_end = microtime(true);

    // CLOSE CONNECTION TO DATABASE
	mysql_close($con);
    
	//////////////////////////// HTML Code Submit to result.php ////////////////////////////////////////
	
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
	
	

	
	echo "<br/>";
	
	// RESULT IN HTML TABLE 
    $resultTablePath = "./Buildings/ENERGYPLUS/".$modelName.".idf/EnergyPlus/eplustbl.htm";
	echo $resultTablePath.'<br>';
    echo "<a href='".$resultTablePath."' target='_blank'>Results Table</a>";

	echo "<br/>";
    
	
    $execution_time = ($time_end - $time_start)/60; //dividing with 60 will give the execution time in minutes other wise seconds
    echo '<b>Total Execution Time:</b> '.$execution_time.' Mins'; //execution time of the script

?>

</html>
