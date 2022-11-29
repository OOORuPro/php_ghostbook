<?php
	require "config.php";
	print("<h1>Hello world!</h1>");
	//DBHOST,DBUSER,DBPASSWD,DBNAME
	function db_connect($host, $user, $passwd, $dbname){
		$link = mysql_pconnect($host, $user, $passwd) or die("Прозошла ошибка подключения к базе данных!");
		mysql_select_db($dbname) or die("Произошла ошибка работы с таблицой");
		
		return $link;
	}
	
	function db_query($query){
		$result = mysql_query($query) or die ("Произошла ошибка при выполнение запроса");
		return $result;
	}
	
	function db_query_ex($query){
		$values = func_get_args();
		array_shift($values);
		$i = 0;
		$var_dump($query);
		return db_query($values[$i++], $query);
	}
	
	function ghostbook_add($name,$email,$message,$error){
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
		 $name = strings_stripstring(strings_clear($name), 15, 100);
		 $message = nl2br(strings_stripstring(strings_clear($message), 100, 2000));
		 $email = strings_stripstring($email, 100, 100);
		 
		 db_query_ex('INSERT INTO ghost_table (name,email,message,datetime) VALUES('.$name.','.$email.','.$message.','.NOW().')');
		 header('Location: ./?page=1');
		}
		
	}
	
	function ghostbook_delete($id){
		db_query_ex("DELETE FROM ghost_table WHERE id = ".$id);
		header("Location: ./?page=1");
	}
	
	function ghostbook_show