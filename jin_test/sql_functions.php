<?php
    
    function display_results($search_key) {
        
        $username='hackathon';
        $password='hackathon';
        $database='hackathon';
        $localhost='localhost';
        
        // connect to database
        $con = mysql_connect($localhost, $username, $password);
        if(!$con) {
            die('could not connect: '.mysql_error());
        }
        
        // select database
        mysql_select_db($database, $con); 
        
        
        // type in specific sql stament
        $sql = "select distinct concat(buildingName, userSubmitted) as modelname, L.city, L.state, L.weatherFile, F.functionType, R.name as roofMaterial, W.name as wallMaterial, floors, floorArea, windowPercent 
                from buildings B, locations L, roofmaterials R, wallmaterials W, functions F
                where concat(buildingName, userSubmitted) like '%".$search_key."%' and B.functionID = F.functionID and B.locationID = L.locationID and W.wallMatID = 1 and R.roofMatID = 1;";
        
        // execute and check the sql query on the database 
        $result = mysql_query($sql, $con); 
        if(!$result) {
            die('Invalid query: '.mysql_error());
        }
        
      
        echo '<table width="814" height="246" border="0" style="padding: 20px; position: relative; top: 0; left:25%; border: medium lightblue solid; border-radius: 25px;">';
       
       
        echo '<tr>
                <td height="69" colspan="2"><h1>Are you looking for:</h1><hr /></td>
              </tr>';
        
        $count = 0;
        if($search_key != '') {
            while ($row = mysql_fetch_assoc($result)) { 
             echo     '<tr>
                        <td><div align="right"><strong>Simulated Result (.html):</strong></div></td>
                        <td><div align="justify"><em><a href="#"> '.$row['modelname'].'Table.html </a></em></div></td>
                      </tr>
      <tr>
        <td width="204"><div align="right"><strong>Building (.idf):</strong></div></td>
                        <td width="592"> <div align="justify"><em><a href="#"> '.$row['modelname'].'.idf </a> </em></div></td>
      </tr>
      <tr>
        <td><div align="right"><strong>Weather (.epw):</strong></div></td>
                        <td> <div align="justify"><em><a href="#"> '.$row['weatherFile'].'.epw </a> </em></div></td>
      </tr>
                      <tr>
                        <td><div align="right"><strong>Created Date:</strong></div></td>
                        <td><div align="justify"><em>not yet support</em></div></td>
                      </tr>
      <tr>
        <td><div align="right"><strong>By Author:</strong></div></td>
                        <td> <div align="justify"><em>not yet support </em></div></td>
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
                      </tr>
                      <tr>
                        <td><div align="right"><strong>Window Percentage:</strong></div></td>
                        <td><div align="justify"><em>'.$row['windowPercent'].'%</em></div></td>
                      </tr>
                      <tr>
                        <td><div align="right"></div></td>
                        <td><div align="justify"><em></em></div></td>
                      </tr>
                      <tr>
                        <td><div align="right"><strong>End Use Energy Summary:</strong></div></td>
                        <td><div align="justify"><em>not yet support</em></div></td>
                      </tr>
                      <tr>
                        <td><div align="right"><strong>Gas / Natural Gas:</strong></div></td>
                        <td><div align="justify"><em>not yet support</em></div></td>
                      </tr>
                      <tr>
                        <td><div align="right"><strong>Eletricity:</strong></div></td>
                        <td><div align="justify"><em>not yet support</em></div></td>
                      </tr>
                      <tr>
                        <td>&nbsp; <hr /></td>
                        <td>&nbsp;<hr /></td>
                      </tr>';
                      $count=$count+1;
            }
        
        
            if($count<1) {
                echo '<tr>
                        <td style="color:red;" align="middle" height="69" colspan="2"> <h3>Sorry, we can\'t found any matched model in your search. </h3></td>
                      </tr>';
            } else {
                       echo '<tr>
                        <td style="color:red;" align="middle" height="69" colspan="2"> <h3>We found '.$count.' matched model(s) for you. </h3></td>
                      </tr>'; 
            }
        }
        echo '</table>';
        
        // close database
        mysql_close($con);
    }
   
   //display_results();

?>
