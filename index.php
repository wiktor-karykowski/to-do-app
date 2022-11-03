<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
 	<title>Zaloguj się</title>
</head>
<body>
	<div class="logo logoIndex"><a href="index.php"><h1>To-Do App</h1></a></div>
	<div class="wrapper">
		<label for="icon">&#9776;</label>
		<input type="checkbox" id="icon">
		<label class="mini-logo"><a href="index.php">To-Do App</a></label>
	  	<div class="nav">
			<a href="login.php" class="tile tile1">Zaloguj się</a>
			<a href="signup.php" class="tile tile2">Zarejestruj się</a>
		</div>
	</div>
	<div class="content" id="content">
		<h2>Witaj w To-Do aplikacji.</h2><br>
		<span class="motd">Do tego momentu, zerejestrowało się<br>
			<b><?php countUsers(); ?></b><br>
			użytkowników.<br><br>
			Dodali oni aż<br>
			<b><?php countThings(); ?></b><br>
			rzeczy do zrobienia.<br><br>
			<h3>To jest wersja beta aplikacji. Wszelkiej maści usprawnienia oraz poprawki będą systematycznie wprowadzane w najbliższych dniach i tygodniach.</h3>
			<h4>Nie wykluczam także dodania nowych funkcjonalości.</h4>
			W razie jakichkolwiek problemów, w zakładce "Zgłoś błąd", uzyskasz kontakt w formie wiadomości prywatnej. Możesz także anonimowo (poprzez ticket) zgłosić to, co nie działa. Życzę ci miłego korzystania z aplikacji :)<br>
		</span>
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

function countUsers(){
	require 'dbconn.php';
	$conn = @new mysqli($dbhost,$dbuser,$dbpasswd,$db);

	if($conn->connect_errno!=0){
		echo 'Wystąpił nieoczekiwany błąd.';
	}
	else{
		if($que = @$conn->query("select count(*) from users;")){
			$row = $que->fetch_assoc();
			echo $row['count(*)'];
		}
	}
}

function countThings(){
	require 'dbconn.php';
	$conn = @new mysqli($dbhost,$dbuser,$dbpasswd,$db);

	if($conn->connect_errno!=0){
		echo 'Wystąpił nieoczekiwany błąd.';
	}
	else{
		if($que = @$conn->query("select count(*) from things;")){
			$row = $que->fetch_assoc();
			echo $row['count(*)'];
		}
	}
}
?>