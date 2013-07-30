<html>
<br><br><br><br>;

<h1>VirtualPULSE</h1>

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
	// Set idf Information 
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
	//include 'SetIDF.php';
	
	//echo 'set ???';
	//Running simulation
	//echo $VP->runSimulation();
	//$VP = $_POST["$VP"];
	//Output Result in GRAPHS 
	//$VP->testData();
	//$VP->displaySummary();
	//VP->displayElectricity();
	//$VP->displayNaturalGas();
	//echo '<br>####################### End Testing #############<br>';
	
	
	echo '<pre>';
	
	//CREATE NEW IDF FILE and RUN ENERGYPLUS 
	
	//echo "<p>EnergyPlus Terminal Output...<p/>";
	//ini_set('max_execution_time', 120);        //120 seconds = 2 minutes

	
	echo '</pre>';
	
	//////////////////////////// HTML Submit Form For Query Result ////////////////////////////////////////
	
	echo '<form action="/RESULT/" name="bform" method="post" onsubmit="return validateform()">';
	
	echo 'Model name: <input type="text" name="modelName" value="'.$modelName.'"><br>';
	echo '<p>Query: <select name="queryType">
		  <option value="Summary"> Summary </option>
		  <option value="Natural_Gas"> Natural_Gas </option>
		  <option value="Electricity"> Electricity </option>
		  </select>
		  </p>';
	echo '<input type="submit" value="GO RESULT" />';
	echo '</form>';
	
	
	/////////////////////////////////////////////////////////////////////////////////

	// CLOSE CONNECTION TO DATABASE
	mysql_close($con);
	
	echo "<br/>";

	//DISPLAY SIMULATION RESULTS (ENERGYPLUS OUTPUT)
	//echo "<a href='./result/' target='_blank'>Simulation Results</a> | ";

    //$resultTablePath = "./Buildings/ENERGYPLUS/".$modelName.".idf/EnergyPlus/eplustbl.htm";
    //echo "<a href='".$resultTablePath."' target='_blank'>Results Table</a>";

    echo "<br/>";

?>

</html>
