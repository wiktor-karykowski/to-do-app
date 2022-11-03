<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="login_signup.css">
	<title>Zarejestruj się</title>
</head>
<body>
	<div class="logo logoIndex"><a href="index.php"><h1>To-Do App</h1></a></div>
	<div class="content">
		<form method="post" action="signup.php">
			<input type="text" name="name" maxlenght="31" placeholder="Imię *"><br>
			<input type="text" name="surname" maxlenght="255" placeholder="Nazwisko *"><br>
			<input type="text" name="login" maxlenght="31" placeholder="Login *"><br>
			<input type="password" name="password" maxlenght="255" placeholder="Hasło *"><br>
			<input type="password" name="repeatPassword" maxlenght="255" placeholder="Powtórz hasło *"><br>
			<input type="tel" name="phonenum" maxlenght="15" placeholder="Numer telefonu"><br>
			<input type="mail" name="emailaddr" maxlenght="255" placeholder="Adres e-mail"><br>
			<input type="submit" class="button submit" value="Zarejestruj"><br>
			<a href="login.php" style="color: #000;"><b>Powrót do ekranu logowania.</b></a>
			<p><i>* - pola wymagane.</i></p>
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
	if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['repeatPassword'])){
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$login = $_POST['login'];
		$paswd = $_POST['password'];
		$rpswd = $_POST['repeatPassword'];
		$signdate = date('Y-m-d H:i');
		$phonenum = $_POST['phonenum'];
		$emailaddr = $_POST['emailaddr'];

		$que = $conn->query("select * from users where login = '$login';"); 

		if($que->num_rows==0){
			if($paswd!=$rpswd){
				$_SESSION['error'] = 'Hasła nie zgadzają się.';
				header('Location: signup.php');
			}
			else{
				$password = sha1($paswd);
				$que->free_result();
				$que = $conn->query("insert into users values (null, '$name', '$surname', '$login', '$password', '$signdate', '$phonenum', '$emailaddr', 1);");
				$_SESSION['mess'] = 'Rejestracja przebiegła pomyślnie.';
				header('Location: login.php');
			}
		}
		else{
			$_SESSION['error'] = 'Podany login istnieje w bazie.';
			header('Location: signup.php');
		}
	}
	
	$conn->close();
}
?>

