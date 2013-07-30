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

$something = readHtml("./","monthly_data.html");
//echo $something["Heating(GJ)"];
//echo $something["Heating(W)"];

	//echo $key."<br>".$value;
?>
