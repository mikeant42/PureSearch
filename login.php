<?php
include 'pdo_connect.php';
session_start();

$_SESSION['loggedin'] = false;
if (isset($_POST['log-in'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['pass']);
	if (empty($username) || empty($password)) {
		echo "Please enter a username or password.";
	} else {
		$password = bcrypt_password($password);
		$sql = "SELECT * FROM searchusers WHERE username = :username AND password = :password";
		$db = get_database();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':username', $username, PDO::PARAM_STR, 12);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR, 150);
		$stmt->execute();
		$stmt->fetchAll();
		if ($stmt->rowCount() >= 1) {
			$_SESSION['loggedin'] = true;
			echo "<script>document.location = 'control-panel.php'</script>";
		} else {
			echo 'invalid username or password';
		}
		
		
		
	}
}

/*
* Hashes and salts string into a one way aglorithim. Uses
* the "whirlpool" and "bcrypt" aglorithims to encrypt
* the string and the salt.
*
* @param $str The string to be encrypted
* @param $salt The salt to salt the string with
* @return $str The new, encrypted string.
*/
function bcrypt_password($str) {
	$str = crypt($str, '2piur;A?');
	$salt = 'e8b27v9ud4r9iio401l'.substr(hash('gost',$str),0,22);
	$second_salt = hash('whirlpool', $str);
	$second_salt = substr($second_salt, 0, 10);
	$first400 = substr($str, 0, 400);
	$theRest = substr($str, 400);
	$str = substr($second_salt, 0,4) . $first400 . $salt . $theRest;
	return $str;
}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Admin Log In</title>
	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta charset='utf-8'> 
	
	<link rel="stylesheet" type="Text/css" href="style.css" />
	<link rel="icon" href="purelogo.png" type="image/x-icon">	
</head>

<body>

<form action="" method="POST" style="padding: 8px;">
	<input type="text" name="username" class="text-input" placeholder="username" autocomplete="off" /> <br>
	<input type="password" name="pass" class="text-input" placeholder="password" />
	<br>
	<input type="submit" value="Log in" name="log-in" style="margin-left: 11%;" />
</form>

</body>

</html>