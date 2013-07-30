<?php 
	include 'ReportSQL.php';
	session_start();

	// Building Information
	$email = $_SESSION[eMail]; 
	$floorArea = $_SESSION[floorArea];
	$floors = $_SESSION[floors];	
	$functionType = $_SESSION[functionType];	
	$roofMaterial = $_SESSION[roofMaterial];
	$wallMaterial = $_SESSION[wallMaterial];	
	$windowPercent = $_SESSION[windowPercent];	
	$modelName = $_SESSION[modelName];	
	$sqlFile = "../Buildings/ENERGYPLUS/$modelName.idf/EnergyPlus/eplusout.sql";


	$tableName=$_GET['tableName'];
	$columnName=$_GET['columnName'];
	$rowName=$_GET['rowName'];
	$reportName=$_GET['reportName'];
	$reportForString=$_GET['reportForString']; 
	$unit = $_GET['unit'];
?>

<html>
<head>
<title> RMT 3: Result </title>
<LINK REL="SHORTCUT ICON" HREF="img/eebhub" />
<script src='js/amcharts.js' type="text/javascript"></script>
<script src='js/jquery1.10.1.js' type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/theme.css">
<link rel="stylesheet" type="text/css" href="css/result_style.css">
<script>

/*Monthly_End_Uses();
Total_Size_Energy();
Annual_End_Uses();*/

function Total_Size_Energy(data) {
	var chart;
	var chartData = data;

	AmCharts.ready(function() {
		// SERIAL CHART  
		chart = new AmCharts.AmSerialChart();
		chart.autoMarginOffset = 0;
		chart.marginRight = 0;
		chart.dataProvider = chartData;
		chart.categoryField = "catergory";
		chart.startDuration = 1;

		// AXES
		// category
		var categoryAxis = chart.categoryAxis;
		categoryAxis.gridPosition = "start";

		// value
		// in case you don't want to change default settings of value axis,
		// you don't need to create it, as one value axis is created automatically.
		// GRAPHS
		// column graph
		var graph1 = new AmCharts.AmGraph();
		graph1.type = "column";
		graph1.lineColor = "#5475d3";
		graph1.title = "Total Source Energy";
		graph1.valueField = "total_source_energy";
		graph1.lineAlpha = 0;
		graph1.fillAlphas = 0.85;
		chart.addGraph(graph1);

		// line
		var graph2 = new AmCharts.AmGraph();
		graph2.type = "line";
		graph2.title = "Total Site Energy";
		graph2.valueField = "total_site_energy";
		graph2.lineThickness = 2;
		graph2.bullet = "round";
		chart.addGraph(graph2);

		// LEGEND                
		var legend = new AmCharts.AmLegend();
		chart.addLegend(legend);

		// WRITE
		chart.write("chartdiv");
	});
}

function Monthly_End_Uses(data) {
	var chart;

	var chartData = data;


	AmCharts.ready(function() {
		// SERIAL CHART
		chart = new AmCharts.AmSerialChart();
		chart.dataProvider = chartData;
		chart.categoryField = "cooling_month";
		chart.marginRight = 0;
		chart.marginTop = 0;    
		chart.autoMarginOffset = 0;
		// the following two lines makes chart 3D
		chart.depth3D = 20;
		chart.angle = 30;

		// AXES
		// category
		var categoryAxis = chart.categoryAxis;
		categoryAxis.labelRotation = 90;
		categoryAxis.dashLength = 5;
		categoryAxis.gridPosition = "start";

		// value
		var valueAxis = new AmCharts.ValueAxis();
		valueAxis.title = "Energy Uses (GJ)";
		valueAxis.dashLength = 5;
		chart.addValueAxis(valueAxis);

		// GRAPH            
		var graph = new AmCharts.AmGraph();
		graph.valueField = "energy_use";
		graph.colorField = "color";
		graph.balloonText = "[[category]]: [[value]]";
		graph.type = "column";
		graph.lineAlpha = 0;
		graph.fillAlphas = 1;
		chart.addGraph(graph);

		// WRITE
		chart.write("chartdiv");
	});
}


