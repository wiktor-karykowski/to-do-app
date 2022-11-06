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
	<title>Dodaj rzecz do zrobienia</title>
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
	<h2>Dodaj rzecz, którą chcesz zrobić.</h2>
		<form method="post" action="add.php">
			<input type="text" name="title" placeholder="Tytuł"><br>
			<textarea name="description" placeholder="Opis"></textarea><br>
			<label for="date">Kiedy?</label><br>
			<input type="date" name="date"><br>
			<label for="time">O której?</label><br>
			<input type="time" name="time"><br>
			<div class="buttons">
				<input type="submit" value="Zrobię!">
				<input type="reset" value="Anuluj">
			</div>
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
	if($que = @$conn->query("select id from users where login = '$user';")){
		if($que->num_rows>0){
			$row = $que->fetch_assoc();
			$id = $row['id'];
			$que->free_result();
		}
	}

	if(!empty($_POST['title']) && !empty($_POST['date']) && !empty($_POST['time'])){
		$title = $_POST['title'];
		$desc = $_POST['description'];
		$fromwhen = date('Y-m-d H:i');
		$towhen = $_POST['date'].' '.$_POST['time'];

		if($fromwhen < $towhen){
			if($que = @$conn->query("insert into things values (null,$id,'$title','$desc','$fromwhen','$towhen', 0, 1);")){
				header('Location: main.php');
			}
		}
		else{
			$_SESSION['error'] = 'Podaj prawidłową datę wykonania.';
			header('Location: add.php');
		}
	}
}

$conn->close();

?>



