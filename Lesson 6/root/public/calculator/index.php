<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Calculator</title>
	<link rel="stylesheet" href="../css/style.css">
	<?php
	include_once "../../../engine/app.php";
	
	$connection = get_connection();
	
	if(!empty($_POST)) {
		if (!empty($_POST['multiplication'])) {
			$calcResult = "<span class='answer'>" . $_POST['first_number'] * $_POST['second_number'] . "</span>";
		} elseif (!empty($_POST['addition'])) {
			$calcResult = "<span class='answer'>" . $_POST['first_number'] + $_POST['second_number'] . "</span>";
		} elseif (!empty($_POST['subtraction'])) {
			$calcResult = "<span class='answer'>" . ($_POST['first_number'] - $_POST['second_number']) . "</span>";
		} elseif (!empty($_POST['division'])) {
			if ($_POST['second_number'] == 0){
				$calcResult = "<span  class='answer wrong'>ERROR</span>";
			} else {
				$calcResult = "<span  class='answer'>" . $_POST['first_number'] / $_POST['second_number'] . "</span>";
			}
		}
	}
	
	?>
</head>
<body>

<?php
	
	echo "<form action='index.php' method='post'>
	<input type='number' name='first_number' placeholder='Первое число' required>
	<input type='number' name='second_number' placeholder='Второе число' required>
	<input type='submit' name='addition' value='+'>
	<input type='submit' name='subtraction' value='-'>
	<input type='submit' name='multiplication' value='x'>
	<input type='submit' name='division' value='/'>
	<span>" . $calcResult . "</span>
	</form>";
	
	?>
	<a href="../index.php" class="navigation_link">Вернуться назад</a>
</body>
</html>