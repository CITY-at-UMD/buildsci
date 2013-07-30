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
    /*function getValueFromSql($fileName, $tableName, $columnName, $rowName, $reportName, $reportForString)
    {
    	$db = new SQLite3("$fileName");
		if(!$db) die("Error: File is Not found!\n"); 
        
        // Sql statement
		$sql = "Select * From TabularDataWithStrings 
                Where RowName <> '' ";
        
        // Multi-Reports
        // concatenate matched ReportName string
        $sql = $sql."And ReportName IN (";
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
        
        // concatenate matched ReportForString string
        if($reportForString != '') {
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
        
        // concatenate matched TableName string
        if($tableName != NULL) {
            $sql = $sql."And TableName IN (";
            for($i=0; $i < count($tableName); $i++)
            {
                if($i!=count($tableName)-1) {
                    $sql=$sql."'$tableName[$i]', ";   
                }
                else{
                    $sql=$sql."'$tableName[$i]'";
                }
            }
            $sql=$sql.") ";
        }
        
        // concatenate matched ColumnName condition
        $sql = $sql."And ColumnName IN (";
        foreach($tableName as $TN) {
            foreach($columnName[$TN] as $CN)
            {
                   $sql=$sql."'$CN', ";   
            }
        }
        $sql=$sql." '') ";
        
        
        // concatenate matched RowName condition
        $sql = $sql."And RowName IN (";
        foreach($tableName as $TN) {
            foreach($rowName[$TN] as $RN)
            {
                    $sql=$sql."'$RN', ";   
            }
        }
        $sql=$sql." '') ";
        
		$result = $db->query("$sql");
		
		if(!$result) die("Error: Query is incorrect!\n");
        
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
	}*/
    function getValueFromSql($fileName, $tableName, $columnName, $rowName, $reportName, $reportForString)
    {
        $db = new SQLite3("$fileName");
    	if(!$db) die("Error: File is Not found!\n"); 
        
        /* ################################################################################################ */
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
        
        //echo $sql;
        /* ################################################################################################ */
        // Check if the query is found!
    	$result = $db->query("$sql");
        if(!$result) die("Error: Query is incorrect!\n");
        
        /* ################################################################################################ */
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
            
            // assign array by TableName, ColumnName, and RowName
            /*$TN=$row['TableName'];
            $CN=$row['ColumnName'];
            $RN=$row['RowName'];
            $output["$TN"]["$CN"]["$RN"]=$row['Value'];*/
			$index++;
		}
		return $output;
	}
    
    
    /*==============================================================================================*/
    /*
     *  This function retrives disctinct Tablename from sql file 
     *  input:      $reportName is an array of String
     *  output:     return tablename array 
     */
    /*==============================================================================================*/
    /*function getTableName($sqlFile, $reportName) {
        
        $db = new SQLite3("$sqlFile");
		if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
		$sql = "Select Distinct TableName From TabularDataWithStrings 
                Where TableName <> '' ";
         
        // Multi-ReportNames
        // Add matched ReportName 
        $sql = $sql."And ReportName IN (";
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
			$output[$index]=$row['TableName'];
			$index++;
		}
		return $output;
    }*/
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
    
    /*==============================================================================================*/
    /*
     *  This function returns ColumnName from Sql File
     *
     */
    /*==============================================================================================*/
    /*function getColumnName($sqlFile, $tableName) {
        
        $db = new SQLite3("$sqlFile");
    	if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
		$sql = "Select Distinct ColumnName From TabularDataWithStrings 
                Where RowName <> '' ";
                
        if($tableName!=NULL){ $sql=$sql."And TableName Like '$tableName' ";}
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
    }*/
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
    /*function getRowName($sqlFile, $tableName) {
        
        $db = new SQLite3("$sqlFile");
        if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
		$sql = "Select Distinct RowName From TabularDataWithStrings 
                Where RowName <> '' ";
        
        if($tableName!=NULL){ $sql=$sql."And TableName Like '$tableName' ";}
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
    }*/
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
    
    /*==============================================================================================*/
    /*
     *  This Function gets ReportName From Sql File
     *
     *
     */
    /*==============================================================================================*/
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
    
    /*==============================================================================================*/  
    /*
     *  This function retrives ReportForString From Sql File
     *
     *
     */
    /*==============================================================================================*/
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
    /*function printPieJavascript($result) {
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
				if($R[Units]!=$units) break;
				
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
}*/
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

?>
