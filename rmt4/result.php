<html>
    
<script src="./amcharts.js" type="text/javascript"></script>

<br><br><br><br>

<h1>RMT 3</h1>

<hr />
<p>RESULT STATUS</p>

<?php
	require 'VirtualPULSE.php';
	
	echo '<br><br><br><br>';

	echo '<form action="result.php" name="bform" method="post" onsubmit="return validateform()">';
	
	echo 'Model Name: <input type="text" name="modelName" value="'.$_POST[modelName].'"><br>';
	echo '<p>Query: <select name="queryType">
		  <option value="Summary"> Summary </option>
		  <option value="Natural_Gas"> Natural_Gas </option>
		  <option value="Electricity"> Electricity </option>
          <option value="Monthly_Data"> Monthly_Data </option>
          <option value="Zone_Comparison"> Zone_Comparison </option>
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
        case "Monthly_Data":
            $VP->displayMonthlyData(5);
            break;
        case "Zone_Comparison":
            $VP->displayZoneMonthlyComparision(4,5);
            break;
		default:
			echo "<br>Your request are only summary, natural gas or electricity.<br>";
	}
	
	// RESULT IN HTML TABLE 
    $resultTablePath = "./Buildings/Output/".$_POST[modelName]."Table.html";
    
	echo 'Query Model: '.$_POST[modelName].'<br>';
    echo "<a href='".$resultTablePath."' target='_blank'>Results Table</a>";
?>

</html>