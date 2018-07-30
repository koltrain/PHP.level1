<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Галерея фотографий</title>

    <style type="text/css">
        .images {
            width: 100px;
            height: 120px;
            border: 3px ridge;
            border-color: #929292;
            float: left;
            margin: 5px;
        }

        .images img {
            width: 100%;
            height: 100%;
        }

        .content {
            width: 100%;
            position: relative;
            float: left;
        }

        .footer {
            width: 100%;
            float: left;
        }
    </style>
</head>
<body>
<h1>Наша супер галерея фоток</h1>
<div class="content">
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file_name">
        <input type="submit">
    </form>


    <div>
        <?php
        include_once "resize.php";
        $server = require "bd.php";

        $dir = $_SERVER['DOCUMENT_ROOT'] . "/img/";
        $dir_tumb = $_SERVER['DOCUMENT_ROOT'] . "/img/tumb/";
        $link = mysqli_connect(
            $server['host'],
            $server['user'],
            $server['pass'],
            $server['bd']
        );

        //загрузка картинки в папку img
        if (!empty($_FILES['file_name'])) {

            $file_info = $_FILES['file_name'];
            $file_name = md5($file_info['name']);
            $file_type = $file_info['type'];
            $file_size = $file_info['size'];
            $file_tmp_name = $file_info['tmp_name'];

            $info = inform($file_type, $file_size);

            if ($info) {
                move_uploaded_file($file_tmp_name, $dir . $file_name);
                create_thumbnail($dir . $file_name, $dir_tumb . $file_name, 100, 120);


                $result = mysqli_query($link, "INSERT INTO info SET name='$file_name', size='$file_size', adress='$dir'");
            }
        }
        //вывод изображений из папки img на страничке


        $result = mysqli_query($link, "SELECT id, name, pushed FROM info ORDER BY pushed DESC");

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="images"><a href="foolimg.php?img_id=' . $row['id'] . '"><img src=img/tumb/' . $row['name'] . '></a><br>Отк.-' . $row['pushed'] . ' раз(а)</div>';
        }
        ?>
    </div>
</div>


<?php
//функция проверки типа и размера файла
function inform($type, $size)
{
    if ($size <= 300000) {
        if ($type == "image/jpeg" or $type == "image/png" or $type == "image/jpg") {
            return true;
        }
    }
    return false;
}

?>

</body>
</html>