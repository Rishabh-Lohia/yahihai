<?php
	//require 'core.inc.php';
	//require 'conn.inc.php';
	require_once 'includes/global.inc.php';
	
	if(!isset($_SESSION["logged_in"])){
		header("Location: login.php");
	}
	
	$user = unserialize($_SESSION['user']);
?>

<html>
<head>
<title>Welcome <?php echo $user->username; ?></title>
</head>
<body>
Hello, <?php echo $user->username; ?>. You are logged in and registered.<br>
<?php
/*echo "GD: "; 
if(extension_loaded('gd'))
	echo 'OK'."<br>";
else
	echo 'MISSING'. "<br>";
echo "XML: "; 
if(extension_loaded('xml'))
	echo 'OK'."<br>";
else
	echo 'MISSING'. "<br>";
echo "zip: "; 
if(extension_loaded('zip'))
	echo 'OK'."<br>";
else
	echo 'MISSING'. "<br>";
echo "xmlwriter: "; 
if(extension_loaded('xmlwriter'))
	echo 'OK'."<br>";
else
	echo 'MISSING'. "<br>";*/
?>
<a href="logout.php">Log out</a>
</body>
</html>