function Annual_End_Uses(data, title) {
	var chart;

	var chartData = data;


	AmCharts.ready(function() {
		// PIE CHART
		chart = new AmCharts.AmPieChart();

		// title of the chart
		chart.addTitle(title, 20);

		chart.dataProvider = chartData;
		chart.titleField = "component";
		chart.valueField = "value";
		chart.sequencedAnimation = true;
		chart.startEffect = "elastic";
		chart.innerRadius = "30%";
		chart.startDuration = 2;
		chart.labelRadius = 15;

		// the following two lines makes the chart 3D
		chart.depth3D = 10;
		chart.angle = 15;

		// WRITE                                 
		chart.write("chartdiv");
	});
}
</script>

<style>
th {
	background: #222A0A;
	color: #fff;
}

td {
	background: #fff;
}

#summary-table td{
	background: #eee;
}
</style>

</head>

<body>
<header>
	<div style="margin-left: 50px; font-size: 18px;" >
		<h1> <a href="index.php"> RMT 3 </a> </h1>
		<h3><i>Simulated Result</i></h3>
	</div>
</header>

<main>
	<div id="pic-div">
		<img src="img/Buildings/office-building-icon.png" style="height: 90%; width: 90%; margin: 5% auto;" title="<?php echo $functionType;?>" alt="<?php echo $functionType;?>" > </img>
	</div> 

	<div id="nav-div">
		<ul id="nav-menu">
			<li> <a href="?t=summary"> Summary </a> </li>

			<li> <a href="?t=total_side_energy
							&reportName=AnnualBuildingUtilityPerformanceSummary
							&reportForString=%
							&tableName=Site and Source Energy
							&rowName=Total%
							&columnName=%
							&unit=%" > Total Site Energy </a> </li>

			<li> <a href="?t=annual_electricity
							&reportName=AnnualBuildingUtilityPerformanceSummary
							&reportForString=%
							&tableName=End Uses
							&rowName=%
							&columnName=Electricity
							&unit=GJ"> Annual Electricity </a> </li>

			<li> <a href="?t=annual_gas
							&reportName=AnnualBuildingUtilityPerformanceSummary
							&reportForString=%
							&tableName=End Uses
							&rowName=%
							&columnName=Natural Gas
							&unit=GJ"> Annual Natural Gas </a> </li>

			<li> <a href="?t=monthly_average
							&reportName=END USE ENERGY CONSUMPTION % MONTHLY
							&reportForString=Meter
							&rowName=Annual Sum or Average
							&columnName=%
							&unit=J"> Monthly Sum and Average</a> </li>

			<li> <a href="?t=monthly_lights
							&reportName=END USE ENERGY CONSUMPTION ELECTRICITY MONTHLY
							&reportForString=Meter
							&rowName=%
							&columnName=INTERIORLIGHTS:Electricity
							&unit=J"> Monthly Interior Lights</a> </li>

			<li> <a href="?t=monthly_equipment
							&reportName=END USE ENERGY CONSUMPTION ELECTRICITY MONTHLY
							&reportForString=Meter
							&rowName=%
							&columnName=INTERIOREQUIPMENT:Electricity
							&unit=J"> Monthly Interior Equipment</a> </li>

			<li> <a href="?t=monthly_cooling
							&reportName=END USE ENERGY CONSUMPTION ELECTRICITY MONTHLY
							&reportForString=Meter
							&rowName=%
							&columnName=COOLING:Electricity
							&unit=J"> Monthly Cooling</a> </li>

			<li> <a href="?t=monthly_fans
							&reportName=END USE ENERGY CONSUMPTION ELECTRICITY MONTHLY
							&reportForString=Meter
							&rowName=%
							&columnName=FANS:Electricity
							&unit=J"> Monthly Fans</a> </li>

			<li> <a href="?t=monthly_pumps
							&reportName=END USE ENERGY CONSUMPTION ELECTRICITY MONTHLY
							&reportForString=Meter
							&rowName=%
							&columnName=PUMPS:Electricity
							&unit=J"> Monthly Pumps</a> </li>
                            
            <li> <a href="?t=monthly_heating_gas
							&reportName=END USE ENERGY CONSUMPTION NATURAL GAS MONTHLY
							&reportForString=Meter
							&rowName=%
							&columnName=HEATING%
							&unit=J"> Monthly Heating Gas</a> </li>

		</ul>
	</div>

	<div id="result-div">
		<div id="content">
		<?php 
			switch($_GET['t'])
			{
				case "summary":
					echo "<h1 style='color:  #393B0B;'> Summary </h1>";
					display_results($modelName); 
					break;
/*********************************************************************************************************/
				case "total_side_energy":
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						//$v[$d[ColumnName]][$d[RowName]]=$d[Value];
						$v[]=$d[Value];
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}
					
					$data = '[{
								catergory: "Total_Energy [GJ]",
								total_site_energy: '.$v[0].',
								total_source_energy: '.$v[3].'},
							{
								catergory: "Energy Per Total Building Area \n [MJ/m^2]",
								total_site_energy: '.$v[1].',
								total_source_energy: '.$v[4].'},
							{
								catergory: "Energy Per Conditioned Building Area \n [MJ/m^2]",
								total_site_energy: '.$v[2].',
								total_source_energy: '.$v[5].'}]';

					echo "<h1 style='color:  #393B0B'> Total Site And Source Energy </h1>";
					//print_r($v);
					echo <<<END
					<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> - </th>
						<th> Total Energy [GJ] </th>
						<th>Energy Per Total Building Area [MJ/m^2] </th>
						<th> Energy Per Conditioned Building Area [MJ/m^2]</th>
					</tr>
					<tr>
						<th> Total Site Energy </th>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td>  $v[2] </td>
					</tr>
					<tr>
						<th> Total Source Energy </th>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td>  $v[5] </td>
					</tr>

					</table>		

