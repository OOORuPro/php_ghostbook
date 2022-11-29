<?php
	require "config.php";
	require "functions.php";
	print("<h1>Hello world!</h1>");
	//DBHOST,DBUSER,DBPASSWD,DBNAME

	$former = "";
	$page=1;
	$db = db_connect(DBHOST,DBUSER,DBPASSWD,DBNAME);
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	if($_GET['action']=="add"){
		ghostbook_add($name,$email,$message,$former,$db);
	}elseif($_GET['action']=="delete" && isset($_GET['id'])){
		ghostbook_delete($_GET['id'],$db);
	}
	$row = ghostbook_show($page,$db);
	
	var_dump($row );
	print("</br></br></br>");
	print_r($row);
	
	?>
	