<?php

session_start();

require_once 'dbconn.php';
$conn = @new mysqli($dbhost,$dbuser,$dbpasswd,$db);

$id = $_SESSION['id'];
$passwd = sha1($_POST['passwd']);
if($conn->connect_errno!=0){
	echo 'Wystąpił nieoczekiwany błąd.';
}
else{
	if($que = @$conn->query("select password from users where id = $id;")){
		$row = $que->fetch_array();
		$que->free_result();
		if($passwd == $row['password']){
			if(@$conn->query("update users set is_active = 0 where id = $id;")){
				$_SESSION['mess'] = 'Usuwanie konta przebiegło pomyślnie.';
				header('Location: login.php');
			}
			else{
				$_SESSION['error'] = 'Coś poszło nie tak.';
				header('Location: account.php');
			}
		}
		else{
			$_SESSION['error'] = 'Coś poszło nie tak.';
			header('Location: account.php');
		}
	}
	else{
		$_SESSION['error'] = 'Coś poszło nie tak.';
		header('Location: account.php');
	}
}

$que->free_result();
?>

