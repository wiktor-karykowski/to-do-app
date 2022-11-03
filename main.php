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
	<title>To-Do</title>
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
			<a href="add.php" class="tile tile1">Dodaj rzecz do zrobienia</a>
			<a href="ticket.php" class="tile tile2">Zgłoś błąd</a>
			<a href="account.php" class="tile tile3">Ustawienia</a>
			<a href="logout.php" class="tile tile4" id="logout">Wyloguj się</a>
		</div>
	</div>
	<div class="content" id="content">
		<h2>Twoje rzeczy do zrobienia:</h2>
		<?php show() ?>
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

function show(){
	require 'dbconn.php';
	$conn = @new mysqli($dbhost,$dbuser,$dbpasswd,$db);
	$id = $GLOBALS['id'];
	$user = $GLOBALS['user'];
	if($conn->connect_errno!=0){
		echo 'Wystąpił nieoczekiwany błąd.';
	}
	else{
		if($que = @$conn->query("select id from users where login = '$user';")){
			if($que->num_rows>0){
				$row = $que->fetch_assoc();
				$id = $row['id'];
				$que->free_result();
			}
		}
	}
	if($que = @$conn->query("select id, thing_title, thing_description, DATE_FORMAT(from_when,'%Y-%m-%d %H:%i') as from_when, DATE_FORMAT(to_when,'%Y-%m-%d %H:%i') as to_when, is_done from things where userid = $id and is_active = 1 order by to_when asc;")){
		if($que->num_rows>0){
			while($row = $que->fetch_assoc()){
				$thingId = $row['id'];
				$is_done = $row['is_done'];
				
				$thinkSimple = 'thing'.$thingId;
				
				$dateTime = date('Y-m-d H:i');
				$to_when = $row['to_when'];

				if($dateTime>$to_when){
					$styleBlock = "
						<style type='text/css'>
							.content .$thinkSimple{
								border-bottom: 2px solid red;
							}
						</style>
					";
					echo $styleBlock;
				}
				
				if($is_done == 1){
					$styleBlock = "
						<style type='text/css'>
							.content .$thinkSimple{
								border-bottom: 2px solid green;
							}
						</style>
					";
					echo $styleBlock;
				}

				echo'
					<div class="thing thing',$thingId,'">
						<h3>',$row['thing_title'],'</h3>
						<p>',$row['thing_description'],'</p>
						<label>Utworzono: ',$row['from_when'],'</label><br>
						<label>Do wykonania: ',$row['to_when'],'</label>		
						<div class="buttons">
							<form method="post" action="delete.php">
								<input type="submit" value="Usuń">
								<input type="hidden" name="thingId" value=',$thingId,'>
							</form>
								<form method="post" action="done.php">
								<input type="submit" value="Zrobione" onClick="done()">
								<input type="hidden" name="thingId" value=',$thingId,'>
							</form>
						</div>
					</div>
				';
			}
		}
		else{
			echo 'Niczego jeszcze nie zaplanowałeś.';
		}
		$que->free_result();	
	}	
	$conn->close();
}

?>
