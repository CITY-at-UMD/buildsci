<?php

// Server, database name, sqluserid, and sqlpassword
// Change to your own server, database, id and password
$hostName = "updb1";
$databaseName = "YourDatabaseName";
$sqlusername = "YourSQLUserName";
$sqlpassword = "YourSQLPassword";

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
  // Formulate the SQL statment to find the user
  $query = "SELECT * 
             FROM $userTable 
             WHERE userid COLLATE Latin1_General_CS_AS = '{$username}' AND password COLLATE Latin1_General_CS_AS = '{$pa}'";
  echo $query;
  // Execute the query
  $result = mssql_query ($query, $connection)
    or die("Error: wrong query");

  // exactly one row? then we have found the user
  if (mssql_num_rows($result) != 1)
    return false;
  else
    return true;
}

?>
