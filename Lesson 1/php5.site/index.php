    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    $top ="Заголовок";
    $title = "Урок 1";
    $year = "25";
    echo "<h1>$top</h1>";
    echo "<title>$title</title>";
    echo "<div>$year</div>"
    ?>

</head>
<body>


<?php

echo "Hello,World!<br>";
$name = 'Sergey';
echo ('Hello,' .  $name). '<br>';
define ('my_const', 8) ;
echo my_const . '<br>';
$a = 4;
$b = 5;
echo $a + $b . '<br>';
echo $a - $b . '<br>';
echo $a / $b . '<br>';
echo $a * $b . '<br>';
echo $a % $b . '<br>';
//echo $a ** $b . '<br>'; не работает

// Homework

$a = 5;
$b = '05';
var_dump($a == $b);
var_dump((int)'012345');
var_dump((float)123.0 ===(int)123.0); // разный тип данных
var_dump((int)0 ===(int)'hello, world').'<br>'; // одинаковый тип данных, будет true




$a= 1;
$b = 2;
$b = $a;
$a += $b;
echo 'a=' . $a. '<br>';
echo 'b=' . $b.'<br>';




//homework **
$age = 25;
$name = 'Сергей';
$date = '08-02-2018_7:03';
$sentense = "Меня_зовут,$name.<br> Через_год_мне_будет_" . ($age + 1) . "_лет,_ещё_через_год_" . ($age + 2) ."_лет.<br>"."На_моих_часах_$date. <br>";
echo $sentense;
$sentense = substr("Меня_зовут,$name.<br> Через_год_мне_будет_" . ($age + 1) . "_лет,_ещё_через_год_" . ($age + 2) ."_лет.<br>"."На_моих_часах_$date.", -41);
echo $sentense;
?>

<h1></h1>


</body>
</html>