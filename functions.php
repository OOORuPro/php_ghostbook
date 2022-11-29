<?php
	function db_connect($host, $user, $passwd, $dbname){
		$link = mysqli_connect($host, $user, $passwd,$dbname) or die("Прозошла ошибка подключения к базе данных!");
		mysqli_set_charset( $link, "utf8" ) or die ('Не удалось установить кодировку');
		return $link;
	}
	
	function db_query($query,$link){
		$result = mysqli_query($link,$query) or die ("Произошла ошибка при выполнение запроса");
		return $result;
	}
	
	function ghostbook_add($name,$email,$message,$error,$link){
		$error = [];
		if(empty($name)){
			$error['name'] = "Это обязательное поле";
		}
		elseif(empty($message)){
			$error['message'] = "Это обязательное поле";
		}
		elseif(empty($email)){
			$error['email'] = "Это не похоже на эл. почту.";
		}
		if(!$error){
		 $name = mysqli_real_escape_string($link,$name);
		 $message = nl2br(htmlspecialchars (mysqli_real_escape_string($link,$message)));
		 $email = mysqli_real_escape_string($link,$email);

		 db_query("INSERT INTO ghost_table (name,email,message,date) VALUES ('{$name}','{$email}','{$message}',".time().")",$link) or die("Ошибка INSERT INTO");
		 header('Location: ./?page=1');
		}else{
			print($error);
		}
		
	}
	
	function ghostbook_delete($id,$link){
		db_query("DELETE FROM ghost_table WHERE id = ".$id,$link);
		header("Location: ./?page=1");
	}
	
	function ghostbook_show($page,$link){
		$result = db_query("SELECT * FROM ghost_table",$link);
		return mysqli_fetch_all($result,MYSQLI_ASSOC);
	}