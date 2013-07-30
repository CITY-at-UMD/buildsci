<html>
<head>
<title>
<?php echo $_GET['modelName'].': '. $_GET['queryType'] ?>
</title>
<script src="js/amcharts.js" type="text/javascript"></script>
</head>

<body>
<?php
	require 'VirtualPULSE.php';
	//echo $_POST[idfName].'<br>';
	$requestType = $_GET['queryType'];
    
	//$requestType = 'Summary';
	$VP = new VirtualPULSE();
	$VP->setModelName($_GET['modelName']);
	//$VP->setModelName('Hotwire23');
    
    switch($requestType) {
    	case "Summary":
			$VP->displaySummary();
			$VP->displayNaturalGas();
			$VP->displayElectricity();
			break;
        case "Monthly_Data":
                    
            if($_GET['selected_zone_0'] == NULL) { $VP->displayMonthlyData(1); }
            else{ $VP->displayMonthlyData($_GET['selected_zone_0']);}
            
            // compare zone 1 and zone 2 by default else compare user's prefered zones
            if($_GET['selected_zone_1'] == NULL || $_GET['selected_zone_2'] == NULL) {$VP->displayZoneMonthlyComparision(1,2,1,2);}
            else $VP->displayZoneMonthlyComparision($_GET['selected_zone_1'],$_GET['selected_zone_2'],$_GET['selected_zone_1'],$_GET['selected_zone_2']);
            break;
		default:
			echo "<br>Your request are only summary, natural gas or electricity.<br>";
	}
?>
</body>

</html>