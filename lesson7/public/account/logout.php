<?php

require_once '../../engine/app.php';

session_destroy();

header ('Location: /account/login.php');