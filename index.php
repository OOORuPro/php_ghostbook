<?php
	require "config.php";
	print("<h1>Hello world!</h1>");
	//DBHOST,DBUSER,DBPASSWD,DBNAME
	function db_connect($host, $user, $passwd, $dbname){
		$link = mysqli_connect($host, $user, $passwd,$dbname) or die("Прозошла ошибка подключения к базе данных!");
		mysqli_set_charset( $link, "utf8" ) or die ('Не удалось установить кодировку');
		return $link;
	}
	
	function db_query($query,$link){
		$result = mysqli_query($link,$query) or die ("Произошла ошибка при выполнение запроса");
		return $result;
	}
	
	function db_query_ex($query,$link){
		$values = func_get_args();
		array_shift($values);
		$i = 0;
		$var_dump($query);
		return db_query($query,$link);
	}
	
	function ghostbook_add($name,$email,$message,$error,$link){
		$error = '';
		if(empty($name)){
			$error['name'] - "Это обязательное поле";
		}
		elseif(empty($message)){
			$error['message'] - "Это обязательное поле";
		}
		elseif(empty($email) && !strings_isemail($email)){
			$error['email'] - "Это не похоже на эл. почту.";
		}
		if(!error){
		 $name = mysqli_real_escape_string(strings_clear($name));
		 $message = nl2br(htmlspecialchars (mysqli_real_escape_string(strings_clear($message))));
		 $email = mysqli_real_escape_string($email);
		 
		 db_query_ex('INSERT INTO ghost_table (name,email,message,datetime) VALUES('.$name.','.$email.','.$message.','.NOW().')',$link);
		 header('Location: ./?page=1');
		}
		
	}
	
	function ghostbook_delete($id,$link){
		db_query_ex("DELETE FROM ghost_table WHERE id = ".$id,$link);
		header("Location: ./?page=1");
	}
	
	function ghostbook_show($page,$link){
		$result = db_query("SELECT * FROM ghost_table",$link);
		return mysqli_fetch_all($result,MYSQLI_ASSOC);
	}
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
	