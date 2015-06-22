<?php
	//require 'core.inc.php';
	//require 'conn.inc.php';
	require_once 'includes/global.inc.php';
	if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password_ver'])){
		$username=$_POST['username'];
		$password=$_POST['password'];
		$password_ver=$_POST['password_ver'];
		
		$success = true;
		$userTools= new UserTools();
		
		if(!empty($username)&&!empty($password)&&!empty($password_ver)){
			if(strlen($username)<=30){
				if($password==$password_ver){
					if($userTools->checkUserNameExists($username)){
						$success=false;
						$error='Username already exists.';
					}
					
				}else{
					$error='Passwords did not match.';
					$success= false;
				}
			}else{
				$error='Please adhere to maximum length of each field.';
				$success = false;	
			}
		}else{
			$error= 'Please fill in all fields.';
			$success=false;
		}
		
		if($success){
			$_POST['user_role'];
			$data['username']= $username;
			$data['password']= $password;
			switch($_POST['user_role']){
				case 'manager':
					$data['user_role']=1;
				break;
				
				case 'hod':
					$data['user_role']=2;
				break;
				
				case 'worker':
					$data['user_role']=3;
				break;
				
				case 'admin':
					$data['user_role']=4;
				break;
			}
			$newUser = new User($data);
			$newUser->save(true);
			
			$userTools->login($username, $password);
			header("Location: index.php");
		}else{
			echo $error."<br>";
		}
	}

?>
<html>
<head>
<title>Registration</title>
</head>
<body>
<form action="register.php" method='POST'>
Username: <br><input type="text" name="username" maxlength="30" value="<?php if(isset($username)){echo $username;}?>"><br>
Password: <br><input type="password" name= "password"><br>
Retype Password: <br><input type="password" name="password_ver"><br><br>

<select name="user_role">
<option value="admin">Admin</option>
<option value="hod">HOD</option>
<option value="manager">Manager</option>
<option value="worker">Worker</option>
</select>
<br><br>
<input type="Submit" value="Register">
</form></body>
</html>