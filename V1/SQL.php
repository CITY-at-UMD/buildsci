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
                Where RowName <> '' ";
        
        // Multi-Reports
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
        
        // Single Report
        //$sql=$sql."And ReportName Like '$reportName' ";
        
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
        
		$result = $db->query("$sql");
		
		if(!$result) die("Error: Query is incorrect!\n");
		
		$output;
		$index=0;
		while($row=$result->fetchArray(SQLITE3_ASSOC)) {
            //$output[$index]['TableName']=$row['TableName'];
            //$output[$index]['ColumnName']=$row['ColumnName'];
            //$output[$index]['RowName']=$row['RowName'];
            $output[$index]['Value']=$row['Value']; 
			//$output[$index]['Units']=$row['Units'];
            /*$TN=$row['TableName'];
            $CN=$row['ColumnName'];
            $RN=$row['RowName'];
            $output["$CN"]["$RN"]=$row['Value'];*/
			$index++;
		}
		return $output;
	}
    
    
    /*
     *  This function only retrives disctinct table from sql file 
     *  input:      $reportName is a string array
     *  output:     return tablename array 
     */
    function getTableName($sqlFile, $reportName) {
        
        $db = new SQLite3("$sqlFile");
		if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
		$sql = "Select Distinct TableName From TabularDataWithStrings 
                Where TableName <> '' ";
         // Multi-Reports
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
    
    
    /*
     *
     *
     *
     */
    function getColumnName($sqlFile, $tableName, $reportName) {
        
        $db = new SQLite3("$sqlFile");
    	if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
		$sql = "Select Distinct ColumnName From TabularDataWithStrings 
                Where RowName <> '' ";
                
        if($tableName!=NULL){ $sql=$sql."And TableName Like '%$tableName%' ";}
        if($reportName!=NULL){ $sql=$sql."And ReportName Like '%$reportName%' ";}
        
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
    
    
    /*
     *
     *
     *
     */
    function getRowName($sqlFile, $tableName, $reportName) {
        
        $db = new SQLite3("$sqlFile");
        if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
		$sql = "Select Distinct RowName From TabularDataWithStrings 
                Where RowName <> '' ";
        
        if($tableName!=NULL){ $sql=$sql."And TableName Like '%$tableName%' ";}
        if($reportName!=NULL){ $sql=$sql."And ReportName Like '%$reportName%' ";}
		
        echo $sql;
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
    
    /*
     *
     *
     *
     */
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
    
      
    /*
     *
     *
     *
     */
    function getReportForString($sqlFile, $reportName) {
                
        $db = new SQLite3("$sqlFile");
        if(!$db) die("Error: File is Not found!\n"); 

        // Sql 
        $sql = "Select Distinct ReportForString From TabularDataWithStrings
                Where ReportName='$reportName' ";
                
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


?>