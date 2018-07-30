<head>
    <link rel="stylesheet" type="text/css" href="../css/catalog_style.css">
</head>
<?php

include_once "../../../engine/app.php";

$connection = get_connection();


$id = $_GET['id'];

if(empty($id)) {
    echo "<b>Товар не найден!</b>
	<a href='../index.php' class='navigation_link'>Вернуться назад</a>";
    exit();
}

	
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
			$goods = mysqli_query($connection, "SELECT * FROM goods WHERE `goods_id` = " . $id);
			if( $good = mysqli_fetch_assoc($goods)) {
				$imgAdress = $good['img_adress'];
			}
		}
	}
    mysqli_query($connection,  "UPDATE lesson_6.goods SET category_id =  '" . antiInj($connection, $_POST['category_id']) . "' , title = '" . antiInj($connection, $_POST['title']) . "' , description_short = '" . antiInj($connection, $_POST['description_short']) . "' , description_long = '" . antiInj($connection, $_POST['description_long']) . "' , price = '" . antiInj($connection, (int)($_POST['price'])) . "', img_adress = '" . $imgAdress . "' WHERE goods_id = " . $id);
	$done = "Выполнено";
}

$goods = mysqli_query($connection,  "SELECT * FROM lesson_6.goods WHERE `goods_id` = " . $id);

if( $good = mysqli_fetch_assoc($goods)) {

	
   echo "<form action='edit.php?id={$id}' enctype='multipart/form-data' method='post'>
			<img class='uploaded_img' src='../{$good['img_adress']}'>
   	<select class='edit_select' name='category_id'>
		<option " . getCategory(4, $good['category_id']) . ">Маска</option>
		<option " . getCategory(2, $good['category_id']) . ">Гидрокостюм</option>
		<option " . getCategory(3, $good['category_id']) . ">Горнолыжные ботинки</option>
		<option " . getCategory(1, $good['category_id']) . ">Вейкборд</option>
	</select>
            <input class='edit_input' type='text' name='title' value='{$good['title']}' required>
            <textarea class='edit_short_desc' name='description_short' placeholder='Краткое описание товара' required>{$good['description_short']}</textarea>
            <textarea class='edit_long_desc' name='description_long' placeholder='Подробное описание товара'>{$good['description_long']}</textarea>
			<input class='edit_input' type='number' name='price' value='{$good['price']}' placeholder='Цена' required>
    		<input class='edit_input upload_file' type='file' name='file_name'>
            <input class='edit_input menu_list_link' type='submit'>
			<span class='accepted'>" . $done . "</span>
        </form>";
	echo "<a href='../index.php' class='navigation_link'>Вернуться назад</a>";

} else {
    echo "<b>Товар не найден!</b>
	<a href='../index.php' class='navigation_link'>Вернуться назад</a>";
    exit();
}

?>