END;
					echo '	<script> Total_Size_Energy('.$data.'); </script>
						 	<div id="chartdiv" style="margin: 10px auto; width: 90%; height: 300px;"></div>';
					break;
/*********************************************************************************************************/
				case "annual_electricity":
                    
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value];
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}

				$data = '[{
							component: "Heating",
							value: '.$v[0].'},
						{
							component: "Cooling",
							value: '.$v[1].'},
						{
							component: "Interior Lighting",
							value: '.$v[2].'},
						{
							component: "Exterior Lighting",
							value: '.$v[3].'},
						{
							component: "Interior Equipment",
							value: '.$v[4].'},
						{
							component: "Exterior Equipment",
							value: '.$v[5].'},
						{
							component: "Fans",
							value: '.$v[6].'},
						{
							component: "Pumps",
							value: '.$v[7].'},
						{
							component: "Heat Rejection",
							value: '.$v[8].'},
						{
							component: "Humidification",
							value: '.$v[9].'},
						{
							component: "Heat Recovery",
							value: '.$v[10].'},
						{
							component: "Water Systems",
							value: '.$v[11].'},
						{
							component: "Refrigeration",
							value: '.$v[12].'},
						{
							component: "Generators",
							value: '.$v[13].'}]';
					echo '	<script> Annual_End_Uses('.$data.', "End Uses Eletricity (GJ)"); </script>
						 	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 400px;"></div>';
                        
					echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> Heating </th>
						<th> Cooling </th>
						<th> Interior Lighting </th>
						<th> Exterior Lighting </th>
						<th> Interior Equipment </th>
						<th> Exterior Equipment </th>
						<th> Fans </th>
					</tr>
					<tr>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td> $v[2] </td>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td> $v[5]</td>
						<td> $v[6] </td>
					</tr>
					<tr>
						<th> Pumps </th>
						<th> Heat Rejection </th>
						<th> Humidification </th>
						<th> Heat Recovery </th>
						<th> Water Systems </th>
						<th> Refrigeration </th>
						<th> Generators </th>
					</tr>
					<tr>
						<td> $v[7] </td>
						<td> $v[8] </td>
						<td> $v[9] </td>
						<td> $v[10]</td>
						<td> $v[11]</td>
						<td> $v[12]</td>
						<td> $v[13]</td>
					</tr>
				</table>		
