<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<title>Shop</title>
	<link rel="stylesheet" href="css/catalog_style.css">
	<?php
	include_once "../../engine/app.php";
	
	$connection = get_connection();

	$type = $_GET['type'];

	if(!empty($type)) {
    	$categories = mysqli_query($connection,"SELECT * FROM goods INNER JOIN goods_categories ON category_id = goods_categories.id WHERE `category_title` LIKE '". $type ."'" );
		
	} else {
    	$categories = mysqli_query($connection, "SELECT * FROM goods");
	}
?>
	
</head>

<body>

	<ul class="menu">
		<li class="menu_list"><a href="index.php" class="menu_list_link">Все товары</a></li>
		<li class="menu_list"><a href="index.php?type=masks" class="menu_list_link">Маски</a></li>
		<li class="menu_list"><a href="index.php?type=hydrosuits" class="menu_list_link">Гидрокостюмы</a></li>
		<li class="menu_list"><a href="index.php?type=mountboots" class="menu_list_link">Горнолыжные ботинки</a></li>
		<li class="menu_list"><a href="index.php?type=wakeboards" class="menu_list_link">Вейкборды</a></li>
	</ul>

<?php
	echo "<hr><ul class='menu'>";

	while ( $category = mysqli_fetch_assoc($categories) ) {
		
    	echo "<li class='menu_list'><a href='pages/item.php?id=". $category['goods_id'] . "' class='item_prev_link' target='blank'><img src='" . $category['img_adress'] . "'><span>" . $category['title'] . "</span></a><a href='pages/edit.php?id={$category['goods_id']}' class='edit'>✎</a><a href='pages/remove.php?id={$category['goods_id']}' class='edit'>☒</a></li>";
	}
	echo "</ul>";
	echo "<a href='pages/add.php' class='navigation_link'>Добавить товар</a>";

	?>
<a href="calculator/index.php" class="navigation_link">Калькулятор</a>
</body>

</html>
