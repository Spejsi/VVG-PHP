<?php 
session_start();

if(isset($_GET['command'])) { $cmd = (int)$_GET['command']; }

if ($cmd == 1){
	unset($_SESSION['anamUser']);
	unset($_SESSION['articleId']);
	header("Location: index.php?menu=1");
}

if ($cmd == 2){
	if(isset($_GET['articleId'])) { $aid = (int)$_GET['articleId']; }
	$_SESSION['articleId'] = $aid;
	
	header("Location: index.php?menu=12");
}

?>