END;
					break;	

/*********************************************************************************************************/
				case "annual_gas":
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value];
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}

				$data = '[{
							component: "Heating",
							value: '.$v[0].'},
						{
							component: "Cooling",
							value: '.$v[1].'},
						{
							component: "Interior Lighting",
							value: '.$v[2].'},
						{
							component: "Exterior Lighting",
							value: '.$v[3].'},
						{
							component: "Interior Equipment",
							value: '.$v[4].'},
						{
							component: "Exterior Equipment",
							value: '.$v[5].'},
						{
							component: "Fans",
							value: '.$v[6].'},
						{
							component: "Pumps",
							value: '.$v[7].'},
						{
							component: "Heat Rejection",
							value: '.$v[8].'},
						{
							component: "Humidification",
							value: '.$v[9].'},
						{
							component: "Heat Recovery",
							value: '.$v[10].'},
						{
							component: "Water Systems",
							value: '.$v[11].'},
						{
							component: "Refrigeration",
							value: '.$v[12].'},
						{
							component: "Generators",
							value: '.$v[13].'}]';
					echo '	<script> Annual_End_Uses('.$data.', "End Uses Natural Gas (GJ)"); </script>
						 	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 400px;"></div>';

					echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> Heating </th>
						<th> Cooling </th>
						<th> Interior Lighting </th>
						<th> Exterior Lighting </th>
						<th> Interior Equipment </th>
						<th> Exterior Equipment </th>
						<th> Fans </th>
					</tr>
					<tr>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td> $v[2] </td>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td> $v[5]</td>
						<td> $v[6] </td>
					</tr>
					<tr>
						<th> Pumps </th>
						<th> Heat Rejection </th>
						<th> Humidification </th>
						<th> Heat Recovery </th>
						<th> Water Systems </th>
						<th> Refrigeration </th>
						<th> Generators </th>
					</tr>
					<tr>
						<td> $v[7] </td>
						<td> $v[8] </td>
						<td> $v[9] </td>
						<td> $v[10]</td>
						<td> $v[11]</td>
						<td> $v[12]</td>
						<td> $v[13]</td>
					</tr>
				</table>		
END;
					break;	
/*********************************************************************************************************/
				case "monthly_average":
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value]/1000000000;
                        $ave[]=number_format($d[Value]/1000000000/12, 4);
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}
				$data = '[{
							component: "Interior Lights",
							value: '.$v[0].'},
						{
							component: "Interior Equipment",
							value: '.$v[1].'},
						{
							component: "Cooling",
							value: '.$v[2].'},
						{
							component: "Fans",
							value: '.$v[3].'},
						{
							component: "Pumps",
							value: '.$v[4].'},
    					{
							component: "Heating Gas",
							value: '.$v[5].'}]';
                            
					echo '	<script> Annual_End_Uses('.$data.', "End Uses Monthly Sum and Average (GJ)"); </script>
						 	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 400px;"></div>';

					echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin-left: 5%;">
					<tr>
                        <th> - </th>
						<th> Interior Lights </th>
						<th> Interior Equipment </th>
						<th> Cooling </th>
						<th> Fans </th>
						<th> Pumps </th>
                        <th> Heating Gas </th>
					</tr>
					<tr>
                        <th> Annual </th>
						<td> $v[0]  </td>
						<td> $v[1]  </td>
						<td> $v[2]  </td>
						<td> $v[3]  </td>
						<td> $v[4]  </td>
                        <td> $v[5]  </td>
					</tr>
                    <tr>
                        <th> Average </th>
    					<td> $ave[0] </td>
						<td> $ave[1] </td>
						<td> $ave[2] </td>
						<td> $ave[3] </td>
						<td> $ave[4] </td>
                        <td> $ave[5] </td>
					</tr>
				</table>		
