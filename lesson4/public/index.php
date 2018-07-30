<?php
include_once "../engine/app.php";

if ( count ($_FILES) > 0) {
    upload_image();
}
?>


<html>
<head>
    <meta charset='utf-8' />
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>
<body>
    <div class="images">
	<?= show_images() ?>
    </div>
    <div>
	<form action="index.php" method="post" enctype="multipart/form-data">
	    <input type="file" name="image">
	    <input type="submit">
	</form>
    </div>
</body>
</html>