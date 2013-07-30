<?php

    /*==============================================================================================*/
    /*
     *  This function retrives Value and Units from the sql file on demand
     *  PRE:    $fileName is a .sql format file (e.g "RMT4.sql")
     *          $tableName, $columnName, $rowName, $reportName, $reportForString are
     *              string that matche the attributes in the sqlite db
     *  POST: returns the value of the following attributes Value and Units from this sqlite db 
     */
    /*==============================================================================================*/
    function getValueFromSql($fileName, $tableName, $columnName, $rowName, $reportName, $reportForString)
    {
        $db = new SQLite3("$fileName");
    	if(!$db) die("Error: File is Not found!\n"); 
        
        // Default Sql statement
		$sql = "Select * From TabularDataWithStrings 
                Where RowName <> '' ";
        
        // match the ReportName to $reportName
        if($reportName != NULL ) {
            $sql = $sql."And ReportName == '$reportName' ";
        }
        
        // match the TableName to $reportName
        if($tableName != NULL) {
            $sql = $sql."And TableName == '$tableName' ";
        }
        
        // concatenate matched ReportForString string
        if(is_array($reportForString)) {
            $sql = $sql."And ReportForString IN (";
            for($i=0; $i < count($reportForString); $i++)
            {
                if($i!=count($reportForString)-1) {
                    $sql=$sql."'$reportForString[$i]', ";   
                }
                else{
                    $sql=$sql."'$reportForString[$i]'";
                }
            }
            $sql=$sql.") ";
        }
			
		if(is_array($columnName)) {
		    // concatenate matched ColumnName condition
		    $sql = $sql."And ColumnName IN (";
		    foreach($columnName as $CN)
		    {
		           $sql=$sql."'$CN', ";   
		    }
		    $sql=$sql." '') ";
        }
		else if($columnName != "Array" && $columnName != NULL){
			$sql = $sql."And ColumnName == '$columnName' ";
		}
        
		if(is_array($rowName)) {
		    // concatenate matched RowName condition
		    $sql = $sql."And RowName IN (";
		    foreach($rowName as $RN)
		    {
		            $sql=$sql."'$RN', ";   
		    }
		    $sql=$sql." '') ";
		}
		else if($rowName != "Array" && $rowName != NULL) {
			$sql = $sql."And RowName == '$rowName' ";
		}
        
        // Check if the query is found!
    	$result = $db->query("$sql");
        if(!$result) die("Error: Query is incorrect!\n");
        
        // Store the result to output array
		$output;
		$index=0;

		while($row=$result->fetchArray(SQLITE3_ASSOC)) {
            // assign array by index
            $output[$index]['TableName']=$row['TableName'];
            $output[$index]['ColumnName']=$row['ColumnName'];
            $output[$index]['RowName']=$row['RowName'];
            $output[$index]['Value']=$row['Value']; 
			$output[$index]['Units']=$row['Units'];
            
			$index++;
		}
		return $output;
	}
    
    
    /*==============================================================================================*
     *
     *  This function retrives disctinct Tablename from sql file 
     *  input:      $reportName is an array of String
     *  output:     return tablename array 
     *
     *==============================================================================================*/
   
     function getTableName($sqlFile, $reportName) {
        
        $db = new SQLite3("$sqlFile");
        if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
		$sql = "Select Distinct TableName From TabularDataWithStrings 
                Where TableName <> '' ";
                
        if($reportName != NULL) {$sql = $sql."And ReportName == '$reportName' "; }
		
        $result = $db->query("$sql");
		
		if(!$result) die("Error: Query is incorrect!\n");
		
		$output;
		$index=0;
        // Store data to array
		while($row=$result->fetchArray(SQLITE3_ASSOC)) {
			$output[$index]=$row['TableName'];
			$index++;
		}
		return $output;
    }
    
    /*==============================================================================================
     *
     *  This function returns ColumnName from Sql File
     *
     *
     *==============================================================================================*/
    function getColumnName($sqlFile, $tableName, $reportName) {
        
        $db = new SQLite3("$sqlFile");
        if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
        $sql = "Select Distinct ColumnName From TabularDataWithStrings 
                Where RowName <> '' ";
        
        if($tableName!=NULL){ $sql=$sql."And TableName == '$tableName' ";}
        if($reportName != NULL) { $sql=$sql."And ReportName == '$reportName' ";}
        
        $result = $db->query("$sql");
    	
		if(!$result) die("Error: Query is incorrect!\n");
		
		$output;
		$index=0;
        // Store data to array
		while($row=$result->fetchArray(SQLITE3_ASSOC)) {
			$output[$index]=$row['ColumnName'];
			$index++;
		}
		return $output;
    }
    
    /*==============================================================================================*/
    /*
     *  This function retrieves RowName From Sql File
     *
     */
    /*==============================================================================================*/
    function getRowName($sqlFile, $tableName, $reportName) {
        
        $db = new SQLite3("$sqlFile");
        if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
        $sql = "Select Distinct RowName From TabularDataWithStrings 
                Where RowName <> '' ";
        
        if($tableName!=NULL){ $sql=$sql."And TableName == '$tableName' ";}
        if($reportName != NULL) { $sql=$sql."And ReportName == '$reportName' ";}
        
        $result = $db->query("$sql");
		
		if(!$result) die("Error: Query is incorrect!\n");
		
		$output;
		$index=0;
        // Store data to array
		while($row=$result->fetchArray(SQLITE3_ASSOC)) {
			$output[$index]=$row['RowName'];
			$index++;
		}
		return $output;
    }
    
    /*==============================================================================================*
     *
     *  This Function gets ReportName From Sql File
     *
     *
     *
     *==============================================================================================*/
    function getReportName($sqlFile) {
                
        $db = new SQLite3("$sqlFile");
        if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
    	$sql = "Select Distinct ReportName From TabularDataWithStrings";
                
		$result = $db->query("$sql");
		
		if(!$result) die("Error: Query is incorrect!\n");
		
		$output;
		$index=0;
        
        // Store data to array
		while($row=$result->fetchArray(SQLITE3_ASSOC)) {
			$output[$index]=$row['ReportName'];
			$index++;
		}
		return $output;
    }
    
    /*==============================================================================================
     *
     *  This function retrives ReportForString From Sql File
     *
     *
     *
     *==============================================================================================*/
    function getReportForString($sqlFile, $reportName) {
                
        $db = new SQLite3("$sqlFile");
        if(!$db) die("Error: File is Not found!\n"); 

        // Sql statment
        $sql = "Select Distinct ReportForString From TabularDataWithStrings ";
        
        // add Where condiction for the ReportName to sql statement
        $sql = $sql."Where ReportName IN (";
        for($i=0; $i < count($reportName); $i++)
        {
            if($i!=count($reportName)-1) {
                $sql=$sql."'$reportName[$i]', ";   
            }
            else{
                $sql=$sql."'$reportName[$i]'";
            }
        }
        $sql=$sql.") ";  
        
		$result = $db->query("$sql");
		
		if(!$result) die("Error: Query is incorrect!\n");
		
		$output;
		$index=0;
        // Store data to array
		while($row=$result->fetchArray(SQLITE3_ASSOC)) {
			$output[$index]=$row['ReportForString'];
			$index++;
		}
		return $output;
    }
    
    /*==============================================================================================*/
    /*
     *  This function print out a pie chart javascript
     *  input: $result is an array that contains the data values, units and names
     */
    /*==============================================================================================*/
  	function printPieJavascript($result) {
    echo <<<END
	    <script type="text/javascript">
            var chart;
            var legend;

            var chartData = 
			[
END;
			// input units
			$units = $result[0]['Units'];
			
			// set chart input with only numeric data
			foreach($result as $R) {
				// check if the data is compared in same unit
				//if($R[Units]!=$units) break;
				
				if(is_numeric($R['Value']) && $R['Value'] > 0 ){
					echo" 	{ 	row_name: '{$R['RowName']}', 
								row_value: {$R['Value']}   },";
				}
			}
			echo <<<END
			];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "row_name";
                chart.valueField = "row_value";

                // LEGEND
                legend = new AmCharts.AmLegend();
                legend.align = "center";
                legend.markerType = "circle";
				chart.depth3D = 10;
				chart.labelRadius = 30;
                chart.labelText = "[[title]]: [[percents]]%";
                chart.angle = 10;
                chart.addLegend(legend);
				legend.switchType = "x";
                
                // WRITE
                chart.write("PieChart");
            });
        </script>
