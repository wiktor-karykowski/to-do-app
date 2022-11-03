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
	<title>Zgłoś błąd</title>
</head>
	<div class="logo"><a href="main.php"><h1>To-Do App</h1></a></div>
	<div class="user-welcome">Witaj, <?php echo $user; ?>!</div>
	<div class="user-logout"><a href="logout.php"><input type="submit" value="Wyloguj się"></a></div>
	<div class="wrapper">
		<label for="icon">&#9776;</label>
		<input type="checkbox" id="icon">
		<label class="mini-logo"><a href="main.php">To-Do App</a></label>
	  	<div class="nav">
			<a href="add.php" class="tile tile1">Dodaj rzecz do zrobienia</a>
			<a href="ticket.php" class="tile tile2">Zgłoś błąd</a>
			<a href="account.php" class="tile tile3">Ustawienia</a>
			<a href="logout.php" class="tile tile4" id="logout">Wyloguj się</a>
		</div>
	</div>
	<div class="content" id="content">
		<h2>Jeżeli coś nie działa, napisz o tym.</h2>
		<form method="post" action="ticket.php">
			<label for="message">Będę wdzięczny za każdą sugestię, lub zgłoszenie błędu :)</label><br>
			<textarea name="message"></textarea><br>
			<input type="submit" value="Wyślij"><br>
		</form>
		<!--<span class="mailto">
			<a mailto href="#">Możesz także napisać do mnie w wiadomości <b>e-mail.</b></a>
		</span>-->
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
	if(!empty($_POST['message'])){
		$message = $_POST['message'];
		$datetime = date('Y-m-d H:i');
	
		if($que = @$conn->query("insert into tickets values (null,'$id','$datetime','$message');")){
			$_SESSION['mess'] = 'Dziękuję za pomoc!!! :)';
			header('Location: ticket.php');
		}	
	}

}

?>
