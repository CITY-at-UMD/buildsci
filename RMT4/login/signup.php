<?php
//include database information and user information
require 'authentication.inc';
session_start();

$errorMessage = '';

// Check if the user already login
if (isset($_SESSION['db_is_logged_in']))
{
    //logged in, display appropriate information
     echo "Hello ",$_SESSION['userID'], "!";
     header('Location: main.php');
}

if(($_POST['txtPassword'] == '' || $_POST['retxtPassword'] =='')&&$_POST['txtUserId'] != '') {
	$errorMessage="Error: Please Create Your Passwords";
}

// If not login, Check user's input informaiton
// The new user id, password and repeated are required
if (isset($_POST['txtUserId']) && isset($_POST['txtPassword']) &&
    isset($_POST['retxtPassword']) && $_POST['txtPassword'] != '' && $_POST['retxtPassword'] !='') {

    //the required information
    $loginUserId = $_POST['txtUserId'];				
    $loginPassword = $_POST['txtPassword'];
    $reLoginPassword = $_POST['retxtPassword'];

	//the persional information
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    
    if ($loginPassword == $reLoginPassword) {
		
		// connect to the bitnami database
		$connection = mysql_connect("$hostName", "$sqlusername", "$sqlpassword")
			or die("ERROR: selecting database server failed");

		mysql_select_db($databaseName, $connection)
			or die( "ERROR: Selecting database failed");
		
		// table auth_users contains all login user information
		$userTable = "auth_users"; 

#===============================================================================================
		// check if the user already exisit in the database
	    $query = "SELECT * 
			      FROM $userTable 
			      WHERE userid = '$loginUserId'";

	  // Execute the query
	  $result = mysql_query ($query, $connection)
		or die("Error: wrong query");

	  // Check if the user is already exisit or not
	  if (mysql_num_rows($result) >= 1) {
		$errorMessage = "Sorry, The user ID has been taken. Please try again.";
	  }
#===============================================================================================
		else {
			// md5 encoder encodes the input password
			$ps = md5($loginPassword);

			// Formulate the SQL statment to find the user
			$query = "INSERT INTO $userTable VALUES ('$loginUserId', '$ps')";

			// Execute the query
			$result = mysql_query ($query, $connection)
				or die("Error: $errorMessage");


			//table for user profile
			$userTable = "userprofile"; 

			// Formulate the SQL statment to find the user
			$query = "INSERT INTO $userTable VALUES ('$loginUserId', '$firstName','$lastName', '$email')";

			// Execute the query
			$result = mysql_query ($query, $connection);
		
			echo "<script> alert('Congradulation! Welcome to RMT...'); </script>";

			// Go to the login page
			header('Refresh: 1; url=./index.php');
			exit;
		}
    } else {
	   $errorMessage = "Error: Passwords do not match";
    }
}
?>

<html>
<head>
<meta charset="utf-8">
<title>RMT 4: Sign Up Page</title>

<link href="../css/demo.css" rel="stylesheet">
<LINK REL="SHORTCUT ICON" HREF="../img/eebhub" />

<style>

.sign-up-section {
    background-color: #eee;
    position: static;
	width: 50%;
    margin: 15% auto;
    border: solid thin #888;
    padding: 30px;
    color: #333333;
    font-family: Georgia, Serif;
}
footer{
	position: fixed;
}

.policy-link{
	font-size: 12px;
	text-decoration: none;
	color: #333;
	margin-right: 10px;
}

.policy-link:hover{
	text-decoration: underline;
}

</style>
    
</head>

<body>
<div style="color: #eee; position: absolute; height: 80px; width: 100%; background: #999; top: 0; left: 0;">
	<h1 style="margin-left: 50px"> <a style="text-decoration: none; color: #eee" href="../index.php"> Welcome to RMT </a></h1>
</div>

<div class="main-div">
<div class="sign-up-section">
   	<p align="right"> I have an <a href="./index.php"> account </a> already </p>
    <form action="" method="post" name="frmLogin" id="frmLogin">
     <table width="400" border="0" align="center" cellpadding="2" cellspacing="2">
		
	  <tr> 
       	<td colspan="2"> 
			<h3>Required Field </h3> 
		</td>
      </tr>
      <tr>
       <td width="200">Select User ID *</td>
       <td><input name="txtUserId" type="text" id="txtUserId"></td>
      </tr>
      <tr>
       <td width="200">Type Password *</td>
       <td><input name="txtPassword" type="password" id="txtPassword"></td>
      </tr>
      <tr>
       <td width="200">Retype Password *</td>
       <td><input name="retxtPassword" type="password" id="retxtPassword"></td>
      </tr>
      <tr>
       <td colspan="2"><p align="right" style="color: red;"> <Strong> <?php echo $errorMessage ?> </Strong> </p></td>
      </tr>
      <tr>
       <td ></td>
      </tr>
      <tr>
		<td colspan="2"> </td>
	  </tr>
      <tr>
       <td colspan="2"><h3>Personal Information (Optional)</h3></td>
      </tr>
      <tr>
       <td width="200">First Name</td>
       <td><input name="firstName" type="text" id="firstName"></td>
      </tr>
      <tr>
    
      <tr>
       <td width="200">Last Name</td>
       <td><input name="lastName" type="text" id="lastName"></td>
      </tr>
      <tr>
      <tr>
       <td width="200">Email Address</td>
       <td><input name="email" type="email" id="email"></td>
      </tr>
      <tr>
      <tr>
       <td ></td>
      </tr>
      <tr>
       <td ></td>
      </tr>
      <tr>
       <td width="200">&nbsp;</td>
       <td><input class="button" name="btnLogin" type="submit" id="btnLogin" value="SIGN UP"></td>
      </tr>
     </table>
    </form>
</div>
	<p style="text-align: center">
		<a class="policy-link" href="../index.php"> &copy; 2013, RMT </a>
		<a class="policy-link" href="#"> Term of Service </a>
		<a class="policy-link" href="../#"> Privacy Policy </a>
		<a class="policy-link" href="../index.php"> Help </a>
	</p>
</div>

</body>
</html>
