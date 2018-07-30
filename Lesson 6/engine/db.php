<?php


function get_connection() {

    static $connection = null;

    if(!empty($connection)) {
        return $connection;
    }

    $config = require ROOT_DIR . "config/db.php";

    $connection = mysqli_connect(
        $config['server'],
        $config['bd_username'],
        $config['bd_pass'],
        $config['database']
    );
    mysqli_set_charset (  $connection , 'utf8');
    return $connection;
}

?>