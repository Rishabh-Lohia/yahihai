<?php
	require_once 'includes/global.inc.php';
	//$current_page=$_SERVER['SCRIPT_NAME'];
	if(isset($_POST['username'])&&isset($_POST['password'])){
		$username=$_POST['username'];
		$password=$_POST['password'];
		$user_tools= new UserTools();
		$error='';
		if(!empty($username)&&!empty($password)){
			
			/*$query="SELECT id FROM users WHERE username='$username' AND password='$password'";
			if($query_run=@mysql_query($query)){
				$query_num_rows = mysql_num_rows($query_run);
				if($query_num_rows==0){
					echo 'Incorrect Username/password.';
				}
				else{
					$user_id=mysql_result($query_run,0,'id');
					$_SESSION['user_id']=$user_id;
					header('Location: index.php');
				}
			}*/
			if($user_tools->login($username,$password)){
				header("Location: index.php");
			}
			else
				$error='Incorrect username or password';
			
		}else
			$error="Please fill in all fields.";
	}	
?>
<html>
<head>
<title>Login Page</title>
</head>
<body>
<?php 
	if (@$error!=''){
		echo $error."<br>";
	}
?>
<form action='login.php' method='POST'>
Username: <br> <input type="text" name="username"><br>
Password: <br> <input type="password" name="password"><br><br>
<input type="submit" value="Log in">
</form>
<br />
New User? <a href="register.php" title="Register">Register</a><br>
<a href="mailto:rishabhlohia3105@gmail.com" title="Send a mail to support">Support</a>
</body>
</html>