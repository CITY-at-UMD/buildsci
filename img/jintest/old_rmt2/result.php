<html>
<br><br><br><br>

<h1>VirtualPULSE</h1>

<hr />
<p>RESULT STATUS</p>

<?php
	require 'VirtualPULSE.php';
	
	echo '<br><br><br><br>';

	echo '<form action="result.php" name="bform" method="post" onsubmit="return validateform()">';
	
	echo 'Model name: <input type="text" name="modelName" value="'.$_POST[modelName].'"><br>';
	echo '<p>Query: <select name="queryType">
		  <option value="Summary"> Summary </option>
		  <option value="Natural_Gas"> Natural_Gas </option>
		  <option value="Electricity"> Electricity </option>
		  </select>
		  </p>';
	echo '<input type="submit" value="GO RESULT" />';
	echo '</form>';
	
	echo '<br><br><br><br>';

	//echo $_POST[idfName].'<br>';
	$requestType = $_POST[queryType];
	
	//echo $requestType;
	
	$VP = new VirtualPULSE();
	$VP->setModelName($_POST[modelName]);
	
	switch($requestType) {
		case "Summary":
			$VP->displaySummary();
			break;
		case "Natural_Gas":
			$VP->displayNaturalGas();
			break;
		case "Electricity":
			$VP->displayElectricity();
			break;
		default:
			echo "<br>Your request are only summary, natural gas or electricity.<br>";
	}
?>

</html>