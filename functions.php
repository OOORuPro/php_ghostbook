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