END;
}


/*
 *  This function prints the summary of the building model based on the user input
 */
function display_results($search_key) {
    
    $username='root';
    $password='srebric10-11';
    $database='hackathon';
    $localhost='localhost';
    
    // connect to database
    $con = mysql_connect($localhost, $username, $password);
    if(!$con) {
        die('could not connect: '.mysql_error());
    }
    
    // select database
    mysql_select_db($database, $con); 

    // SQL
    $sql = "Select distinct B.buildingID, concat(buildingName, userSubmitted) as modelname, L.city, L.state,
                   L.weatherFile, F.functionType, R.name as roofMaterial, W.name as wallMaterial,
				   floors, floorArea, windowPercent 
            From buildings B, locations L, roofmaterials R, wallmaterials W, functions F
            Where concat(buildingName, userSubmitted) like '%".$search_key."%' and B.functionID = F.functionID 
                  and B.locationID = L.locationID and W.wallMatID = 1 and R.roofMatID = 1
            Order by B.buildingID DESC";
    
    // execute and check the sql query on the database 
    $result = mysql_query($sql, $con); 
    if(!$result) {
        die('Invalid query: '.mysql_error());
    }
    
    echo '<table id="summary-table" width="99%" height="80%" border="0" style="margin-top: -10px; padding: 5px; ">';
    $count = 0;
    if($search_key != '') {
        while ($row = mysql_fetch_assoc($result)) { 
        $html_path = "../Buildings/ENERGYPLUS/{$row['modelname']}.idf/EnergyPlus/eplustbl.htm";
        $idf_path = '../Buildings/'.$row['modelname'].'.idf';
        $epw_path = '../Weather/'.$row['weatherFile'].'.epw';
        
        echo     '<tr>
                    <td><div align="right"><strong>Simulated Result (.html):</strong></div></td>
                    <td><div align="justify"><em><a href="'.$html_path.'" target="_blank"> '.$row['modelname'].'Table.html </a></em></div></td>
                  </tr>
                  <tr>
                    <td width="250"><div align="right"><strong>Building (.idf):</strong></div></td>
                                    <td width="550"> <div align="justify"><em><a href="'.$idf_path.'" target="_blank"> '.$row['modelname'].'.idf </a> </em></div></td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Weather (.epw):</strong></div></td>
                                    <td> <div align="justify"><em><a href="'.$epw_path.'" target="_blank"> '.$row['weatherFile'].'.epw </a> </em></div></td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Created Date:</strong></div></td>
                    <td><div align="justify"><em>not yet supported</em></div></td>
                  </tr>
                <tr>
                <td><div align="right"><strong>By Author:</strong></div></td>
                                <td> <div align="justify"><em>not yet supported </em></div></td>
                </tr>
                 
                  <tr>
                    <td><div align="right"></div></td>
                    <td> <div align="justify"><em></em></div></td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Area:</strong></div></td>
                    <td><div align="justify"><em>'.$row['floorArea'].' m<sup>2</sup> </em></div></td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Number Of Floors:</strong></div></td>
                    <td><div align="justify"><em>'.$row['floors'].'</em></div></td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Window Percentage:</strong></div></td>
                    <td><div align="justify"><em>'.$row['windowPercent'].'%</em></div></td>
                  </tr>
                  
                  <tr>
                    <td><div align="right"><strong>Building Type:</strong></div></td>
                    <td><div align="justify"><em>'.$row['functionType'].'</em></div></td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Wall Materials:</strong></div></td>
                    <td><div align="justify"><em>'.$row['wallMaterial'].'</em></div></td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Roof Materials:</strong></div></td>
                    <td><div align="justify"><em>'.$row['roofMaterial'].'</em></div></td>
                  </>';
                  $count=$count+1;
                  if($count > 0) break;      // display the lastest result for the user
        }
    }
    echo '</table>';
    
    // close database
    mysql_close($con);
}


