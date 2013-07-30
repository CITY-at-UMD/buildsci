<?php

// Server, database name, sqluserid, and sqlpassword
// Change to your own server, database, id and password
$hostName = "localhost";
$databaseName = "rmt";
$sqlusername = "root";
$sqlpassword = "srebric10-11";

//function to authenticate user, and return TRUE or FALSE 
function authenticateUser($connection, $username, $password)
{
  // User table which stores userid and password
  // Change to your own table name 
  $userTable = "auth_users"; 

  // Test the username and password parameters
  if (!isset($username) || !isset($password))
    return false;

  $pa = md5($password);  
  
  echo '$pa='.$pa;
  // Formulate the SQL statment to find the user
  $query = "SELECT * 
             FROM $userTable 
             WHERE userid = '{$username}' AND password = '{$pa}'";
  //echo $query;
  // Execute the query
  $result = mysql_query ($query, $connection)
    or die("Error: wrong query");

  // exactly one row? then we have found the user
  if (mysql_num_rows($result) != 1)
    return false;
  else
    return true;
}

?>
