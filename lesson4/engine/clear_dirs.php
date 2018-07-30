#!/usr/bin/env php

<?php

define ('WEBROOT_DIR', '/var/www/html/lesson4/public/');

function clear_dir($dir = NULL)
{
/*
    $stop_dirs = [
	'/',
	'.',
	'..',
	'./',
    ];
    if (in_array ($dir, $stop_dirs)) {
	return 
    }
*/
    // Защита от дурака и от попыток добраться до верхних директорий с помощью  ../../../
    if (preg_match('/^('.addcslashes(WEBROOT_DIR, '/').').*/', $dir) == 0 || preg_match ('/(\.\.).*/', $dir) > 0) {
	return 'Василий, смотри что удаляешь!';
    }

    $files = scandir($dir);
    foreach ($files as $file) {
	if (in_array ($file, ['.', '..'])) continue;
	$file = $dir . $file;
	if (is_dir ($file)) {
	    if (count (scandir($file)) == 2) 	rmdir($file);
	    else				clear_dir($file . '/');
	} else {
	    unlink ($file);
	}
    }
    rmdir ($dir);
}

echo clear_dir(WEBROOT_DIR . 'tmp/') . PHP_EOL;
//
////echo clear_dir('/') . PHP_EOL;