END;
					break;
/*********************************************************************************************************/
				case "monthly_lights":
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value]/1000000000;
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}

					$data = '[{
						cooling_month: "January",
						energy_use: '.$v[0].',
						color: "#FF0F00"},
					{
						cooling_month: "February",
						energy_use: '.$v[1].',
						color: "#FF6600"},
					{
						cooling_month: "March",
						energy_use: '.$v[2].',
						color: "#FF9E01"},
					{
						cooling_month: "Apirl",
						energy_use: '.$v[3].',
						color: "#FCD202"},
					{
						cooling_month: "May",
						energy_use: '.$v[4].',
						color: "#F8FF01"},
					{
						cooling_month: "June",
						energy_use: '.$v[5].',
						color: "#F8FF01"},
					{
						cooling_month: "July",
						energy_use: '.$v[6].',
						color: "#B0DE09"},
					{
						cooling_month: "August",
						energy_use: '.$v[7].',
						color: "#04D215"},
					{
						cooling_month: "September",
						energy_use: '.$v[8].',
						color: "#0D8ECF"},
					{
						cooling_month: "October",
						energy_use: '.$v[9].',
						color: "#0D52D1"},
					{
						cooling_month: "November",
						energy_use: '.$v[10].',
						color: "#2A0CD0"},
					{
						cooling_month: "December",
						energy_use: '.$v[11].',
						color: "#8A0CCF"}]';
                        
                echo "<h1 style='color:   #393B0B'> Monthly Interior Lights (GJ) </h1>";
                echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> January </th>
						<th> February </th>
						<th> March </th>
						<th> Apirl </th>
						<th> May </th>
						<th> June </th>
					</tr>
					<tr>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td> $v[2] </td>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td> $v[5]</td> 
					</tr>
					<tr>
						<th> July </th>
						<th> August </th>
						<th> September </th>
						<th> Octorber </th>
						<th> November </th>
						<th> December </th>
					</tr>
					<tr>
						<td> $v[6]</td>
						<td> $v[7]</td>
						<td> $v[8] </td>
						<td> $v[9]</td>
						<td> $v[10]</td>
						<td> $v[11]</td> 
					</tr>
				</table>		
END;
				
					echo '	<script> Monthly_End_Uses('.$data.'); </script>
						 	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 300px;"></div>';
			
					break;

/*********************************************************************************************************/
				case "monthly_equipment":
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value]/1000000000;
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}

					$data = '[{
						cooling_month: "January",
						energy_use: '.$v[0].',
						color: "#FF0F00"},
					{
						cooling_month: "February",
						energy_use: '.$v[1].',
						color: "#FF6600"},
					{
						cooling_month: "March",
						energy_use: '.$v[2].',
						color: "#FF9E01"},
					{
						cooling_month: "Apirl",
						energy_use: '.$v[3].',
						color: "#FCD202"},
					{
						cooling_month: "May",
						energy_use: '.$v[4].',
						color: "#F8FF01"},
					{
						cooling_month: "June",
						energy_use: '.$v[5].',
						color: "#F8FF01"},
					{
						cooling_month: "July",
						energy_use: '.$v[6].',
						color: "#B0DE09"},
					{
						cooling_month: "August",
						energy_use: '.$v[7].',
						color: "#04D215"},
					{
						cooling_month: "September",
						energy_use: '.$v[8].',
						color: "#0D8ECF"},
					{
						cooling_month: "October",
						energy_use: '.$v[9].',
						color: "#0D52D1"},
					{
						cooling_month: "November",
						energy_use: '.$v[10].',
						color: "#2A0CD0"},
					{
						cooling_month: "December",
						energy_use: '.$v[11].',
						color: "#8A0CCF"}]';
					echo "<h1 style='color:  #393B0B'> Monthly Interior Equipment (GJ) </h1>";
                    echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> January </th>
						<th> February </th>
						<th> March </th>
						<th> Apirl </th>
						<th> May </th>
						<th> June </th>
					</tr>
					<tr>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td> $v[2] </td>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td> $v[5]</td> 
					</tr>
					<tr>
						<th> July </th>
						<th> August </th>
						<th> September </th>
						<th> Octorber </th>
						<th> November </th>
						<th> December </th>
					</tr>
					<tr>
						<td> $v[6]</td>
						<td> $v[7]</td>
						<td> $v[8] </td>
						<td> $v[9]</td>
						<td> $v[10]</td>
						<td> $v[11]</td> 
					</tr>
				</table>		
