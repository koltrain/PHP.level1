#!/usr/bin/env php

<?php

define('THUMBS_DIR', '/var/www/html/lesson5/public/uploads/thumbs/'); // путь до копий
define('THUMB_TTL', 7 * 24 * 60 * 60); // 1 неделя в секундах
//define('THUMB_TTL', 60); // для теста 1 минута максимальное время жизни

function rotate($dir = NULL) {

    $dir   = THUMBS_DIR . $dir;
    $files = scandir($dir); // список файлов и папок

    foreach ($files as $file) { // перебираем файлы
        if (in_array($file, ['.', '..'])) { // пропускаем ненужное
            continue;
        }

        if (is_dir($dir . $file)) { // если папка, применяем рекурсию
            rotate ($file . '/');
        } else { // иначе проверяем файл
            $file_path = $dir . $file; // полный путь до файла
            $last_use = fileatime($file_path); // время последнего доступа к файлу
            // если разница между текущим временем и временем последнего 
            // доступа БОЛЬШЕ TTL, то удаляем
            if ((time() - $last_use) > THUMB_TTL) {
                unlink($file_path);
            }
        }
    }
}

rotate();