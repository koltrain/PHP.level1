<head>
    <link rel="stylesheet" type="text/css" href="../css/catalog_style.css">
</head>
<?php

    include_once "../../../engine/app.php";
$connection = get_connection();
	
if(!empty($_POST)) {
	if (!empty($_FILES['file_name'])) {
		$file_info = $_FILES['file_name'];
		if ($file_info['name'] != '') {
			if (getimagesize ($file_info['tmp_name']) == true) {
				move_uploaded_file($file_info['tmp_name'], UPLOAD_DIR . 'img/' . md5($file_info['name']) . substr($file_info['name'], -4));
				$imgAdress = 'img/' . md5($file_info['name']) . substr($file_info['name'], -4);
			} else {
				echo '<span style="color: red">Wrong format!</span>';
			}
		} else {
			$imgAdress = NULL;
		}
	}
    mysqli_query($connection,  "INSERT INTO lesson_6.goods (category_id, title, description_short, description_long, price, img_adress) VALUES (  '" . antiInj($connection, $_POST['category_id']) . "' , '" . antiInj($connection, $_POST['title']) . "' , '" . antiInj($connection, $_POST['description_short']) . "' , '" . antiInj($connection, $_POST['description_long']) . "' , '" . antiInj($connection, (int)($_POST['price'])) . "', '{$imgAdress}')");
	$done = "Выполнено";
}



?>

<form action="add.php" method="post" enctype="multipart/form-data">
	<select class='upload_select' name="category_id">
		<option value="4">Маска</option>
		<option value="2">Гидрокостюм</option>
		<option value="3">Горнолыжные ботинки</option>
		<option value="1">Вейкборд</option>
	</select>
    <input class='upload_input' type="text" name="title" required>
	<textarea class='upload_short_desc' name="description_short" placeholder="Краткое описание товара" required></textarea>
	<textarea class='upload_long_desc' name="description_long" placeholder="Подробное описание товара"></textarea>
    <input class='upload_input' type="number" name="price" placeholder="Цена" required>
    <input class='upload_input upload_file' type='file' name='file_name'>
    <input class='upload_input menu_list_link' type="submit">
	<span class='accepted'><?= $done ?></span>
</form>
	<a href='../index.php' class='navigation_link'>Вернуться назад</a>
