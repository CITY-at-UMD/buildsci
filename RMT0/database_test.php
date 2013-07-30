<?php
    //print "hello world!\n";
    
    function queryBuildingModels() {   
        $username='hackathon';
        $password='hackathon';
        $database='hackathon';
        $localhost='localhost';
        
        
        // connect database
        $con = mysql_connect($localhost, $username, $password);
        if(!$con) {
            die('could not connect: '.mysql_error());
        }
        //print "connected successfully\n"; 
        
        // select hackathon from the database
        mysql_select_db($database, $con); 
        
        // select user from user table
        $sql = 'SELECT `buildingName`, `userSubmitted` AS model FROM buildings';
        $result = mysql_query($sql, $con); 
        if(!$result) {
            die('Invalid query: '.mysql_error());
        }
        
        //print "<br>Result:<hr> \n";
        
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            //printf("model: %s%s\n", $row['buildingName'], $row['model']);
            $output[$i] = $row['buildingName'] . $row['model'];
            $i = $i+1;
        }
        
        // close database
        mysql_close($con);
        return $output;
    }

    function listBuildingModel() {
        // $filePath = "./Buildings/Output/%sTable.html' target=\"_blank\"
        $A = queryBuildingModels();
        
        printf("<ul>");
        for($j=count($A); $j>=0; $j--) { 
            $tablePath = './Buildings/Output/'.$A[$j].'Table.html';
            echo '<li> <a href="'.$tablePath.'" target="_blank">'.$A[$j].'</a> </li>';
        }
        printf("</ul>");
    }
    
    //listBuildingModel();
    // print "end\n";  

?>
