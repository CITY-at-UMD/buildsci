<?php
	/* */
	
	$isTgTable = 0;                                   // 0: is not the target table, 1: is the target table 
	$filename  = "BuildChicagoTable.html";            // the name and location of the input file
	
	$curCol    = 1;									  // the current colum
	$curRow    = 1;									  // the current row
	
	$fh = fopen($filename, "r");					  // the read file handler 
	
	$key = "";
	$value = "";
	
	$tableHead = "/\<b\>End Uses\<\/b\>/";
	$tableTail = "/\<\/table\>/";
	
	
	$q=$_GET["q"];									  //get the q parameter from URL
	
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
				
				if(($curCol%7) == 2)
					$key = $key.$buffer;
				if(($curCol%7) == 3) 
					$value = $value.$buffer;
			}
		}
		
		if (!feof($fh)) {
			echo "Error: unexpected fgets fail \n";
		}
	}
	fclose($fh);

	echo $key."<br>".$value;
?>