function getDataFromSql($fileName, $tableName, $columnName, $rowName, $reportName, $reportForString, $units)
{
	$db = new SQLite3("$fileName");
	if(!$db) die("Error: File is Not found!\n"); 
    
	$sql = "Select Distinct * From TabularDataWithStrings
			Where TableName Like '$tableName' 
		      And ColumnName Like '$columnName'
              And RowName Like '$rowName'
		      And ReportName Like '$reportName' 
		      And ReportForString Like '$reportForString'
		      And Units Like '$units'";

	$result = $db->query("$sql");
	
	if(!$result) die("Error: Query is incorrect!\n");

	$output;
	$index=0;
	while($row=$result->fetchArray(SQLITE3_ASSOC)) {
        
		$output[$index]['ColumnName']=$row['ColumnName'];
        $output[$index]['RowName']=$row['RowName'];
        
		$output[$index]['FullName']=$row['ColumnName'].'_'.$row['RowName']; 
		$output[$index]['Value']=$row['Value']; 
		$output[$index]['Units']=$row['Units'];
        
		$index++;
	}
	return $output;
}

function barChart($result) {
  echo <<<END
        <script type="text/javascript">
            var chart;
            var chartData1 = [\n
END;
            // Set up input data
    	    $units = $result[0]['Units'];	
            $skip = false;
			$i = 0;
            
			// set chart input with only numeric data
			While($i < count($result)) {
                $rowName = str_replace(":", "_", $result[$i]['RowName']);
                $columnName = str_replace(":", "_", $result[$i]['ColumnName']);
                $value = $result[$i]['Value'];
              /* if($units == "J") {
                     // convert unit J to GJ
                     $value = $value/1000000000;
                     $units == "GJ";
                }*/
                
                if ($result[$i]['RowName'] == NULL || $result[$i]['RowName'] == "Time of Peak" ) {
                    $skip = true;
                }
                
                if( $result[$i]['RowName'] != NULL && $result[$i]['RowName'] != "Time of Peak" && $result[$i]['ColumnName'] == $result[0]['ColumnName']) {
                    $skip = false;
                }
                
                // Start of the row, Set Row Name
                if($result[$i]['ColumnName'] == $result[0]['ColumnName'] && !$skip) {
				    echo "    { 	month: '$rowName',\n";
                }
                
                // Input Cell Values
                if($skip==false)
                    echo "              $columnName: $value/1000000000,\n";  
                $i=$i+1;
                
                // End of the row
                if($result[$i]['ColumnName'] == $result[0]['ColumnName'] && $skip == false) {
                    echo "    },\n";
                }
			}
            
			echo <<<END
			 },];
            
            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData1;
                chart.categoryField = "month";
                chart.startDuration = 1;
                chart.plotAreaBorderColor = "#DADADA";
                chart.plotAreaBorderAlpha = 1;
                // this single line makes the chart a bar chart          
                chart.rotate = true;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.gridAlpha = 0.1;
                valueAxis.position = "top";
                chart.addValueAxis(valueAxis);
