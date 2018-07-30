<?php

$calculationResult = 0;


function getCategory($value, $goodCategory) {
	if ($value == $goodCategory) {
		return "value='$value' selected";
	} else {
		return "value='$value'";
	}
}

function antiInj($connection, $inputedString) {
	$newString = mysqli_real_escape_string($connection, htmlspecialchars(strip_tags($inputedString)));
	return $newString;
}

?>