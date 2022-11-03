<?php 

session_start(); 

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="login_signup.css">
 	<title>Zaloguj się</title>
</head>
<body>
	<div class="logo logoIndex"><a href="index.php"><h1>To-Do App</h1></a></div>
	<div class="content">
		<form method="post" action="login.php">
			<input type="text" name="login" min-lenght="4" max-lenght="31" placeholder="Login"><br>
			<input type="password" name="password" max-lenght="6" max-lenght="255" placeholder="Hasło"><br>
			<input type="submit" class="button submit" value="Zaloguj"><br>
			<p>Nie masz konta?</p>
			<a href="signup.php" style="color: #000;"><b>Zarejestruj się.</b></a></p>
		</form>
		<div class="message-box">
			<?php
				if(isset($_SESSION['error'])){
					echo '<span class="error"><b>',$_SESSION['error'],'</b></span>';
				}
				else if(isset($_SESSION['mess'])){
					echo '<span class="mess"><b>',$_SESSION['mess'],'</b></span>';
				}
				unset($_SESSION['error']);
				unset($_SESSION['mess']);
			?>
		</div>	
	</div>
</body>
</html>

<?php

require_once 'dbconn.php';
$conn = @new mysqli($dbhost,$dbuser,$dbpasswd,$db);

if($conn->connect_errno!=0){
	echo 'Wystąpił nieoczekiwany błąd.';
}
else{
	if(!empty($_POST['login']) && !empty($_POST['password'])){
		$login = $_POST['login'];
		$password = sha1($_POST['password']);
		unset($_SESSION['blad']);
		if($que = @$conn->query("select * from users where login = '$login' and password = '$password' and is_active = 1;")){
			if($que->num_rows>0){
				$row = $que->fetch_assoc();
				$_SESSION['user'] = $row['login'];
				$_SESSION['id'] = $row['id'];
				$que->free_result();
				header('Location: main.php');
			}	
			else{
				$_SESSION['error'] = 'Błędny login lub hasło.';
				header('Location: login.php');
			}
		}
		else{
			$_SESSION['error'] = 'Podane istniało już kiedyś w bazie.';
			header('Location: login.php');
		}		
	}
	$conn->close();
}

?>

