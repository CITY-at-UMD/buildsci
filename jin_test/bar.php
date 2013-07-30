<?php
    /*
     *  This function gets value and unit from sql file
     *  input:  assume All input variables are valid to the table
     *  output: return Value and Units 
     */
    function getValueFromSql($fileName, $tableName, $columnName, $rowName, $reportName, $reportForString)
	{
		$db = new SQLite3("$fileName");
		if(!$db) die("Error: File is Not found!\n"); 
        
        // Sql statement
		$sql = "Select * From TabularDataWithStrings
			    Where RowName <> '' 
                And Value <> '' ";
        
        // concatenate matched TableName condition
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
        if($columnName != NULL) {
            $sql = $sql."And ColumnName IN (";
            for($i=0; $i < count($columnName); $i++)
            {
                if($i!=count($columnName)-1) {
                    $sql=$sql."'$columnName[$i]', ";   
                }
                else{
                    $sql=$sql."'$columnName[$i]'";
                }
            }
            $sql=$sql.") ";
        }
        
        // concatenate matched RowName condition
        if($rowName != NULL) {
            $sql = $sql."And RowName IN (";
            for($i=0; $i < count($rowName); $i++)
            {
                if($i!=count($rowName)-1) {
                    $sql=$sql."'$rowName[$i]', ";   
                }
                else{
                    $sql=$sql."'$rowName[$i]'";
                }
            }
            $sql=$sql.") ";
        }
        
        // concatenate matched ReportName condition
        if($reprotName != NULL) {
            $sql = $sql."And ReportName IN (";
            for($i=0; $i < count($reprotName); $i++)
            {
                if($i!=count($reprotName)-1) {
                    $sql=$sql."'$reprotName[$i]', ";   
                }
                else{
                    $sql=$sql."'$reprotName[$i]'";
                }
            }
            $sql=$sql.") ";  
        }
        
        // concatenate matched ReportForString condition
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
            echo $sql;
        }
        
		$result = $db->query("$sql");
		
		if(!$result) die("Error: Query is incorrect!\n");
		
		$output;
		$index=0;
		while($row=$result->fetchArray(SQLITE3_ASSOC)) {
           /* $output[$index]['TableName']=$row['TableName'];
            $output[$index]['ColumnName']=$row['ColumnName'];
            $output[$index]['RowName']=$row['RowName'];
            $output[$index]['Value']=$row['Value']; 
			$output[$index]['Units']=$row['Units'];*/
            $TN=$row['TableName'];
            $CN=$row['ColumnName'];
            $RN=$row['RowName'];
            $output[$TN][$CN][$RN]=$row['Value'];
			$index++;
		}
		return $output;
	}
      
    $sqlFile="../Buildings/ENERGYPLUS/JinTest55.idf/EnergyPlus/eplusout.sql";
    
    $reportName = array(0=>"AnnualBuildingUtilityPerformanceSummary");
    $reportForString=array(0 => "Entire Facility");
    $tableName= array(0=> "End Uses", 1=>"Site and Source Energy" );
    $columnName=array(0=>"Total Energy");
    $rowName=array(0=>"Total Site Energy", 1=>"Net Site Energy");
  
    
    $test=getValueFromSql($sqlFile, $tableName, $columnName, $rowName, $reportName, $reportForString);
   // print_r($test);
    foreach($test as $T) {
        echo $T;
    }
?>