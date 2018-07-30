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
    mysqli_query($connection,  "DELETE FROM lesson_6.goods WHERE goods_id = " . $id);
	$done = "Выполнено";
}

$goods = mysqli_query($connection,  "SELECT * FROM lesson_6.goods WHERE `goods_id` = " . $id);

if( $good = mysqli_fetch_assoc($goods)) {

	
   echo "<form action='remove.php?id={$id}' method='post'>
  	<span>Вы уверены, что хотите удалить {$good['title']} из списка товаров?</span>
            <input type='submit' class='delete' name='delete' value='Удалить'>
			<span class='accepted'>" . $done . "</span>
	<a href='../index.php' class='navigation_link'>Вернуться назад</a>
        </form>";

} else {
    echo "<b>Товар не найден!</b>
	<a href='../index.php' class='navigation_link'>Вернуться назад</a>";
    exit();
}

?>