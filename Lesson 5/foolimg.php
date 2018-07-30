<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<?php
$id_img=$_GET['img_id'];
$server = require "bd.php";
$link = mysqli_connect(
$server['host'],
$server['user'],
$server['pass'],
$server['bd']
);
$result=mysqli_query($link,"SELECT id, name, pushed FROM info WHERE id='$id_img'");
$row=mysqli_fetch_assoc($result);
echo "<img src=img/".$row['name'].">";
$pushed=$row['pushed']+1;
echo "<br>Посмотрели: ".$pushed." раз(а)";

$result=mysqli_query($link,"UPDATE info SET pushed='$pushed' WHERE id=$id_img");

?>
</body>
</html>