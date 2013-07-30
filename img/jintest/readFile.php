<?php

function readHtml($path,$htmlFile,$tableName,$selectColumn,$totalColumn) {
	$isTgTable = 0;                                   // 0: is not the target table, 1: is the target table 
	$filePath = $path;									  
	$filename  = $path.'/'.$htmlFile;                 // the name and location of the input file
	$curCol    = 1;									  // the current column
	$curRow    = 1;									  // the current row
	$index_value = 0;
    
	// by default the unit is GJ in the table
	$unit = 'GJ';
	$fh = fopen($filename, "r");					  // the read file handler 
	
	$key = "";
	$value = "";
	$newValue;
	$tableHead = "/\<b\>".$tableName."\<\/b\>/";
	$tableTail = "/\<\/table\>/";
	
	// get table information from the file 
	if($fh) {
		while (($buffer = fgets($fh, 4096)) != false ) {

			// found the head of table
			if (preg_match($tableHead, $buffer)) $isTgTable=1;
			
			// print the table
			if ($isTgTable == 1) {
				// found the tail of table stop printing
				if (preg_match($tableTail, $buffer))
					$isTgTable = 0;
	
				// updating current row and colum
				preg_match("/\<\/td\>/", $buffer) ? $curCol++ : $curCol;		
				preg_match("/\<\/tr\>/", $buffer) ? $curRow++ : $curRow;
				
				// Key Column 
				if(($curCol%$totalColumn) == 2) {
				    $pattern='/^.*\>(.*)\<.*/i';
					$replacement = '$1';
					$key = str_replace("\n", "", preg_replace($pattern,$replacement, $buffer));
					echo $buffer;
				}
				
				// Value Column
				if(($curCol%$totalColumn) == $selectColumn+1) {
					//$value = $value.$buffer;
					$pattern='/^.*\>(.*)\<.*/i';
					$replacement = '$1';

					// unit is set to GJ by default
					// if see the $key is 'Time of Peak' 
					// set the unit to W
					if($key=='Time of Peak')
					{
						$unit = 'W';
					}
					if($unit == 'GJ') {
						$newValue[$key.'(GJ)'] = str_replace(" ", "", preg_replace($pattern,$replacement, $buffer));
						echo $buffer;
					}
					else if ( $unit == 'W')
						$newValue[$key.'(W)'] = str_replace(" ", "", preg_replace($pattern,$replacement, $buffer));

					//echo $index_value;
				}
			}
		}
		
		if (!feof($fh)) {
			echo "Error: unexpected fgets fail \n";
		}
	}
	fclose($fh);

	return $newValue;
}

function retriveMonthlyData($path,$htmlFile,$title,$selectColumn,$totalColumn) {
    $isTgTable = 0;                                   // 0: is not the target table, 1: is the target table 

	// the input file information
	$filePath = $path;									  
	$filename  = $path.'/'.$htmlFile;                 // the name and location of the input file

	// the current row and column
	$curCol    = 0;									  // the current column
	$curRow    = 0;									  // the current row

	// file open
	$fh = fopen($filename, "r");					  // the read file handler 

	// cell information
	$key = "";
	$newValue;

	// talbe information
	$tableHead = "/\<p\>Report:\<b\> BUILDING MONTHLY COOLING LOAD REPORT\<\/b\>\<\/p\>/";     //  "/<b\>".$tableName."\<\/b\>/";
	$zoneField = "/\<p\>For:\<b\> THERMAL ZONE [0-9]+\<\/b\>\<\/p\>/";

	$tableTail = "/\<\/table\>/";
	
	// get table information from the file 
	if($fh) {
    // getline 
		while (($buffer = fgets($fh, 4096)) != false ) {

			// found the taget table
			if (preg_match($tableHead, $buffer)){  
				//print '!!!!!!!!!table head: '.$buffer.'!!!!!!!!!';				
				$isTgTable=1;
		  }
		
      // found the zone field
			if (preg_match($zoneField, $buffer)){
				$pattern='/\<p\>For:\<b\> THERMAL ZONE ([0-9]+)\<\/b\>\<\/p\>/';
				$replacement = '$1';
				$zone = str_replace("\n", "", preg_replace($pattern,$replacement, $buffer));
				//print '##########zone field: '.$zone.'##########\n';
			}

			// select the right table to print out
			if ($isTgTable == 1) {

				// found the tail of table, and stop printing
				if (preg_match($tableTail, $buffer))
					$isTgTable = 0;

				// updating current row and colum
				preg_match("/\<\/td\>/", $buffer) ? $curCol++ : $curCol;		
				preg_match("/\<\/tr\>/", $buffer) ? $curRow++ : $curRow;
			
				// Key is at the first column on the table
				if(($curCol%$totalColumn) == 1) {
					
					$pattern='/^.*\>(.*)\<.*/i';
					$replacement = '$1';
					$key = str_replace("\n", "", preg_replace($pattern,$replacement, $buffer));
					//echo $key;
				}
			
				// Value Column
				if(($curCol%$totalColumn) == $selectColumn) {

					$pattern='/^.*\>(.*)\<.*/i';
					$replacement = '$1';
                    
					$newValue[$key.'Zone'.$zone.'Column'.$selectColumn] = str_replace(" ", "", preg_replace($pattern,$replacement, $buffer));
				}
			}
		}
		
		// check if the file ends successfully
		if (!feof($fh)) {
			echo "Error: unexpected fgets fail \n";
		}
	}
	// close file
	fclose($fh);
	return $newValue;
}

?>