END;
                // Initialize Graphs
                if($result[0]['ColumnName']!=NULL) {
                    $j=0;
                    // Graph On Column
                    do{
                        $columnName = str_replace(":", "_", $result[$j]['ColumnName']);
                        echo <<<END
                         
                        // GRAPH_$j
                        var $columnName = new AmCharts.AmGraph();
                        $columnName.type = "column";
                        $columnName.title = "$columnName";
                        $columnName.valueField = "$columnName";
                        $columnName.balloonText = "$columnName: [[value]] $units";
                        $columnName.lineAlpha = 0;
                        $columnName.fillAlphas = 1;
                        chart.addGraph($columnName);
END;
                        $j=$j+1;
                    }while( $result[$j]['ColumnName'] != $result[0]['ColumnName'] && $result[$j]['ColumnName'] != NULL);  
                }
                
                echo <<<END
                // LEGEND
                var legend = new AmCharts.AmLegend();
                chart.addLegend(legend);

                // WRITE
                chart.write("monthly_data_chartdiv");
            });
        </script>
		<div id='monthly_data_chartdiv' style='width: 100%; height: 90%;'></div>
END;
}

function pieChart($result) {
 // Pie Chart Javascript
    echo <<<END
    <script type="text/javascript">
            var chart;
            var legend;

            var chartData = 
			[
END;
			// input units
			$units = $result[0]['Units'];			
			
			// set chart input with only numeric data
			foreach($result as $R) {
				// check if the data is compared in same unit
				if($R['Units'] != $units) return;
				$rowName = str_replace(":", "_", $R['FullName']);
				if(is_numeric($R['Value']) && $R['Value'] > 0){
					echo" 	{ 	row_name: '$rowName', 
								row_value: {$R['Value']}   },";
				}
			}

			echo <<<END
			];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "row_name";
                chart.valueField = "row_value";

                // LEGEND
                legend = new AmCharts.AmLegend();
                legend.align = "center";
                legend.markerType = "circle";
				chart.depth3D = 10;
				chart.labelRadius = 30;
                chart.labelText = "[[title]]: [[percents]]%";
                chart.angle = 10;
                chart.addLegend(legend);
				legend.switchType = "x";
                // WRITE
                chart.write("chartdiv");
            });
           
        </script>
END;
}

?>
