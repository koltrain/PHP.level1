<?php

function db_connect($db_name = NULL) {

    static $db = null;

    if(!empty($db)) { // Если объект создан, то вернуть его
        return $db;
    }

    $config = require CONFIG_DIR . 'db.php'; // подключить конфигурационный файл

    if ($db_name != NULL) {
        $config['db_name'] = $db_name;
    }
    
    try {
        $db = new PDO ( // полключание к базе данных
            "mysql:host=$config[db_host];dbname=$config[db_name];charset=utf8mb4", 
            $config['db_user'], 
            $config['db_pass']
        );
    } catch (Exception $ex) { // обработать исключение в случае ошибок
        return 'Ошибка при подключении к базе данных: ' . $ex->getMessage();
    }

    return $db;
}

/*
 * Выполнение переданного SQL-запроса с параметрами
 */

function db_execute($sql, $params = [])
{
    $db = db_connect(); // Подключаемся к БД

    if (! is_object($db)) { // Если вернулась строка, а не объект, значит ошибка
        return $db;
    }
    
    if (!is_object($db) || empty ($sql)) {
        return 'Не передан объект БД или отсутствует SQL-запрос';
    }
    
    $st = $db->prepare($sql);
    $st->execute($params);
    
    if ($st->errorCode() != '00000') {
        $error = $st->errorInfo();
        
        return 'При выполнении запроса произошла ошибка: ' . $error[2];
    }
    
    return $st;
}

/*
 * Возвращает последний вставленный ID
 */

function db_last_insert_id()
{
    $db = db_connect(); // Подключаемся к БД

    if (! is_object($db)) { // Если вернулась строка, а не объект, значит ошибка
        return $db;
    }
    
    return $db->lastInsertId();
}