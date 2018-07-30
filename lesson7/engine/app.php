<?php

setlocale(LC_ALL, 'ru_RU.utf8');

session_start();

define('APP_DIR',    __DIR__ . '/');
define('CONFIG_DIR', APP_DIR . '/../config/');

require_once CONFIG_DIR . "config.php";
require_once APP_DIR . "db.php";
require_once APP_DIR . "functions.php";
