<?php

require_once 'dbconn.php';
$conn = @new mysqli($dbhost,$dbuser,$dbpasswd,$db);

$thingId = $_POST['thingId'];
if($conn->connect_errno!=0){
	echo 'Wystąpił nieoczekiwany błąd.';
}
else{
	if($que = @$conn->query("update things set is_done = 1 where id = '$thingId';")){
	}
}

header('Location: main.php');

?>