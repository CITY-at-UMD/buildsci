<?php

//include database information and user information
require 'authentication.inc';

//never forget to start the session
session_start();
$errorMessage = 'Create a user account';

//are user ID and Password provided?
if (isset($_POST['txtUserId']) && isset($_POST['txtPassword']) &&
    isset($_POST['retxtPassword'])) {

    //get userID and Password
    $loginUserId = $_POST['txtUserId'];
    $loginPassword = $_POST['txtPassword'];
    $reLoginPassword = $_POST['retxtPassword'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    
    if ($loginPassword == $reLoginPassword) {
    
	//connect to the database
	$connection = mssql_connect("$hostName", "$sqlusername", "$sqlpassword")
	    or die("ERROR: selecting database server failed");

	//choose the database
     echo $databaseName;
	mssql_select_db($databaseName, $connection)
	    or die( "ERROR: Selecting database failed");	
    
	//table to store username and password
	$userTable = "auth_users"; 

	$ps = md5($loginPassword);
	// Formulate the SQL statment to find the user
	$query = "INSERT INTO $userTable VALUES ('$loginUserId', '$ps')";
	// Execute the query
	$result = mssql_query ($query, $connection)
	    or die("Error: wrong query");


	//table for user profile
	$userTable = "userprofile"; 

	// Formulate the SQL statment to find the user
	$query = "INSERT INTO $userTable VALUES ('$loginUserId', '$firstName','$lastName', '$email')";

	// Execute the query
	$result = mssql_query ($query, $connection)
	    or die("Error: wrong query");

	// Go to the login page
	header('Location: login.php');
	exit;
    } else {
	$errorMessage = "Passwords do not match";
    }
}
?>

<html>
<head>
<title>Sign-in</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<Strong> <?php echo $errorMessage ?> </Strong>

<form action="" method="post" name="frmLogin" id="frmLogin">
 <table width="400" border="1" align="center" cellpadding="2" cellspacing="2">
  <tr>
   <td width="150">Select User ID *</td>
   <td><input name="txtUserId" type="text" id="txtUserId"></td>
  </tr>
  <tr>
   <td width="150">Type Password *</td>
   <td><input name="txtPassword" type="password" id="txtPassword"></td>
  </tr>
  <tr>
   <td width="150">Retype Password *</td>
   <td><input name="retxtPassword" type="password" id="retxtPassword"></td>
  </tr>
  <tr>
   <td ></td>
  </tr>
  <tr>
   <td ></td>
  </tr>

  <tr>
   <td >Personal Information</td>
  </tr>
  <tr>
   <td width="150">First Name</td>
   <td><input name="firstName" type="text" id="firstName"></td>
  </tr>
  <tr>

  <tr>
   <td width="150">Last Name</td>
   <td><input name="lastName" type="text" id="lastName"></td>
  </tr>
  <tr>
  <tr>
   <td width="150">Email Address</td>
   <td><input name="email" type="text" id="email"></td>
  </tr>
  <tr>
  <tr>
   <td ></td>
  </tr>
  <tr>
   <td ></td>
  </tr>
  <tr>
   <td width="150">&nbsp;</td>
   <td><input name="btnLogin" type="submit" id="btnLogin" value="Sign In"></td>
  </tr>
 </table>
</form>
</body>
</html>
