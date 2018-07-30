<?php

include_once "../engine/app.php";

if (! isset ($_GET['params']) || ! is_array ($_GET['params'])) {
    echo json_encode([
	'success' => false,
	'msg' => 'Переданы невалидные параметры',
    ]);
    exit;
}

$params = $_GET['params'];

switch ($params['action']) {
    case 'render_files':
	if (! isset ($params['current_dir']) || empty($params['current_dir'])) {
	    echo json_encode ([
		'success' => true,
		'html' => render_files(),
	    ]);
	    exit;
	}

	if (preg_match ('/(\.\.).*/', $params['current_dir']) > 0) return false;

	echo json_encode ([
	    'success' => true,
	    'html' => render_files($params['current_dir'], $params['back']),
	]);
	exit;
    case 'rename':
	echo json_encode([
	    'success' => rename_file($params['path'], $params['newname']),
	]);
	exit;
    default:
	return false;
}