END;
					echo '	<script> Monthly_End_Uses('.$data.'); </script>
						 	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 300px;"></div>';
			
					break;
/*********************************************************************************************************/
				case "monthly_fans":
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value]/1000000000;
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}

					$data = '[{
						cooling_month: "January",
						energy_use: '.$v[0].',
						color: "#FF0F00"},
					{
						cooling_month: "February",
						energy_use: '.$v[1].',
						color: "#FF6600"},
					{
						cooling_month: "March",
						energy_use: '.$v[2].',
						color: "#FF9E01"},
					{
						cooling_month: "Apirl",
						energy_use: '.$v[3].',
						color: "#FCD202"},
					{
						cooling_month: "May",
						energy_use: '.$v[4].',
						color: "#F8FF01"},
					{
						cooling_month: "June",
						energy_use: '.$v[5].',
						color: "#F8FF01"},
					{
						cooling_month: "July",
						energy_use: '.$v[6].',
						color: "#B0DE09"},
					{
						cooling_month: "August",
						energy_use: '.$v[7].',
						color: "#04D215"},
					{
						cooling_month: "September",
						energy_use: '.$v[8].',
						color: "#0D8ECF"},
					{
						cooling_month: "October",
						energy_use: '.$v[9].',
						color: "#0D52D1"},
					{
						cooling_month: "November",
						energy_use: '.$v[10].',
						color: "#2A0CD0"},
					{
						cooling_month: "December",
						energy_use: '.$v[11].',
						color: "#8A0CCF"}]';
					echo "<h1 style='color:  #393B0B'> Monthly Fans (GJ) </h1>";
				
				echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> January </th>
						<th> February </th>
						<th> March </th>
						<th> Apirl </th>
						<th> May </th>
						<th> June </th>
					</tr>
					<tr>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td> $v[2] </td>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td> $v[5]</td> 
					</tr>
					<tr>
						<th> July </th>
						<th> August </th>
						<th> September </th>
						<th> Octorber </th>
						<th> November </th>
						<th> December </th>
					</tr>
					<tr>
						<td> $v[6]</td>
						<td> $v[7]</td>
						<td> $v[8] </td>
						<td> $v[9]</td>
						<td> $v[10]</td>
						<td> $v[11]</td> 
					</tr>
				</table>		
END;
                    echo '	<script> Monthly_End_Uses('.$data.'); </script>
					     	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 300px;"></div>';
					break;
