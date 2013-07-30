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
	echo "<p>User Added [to database]<p/>";

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
	echo "<p>Building Added [to database]<p/>";
	
	//SELECT WEATHER FILE
	$result = mysql_query("SELECT * FROM locations WHERE locationID='$_POST[locationID]'");
	$row = mysql_fetch_array($result); 
	$city = $row['weatherFile'];
	echo "<p>Weather File: ".$city.".epw [from database]<p/>";
	
	// RENAME THE BUILDING NAME
	$result = mysql_query("SELECT * FROM buildings WHERE buildingName='$_POST[buildingName]'");
	$row = mysql_fetch_array($result); 
	$building = $row['buildingName'];
	$building = str_replace(' ', '_', $building);
	$idfName = $building.$userID;
	
	// Set idf Information 
	echo '<form action="simulate.php" name="bform" method="post" onsubmit="return validateform()">';
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
	$VP->setIdfName($idfName);
	echo'<input type="submit" value="SIMULATE" />
		</form>';
		
	$VP->testData();

	// CLOSE CONNECTION TO DATABASE
	//mysql_close($con);
	
	//DISPLAY SIMULATION RESULTS (ENERGYPLUS OUTPUT)
	//$simulation = './simulate.php';
	//echo "<a href='".$simulation."'>Go to Simulation</a>";

?>