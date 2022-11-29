<?php
	require "config.php";
	require "functions.php";
	print("<h1 class='headTitle'>Гостевая книга!</h1>");

	$former = "";
	$page=1;
	$db = db_connect(DBHOST,DBUSER,DBPASSWD,DBNAME);
	if(!empty ($_POST)){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
	}
	if(!empty ($_GET)){
		if($_GET['action']=="add"){
			ghostbook_add($name,$email,$message,$former,$db);
		}elseif($_GET['action']=="delete" && isset($_GET['id'])){
			ghostbook_delete($_GET['id'],$db);
		}
	}
	$row = ghostbook_show($page,$db);
	$item="";
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset ="UTF-8">
		<title>Гостевая книга</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="formBlock">
			<h2 class="headTitle">Добавить запись в гостевую книгу</h2>
			<form action="index.php?action=add" method="POST">
				<div class="formData">
					<label for="name" class="labelForm">Введите имя: </label>
					<input type="text" name="name" id="name">
					
					<label for="email" class="labelForm">Введите эл. адресс: </label>
					<input type="text" name="email" id="email">
					
					<label for="text" class="labelForm">Введите сообщение: </label>
					<textarea type="text" name="message" id="text"></textarea>
					<button type="sumbit" class="buttonForm">Написать</button>

				</div>
			</form>
		</div>
		<div class="blockMessages">
			<?php
				if (!empty($row)):
					foreach($row as $item):

			?>
			<div class="userMessage">
				<p>Имя: <?= $item['name']  ?></p>
				<p>Email: <?= $item['email']  ?></p>
				<p>Текст: <?= $item['message']  ?></p>
				<p>Дата: <?= date("m/d/Y H:i:s", $item['date'])  ?></p>
				<a href="?action=delete&id=<?= $item['id'] ?>">Удалить запись</a>
			</div>
			</hr>
			<?php
				endforeach;
				endif;
			?>
		</div>
	</body>
</html>