/*********************************************************************************************************/
				case "monthly_cooling":
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value]/1000000000;
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}

					$data = '[{
						cooling_month: "January",
						energy_use: '.$v[0].',
						color: "#FF0F00"},
					{
						cooling_month: "February",
						energy_use: '.$v[1].',
						color: "#FF6600"},
					{
						cooling_month: "March",
						energy_use: '.$v[2].',
						color: "#FF9E01"},
					{
						cooling_month: "Apirl",
						energy_use: '.$v[3].',
						color: "#FCD202"},
					{
						cooling_month: "May",
						energy_use: '.$v[4].',
						color: "#F8FF01"},
					{
						cooling_month: "June",
						energy_use: '.$v[5].',
						color: "#F8FF01"},
					{
						cooling_month: "July",
						energy_use: '.$v[6].',
						color: "#B0DE09"},
					{
						cooling_month: "August",
						energy_use: '.$v[7].',
						color: "#04D215"},
					{
						cooling_month: "September",
						energy_use: '.$v[8].',
						color: "#0D8ECF"},
					{
						cooling_month: "October",
						energy_use: '.$v[9].',
						color: "#0D52D1"},
					{
						cooling_month: "November",
						energy_use: '.$v[10].',
						color: "#2A0CD0"},
					{
						cooling_month: "December",
						energy_use: '.$v[11].',
						color: "#8A0CCF"}]';
					echo "<h1 style='color: #393B0B'> Monthly Cooling (GJ) </h1>";
					echo '	<script> Monthly_End_Uses('.$data.'); </script>
						 	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 300px;"></div>';
				echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> January </th>
						<th> February </th>
						<th> March </th>
						<th> Apirl </th>
						<th> May </th>
						<th> June </th>
					</tr>
					<tr>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td> $v[2] </td>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td> $v[5]</td> 
					</tr>
					<tr>
						<th> July </th>
						<th> August </th>
						<th> September </th>
						<th> Octorber </th>
						<th> November </th>
						<th> December </th>
					</tr>
					<tr>
						<td> $v[6]</td>
						<td> $v[7]</td>
						<td> $v[8] </td>
						<td> $v[9]</td>
						<td> $v[10]</td>
						<td> $v[11]</td> 
					</tr>
				</table>		
END;
					break;
/*********************************************************************************************************/				
				case "monthly_pumps":
					$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value]/1000000000;
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}

					$data = '[{
						cooling_month: "January",
						energy_use: '.$v[0].',
						color: "#FF0F00"},
					{
						cooling_month: "February",
						energy_use: '.$v[1].',
						color: "#FF6600"},
					{
						cooling_month: "March",
						energy_use: '.$v[2].',
						color: "#FF9E01"},
					{
						cooling_month: "Apirl",
						energy_use: '.$v[3].',
						color: "#FCD202"},
					{
						cooling_month: "May",
						energy_use: '.$v[4].',
						color: "#F8FF01"},
					{
						cooling_month: "June",
						energy_use: '.$v[5].',
						color: "#F8FF01"},
					{
						cooling_month: "July",
						energy_use: '.$v[6].',
						color: "#B0DE09"},
					{
						cooling_month: "August",
						energy_use: '.$v[7].',
						color: "#04D215"},
					{
						cooling_month: "September",
						energy_use: '.$v[8].',
						color: "#0D8ECF"},
					{
						cooling_month: "October",
						energy_use: '.$v[9].',
						color: "#0D52D1"},
					{
						cooling_month: "November",
						energy_use: '.$v[10].',
						color: "#2A0CD0"},
					{
						cooling_month: "December",
						energy_use: '.$v[11].',
						color: "#8A0CCF"}]';
					echo "<h1 style='color:  #393B0B'> Monthly Pumps (GJ) </h1>";
					echo '	<script> Monthly_End_Uses('.$data.'); </script>
						 	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 300px;"></div>';
				echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> January </th>
						<th> February </th>
						<th> March </th>
						<th> Apirl </th>
						<th> May </th>
						<th> June </th>
					</tr>
					<tr>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td> $v[2] </td>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td> $v[5]</td> 
					</tr>
					<tr>
						<th> July </th>
						<th> August </th>
						<th> September </th>
						<th> Octorber </th>
						<th> November </th>
						<th> December </th>
					</tr>
					<tr>
						<td> $v[6]</td>
						<td> $v[7]</td>
						<td> $v[8] </td>
						<td> $v[9]</td>
						<td> $v[10]</td>
						<td> $v[11]</td> 
					</tr>
				</table>		
