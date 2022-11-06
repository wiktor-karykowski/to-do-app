<?php 

session_start();
$user = $_SESSION['user'];
$id = $_SESSION['id'];

if(!isset($_SESSION['user'])){
	session_destroy();
	header('Location: login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Ustawienia</title>
</head>
<body>
	<div class="logo"><a href="main.php"><h1>To-Do App</h1></a></div>
	<div class="user-welcome">Witaj, <?php echo $user; ?>!</div>
	<div class="user-logout"><a href="logout.php"><input type="submit" value="Wyloguj się"></a></div>
	<div class="wrapper">
		<label for="icon">&#9776;</label>
		<input type="checkbox" id="icon">
		<label class="mini-logo"><a href="main.php">To-Do App</a></label>
	  	<div class="nav">
	  		<a href="main.php" class="tile tile1">Strona główna</a>
			<a href="add.php" class="tile tile2">Dodaj rzecz do zrobienia</a>
			<a href="ticket.php" class="tile tile3">Zgłoś błąd</a>
			<a href="account.php" class="tile tile4">Ustawienia</a>
			<a href="logout.php" class="tile tile5" id="logout">Wyloguj się</a>
		</div>
	</div>
	<div class="content" id="content">
		<h2>Zmiana hasła.</h2>
		<form method="post" action="account.php">
			<input type="password" name="oldpasswd" placeholder="Obecne hasło:"><br>
			<input type="password" name="newpasswd" placeholder="Nowe hasło:"><br>
			<input type="password" name="repnewpasswd" placeholder="Potwierdź nowe hasło:"><br>
			<input type="submit" value="Zmieniam!"><br>
		</form>
		<h2>Usuwanie konta.</h2>
		<form method="post" action="sayonara.php">
			<input type="password" name="passwd" placeholder="Podaj hasło."><br>
			<input type="submit" value="Usuń konto"><br>
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
	<script type="text/javascript" src="hideContent.js"></script>
</body>
</html>

<?php

require_once 'dbconn.php';
$conn = @new mysqli($dbhost,$dbuser,$dbpasswd,$db);

if($conn->connect_errno!=0){
	echo 'Wystąpił nieoczekiwany błąd.';
}
else{
	if($que = @$conn->query("select * from users where id = $id;")){
		if(!empty($_POST['oldpasswd']) && !empty($_POST['newpasswd']) && !empty($_POST['repnewpasswd'])){
			$row = $que->fetch_assoc();
			$passwd = $row['password'];
			$que->free_result();
			$oldpasswd = sha1($_POST['oldpasswd']);
			$newpasswd = sha1($_POST['newpasswd']);
			$repnewpasswd = sha1($_POST['repnewpasswd']);

			if($oldpasswd == $newpasswd){
				$_SESSION['error'] = 'Nie można zmienić hasła na takie samo hasło!';
				header('Location: account.php');
			}

			if($passwd == $oldpasswd){
				if($newpasswd == $repnewpasswd){
					if($que = @$conn->query("update users set password = '$newpasswd' where id = $id")){
						$_SESSION['mess'] = 'Hasło zostało pomyślnie zmienione.';
						header('Location: account.php');
					}
				}
				else{
					$_SESSION['error'] = 'Hasła nie zgadzają się.';
					header('Location: account.php');
				}
			}
			else{
				$_SESSION['error'] = 'Stare hasło nie zgadza się.';
				header('Location: account.php');
			}
		}
	}
}

?>