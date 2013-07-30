<?php

    // retrive the modelName = buildingName + submittedID from buildings table
    // return array of modelNames
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
        $sql = 'SELECT distinct concat(buildingName, userSubmitted) AS model FROM buildings';
        $result = mysql_query($sql, $con); 
        if(!$result) {
            die('Invalid query: '.mysql_error());
        }
        
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $output[$i] =  $row['model'];
            $i = $i+1;
        }
        
        // close database
        mysql_close($con);
        return $output;
    }

    // create a list of modelName, and feed back the client
    function listBuildingModel() {
        
        // link to html result table
        $A = queryBuildingModels();
        //href="'.$tablePath.'" target="_blank"
        
        echo '<ul>';
        for($j=count($A)-1; $j>count($A)-25; $j--) { 
            $tablePath = './Buildings/Output/'.$A[$j].'Table.html';
            echo '<li> <a style="text-decoration: none; color: black;" onmouseout=this.style.color="black" onmouseover=this.style.color="orange" href="#'.$A[$j].'" onclick="submitForm(\''.$A[$j].'\')">'.$A[$j].'</a>';
            
            // submenu in the list 
            //echo '<ul style="width: 100px; z-index=20;" >';
            //echo '<li><a style="text-decoration: none; color: black;" onmouseout=this.style.color="black" onmouseover=this.style.color="orange" onclick="submit('')"> option 1 </a></li>
            //<li><a style="text-decoration: none; color: black;" onmouseout=this.style.color="black" onmouseover=this.style.color="orange" href="#"> option 2 </a></li>';
            
          //  echo '</ul>';
            echo '</li>';
        }
        
        echo '</ul>';
    }
?>