END;
					break;
/*********************************************************************************************************/
                case "monthly_heating_gas":
    				$data = getDataFromSql($sqlFile, $tableName, $columnName, 
                                           $rowName, $reportName, $reportForString, $unit);
					foreach($data as $d) {
						$c[]=$d[ColumnName];
						$r[]=$d[RowName];
						$v[]=$d[Value]/1000000000;
						$u[$d[ColumnName]][$d[RowName]]=$d[Units];
					}

					$data = '[{
						cooling_month: "January",
						energy_use: '.$v[0].',
						color: "#FF0F00"},
					{
						cooling_month: "February",
						energy_use: '.$v[1].',
						color: "#FF6600"},
					{
						cooling_month: "March",
						energy_use: '.$v[2].',
						color: "#FF9E01"},
					{
						cooling_month: "Apirl",
						energy_use: '.$v[3].',
						color: "#FCD202"},
					{
						cooling_month: "May",
						energy_use: '.$v[4].',
						color: "#F8FF01"},
					{
						cooling_month: "June",
						energy_use: '.$v[5].',
						color: "#F8FF01"},
					{
						cooling_month: "July",
						energy_use: '.$v[6].',
						color: "#B0DE09"},
					{
						cooling_month: "August",
						energy_use: '.$v[7].',
						color: "#04D215"},
					{
						cooling_month: "September",
						energy_use: '.$v[8].',
						color: "#0D8ECF"},
					{
						cooling_month: "October",
						energy_use: '.$v[9].',
						color: "#0D52D1"},
					{
						cooling_month: "November",
						energy_use: '.$v[10].',
						color: "#2A0CD0"},
					{
						cooling_month: "December",
						energy_use: '.$v[11].',
						color: "#8A0CCF"}]';
					echo "<h1 style='color:  #393B0B'> Monthly Heating Gas (GJ) </h1>";
					echo '	<script> Monthly_End_Uses('.$data.'); </script>
						 	<div id="chartdiv" style="margin: 5px auto; width: 90%; height: 300px;"></div>';
				echo <<<END
				<table border=1 cellspacing=0; style="text-align: center; font-size: 12px; width: 90%; margin: 0 5%;">
					<tr>
						<th> January </th>
						<th> February </th>
						<th> March </th>
						<th> Apirl </th>
						<th> May </th>
						<th> June </th>
					</tr>
					<tr>
						<td> $v[0]</td>
						<td> $v[1]</td>
						<td> $v[2] </td>
						<td> $v[3]</td>
						<td> $v[4]</td>
						<td> $v[5]</td> 
					</tr>
					<tr>
						<th> July </th>
						<th> August </th>
						<th> September </th>
						<th> Octorber </th>
						<th> November </th>
						<th> December </th>
					</tr>
					<tr>
						<td> $v[6]</td>
						<td> $v[7]</td>
						<td> $v[8] </td>
						<td> $v[9]</td>
						<td> $v[10]</td>
						<td> $v[11]</td> 
					</tr>
				</table>		
END;
					break;
/*********************************************************************************************************/
				default:
					echo "<h1 style='color: #FF0000'> Request Is Not Found!!</h1>";
			}
		?>
		</div>
	</div>
</main>

<footer>
	<p style="text-align: center"  >
		<a class="policy-link" href="./index.php"> &copy;2013 RMT</a>
		<a class="policy-link" href="#"> Term of Service</a>
		<a class="policy-link" href="#"> Privacy Policy</a>
		<a class="policy-link" href="#"> Help</a>
	</p>
</footer>

<script>
	$("#content").hide();
	$("table").hide();
	$("#content").fadeIn("slow");
	$("table").show("fast");
</script>
</body>

</html>