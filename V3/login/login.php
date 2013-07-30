<?php

//include database information and user information
require 'authentication.inc';

//never forget to start the session
session_start();
$errorMessage = '';

//are user ID and Password provided?
if (isset($_POST['txtUserId']) && isset($_POST['txtPassword'])) {

    //get userID and Password
    $loginUserId = $_POST['txtUserId'];
    $loginPassword = $_POST['txtPassword'];
    
    //connect to the database
    $connection = mssql_connect("$hostName", "$sqlusername", "$sqlpassword")
	or die("ERROR: selecting database server failed");

    //choose the database
    mssql_select_db($databaseName, $connection)
	or die( "ERROR: Selecting database failed");	
    
    // Authenticate the user
    if (authenticateUser($connection, $loginUserId, $loginPassword))
	{
	    //the user id and password match,
	    // set the session	
	    $_SESSION['db_is_logged_in'] = true;
	    $_SESSION['userID'] = $loginUserId;
	    
	    // after login we move to the main page
	    header('Location: main.php');
	    exit;
	} else {
	$errorMessage = 'Sorry, wrong username / password';
    }
}
?>

<html>
<head>
<title>Basic Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<Strong> <?php echo $errorMessage ?> </Strong>
If you don't have an account, please <a href="signup.php">sign up</a>.
<form action="" method="post" name="frmLogin" id="frmLogin">
 <table width="400" border="1" align="center" cellpadding="2" cellspacing="2">
  <tr>
   <td width="150">User ID</td>
   <td><input name="txtUserId" type="text" id="txtUserId"></td>
  </tr>
  <tr>
   <td width="150">Password</td>
   <td><input name="txtPassword" type="password" id="txtPassword"></td>
  </tr>
  <tr>
   <td width="150">&nbsp;</td>
   <td><input name="btnLogin" type="submit" id="btnLogin" value="Login"></td>
  </tr>
 </table>
</form>
</body>
</html>
