<head>
    <link rel="stylesheet" type="text/css" href="../css/catalog_style.css">
</head>
<?php

include_once "../../../engine/app.php";


$connection = get_connection();


$id = $_GET['id'];

if(empty($id)) {
    echo "<b> Товар не найден!</b>
	<a href='../index.php' class='navigation_link'>Вернуться назад</a>";
    exit();
}

$goods = mysqli_query($connection,  "SELECT * FROM lesson_6.goods WHERE `goods_id` = " . $id);

if( $item = mysqli_fetch_assoc($goods)) {
    echo "<img src='../" . $item['img_adress'] . "' height='300' style='float: left; padding: 20'>";
    echo "<h1>" . $item['title'] . "</h1>";
	echo "<h3>Цена:</h3>";
    echo "<p>" . $item['price'] . " P.</p>";
	echo "<h3>Краткое описание</h3>";
    echo "<p>" . $item['description_short'] . "</p>";
	echo "<h3>Подробное описание</h3>";
    echo "<p>" . $item['description_long'] . "</p>
	<a href='../index.php' class='navigation_link'>Вернуться назад</a>";

} else {
    echo "<b> Товар не найден!</b>
	<a href='../index.php' class='navigation_link'>Вернуться назад</a>";
    exit();
}
