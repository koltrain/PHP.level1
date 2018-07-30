<?php

/*
 * Функции для работы с изображениями по урокам работы с файлами и базой данных
 */

/*
 * Функция выводит полученные данные с файлами в html формате
 */

function render_images()
{
    // Получим файлы
    $files = get_images();
    
    if (! is_array ($files)) {
        return '<div class="error_msg">' . $files . '</div>';
    }
    
    $html = '';

    foreach ($files as $file) { // В цикле перебираем каждую запись
        $html .= '<div class="image">';
       
        // тут я воспроизвожу ситуацию, когда экран пользователя позволяет нам 
        // показать картинку с оптимальным разрешением 320 на 240
        $html .= '<a href="view.php?id=' . $file['id'] . '">'
                . '<img src="get-image.php?name='.$file['local_name'].'&width=320&height=240" alt="'.$file['origin_name'].'">'
                . '</a>';

        $html .= '<br>' . $file['origin_name'];
        $html .= '</div>';
    }

    return $html;
}

/*
 * Функция возвращает массив файлов или строку с ошибкой
 */

function get_images()
{
    // Подключение к базе данных
    $db = db_connect();
    
    // Выбор всех файлов
    $sql = 
    '
        SELECT      * 
        FROM        `files`
        ORDER BY    `views` DESC
    ';

    $st = $db->prepare($sql);
    $st->execute();

    if ($st->errorCode() != '00000') { // Если запрос завершился с ошибкой
        $error = $st->errorInfo();

        return 'При сохранении информации о файле в базу данных произошла '
        . 'ошибка: ' . $error[2];
    }

    if ($st->rowCount() == 0) { // Если файлы ещё не были загружены
	return 'Загруженные изображения отсутствуют';
    }

    $files = $st->fetchAll(PDO::FETCH_ASSOC); // Получить все найденные записи

    return $files;
}

/*
 * Фукнция возращает содержимое изображения для вставки в <img>
 */
function get_src_image($file_name = NULL, $width = 0, $height = 0)
{
    // если не передан один из параметров, возвращаем false
    if ($file_name == NULL || $width == 0 || $height == 0) {
        return false;
    }

    // Полный путь до файла в системе
    $file_path = THUMB_DIR . (int) $width . '_' . (int) $height . '/' . $file_name;
    
    if (!file_exists($file_path)) { // если нет файла, пробуем его создать из оригинала
        create_thumbnail(UPLOAD_DIR . $file_name, $file_path, $width, $height);
    } else {
        touch ($file_path); // обновить временную метку обращения к файлу
    }
    
    $image = file_get_contents($file_path);
    return $image;
}

/*
 * 
 */
function viewImageById($file_id)
{
    $file = getImageById($file_id);

    if (! is_array ($file)) {
        return '<div class="error_msg">' . $file . '</div>';
    }

    $html = '<div>' . $file['origin_name'] . '<br>';
    $html .= '<img src="/uploads/' . $file['local_name'] . '"></img><br>';
    $html .= 'Количество просмотров: ' . $file['views'] . '</div>';

    return $html;
}

/*
 * Получить данные изображения по его ID
 */

function getImageById($file_id)
{
        // Подключение к базе данных
    $db = db_connect();

    // Получаем информацию по переданному файлу
    $sql = 
    '
        SELECT  *
        FROM    `files`
        WHERE   `id` = :id
    ';
    
    $st = $db->prepare($sql);
    $st->execute ([
        ':id' => (int) $file_id
    ]);
    
    if ($st->errorCode() != '00000') { // Если запрос завершился ошибкой
        $error = $st->errorInfo();

        return 'При запросе в базу произошла ошибка: ' . $error[2];
    }
    
    if ($st->rowCount() == 0) { // Если переданный ID не найден
        return 'Изображение с ID ' . $file_id . ' отсутствует в базе';
    }

    // Увеличиваем количество просмотров на 1
    $sql = 
    '
        UPDATE  `files` 
        SET     `views` = `views` +1
        WHERE   `id`    = :id
    ';

    $st_update = $db->prepare($sql);
    $st_update->execute([
        ':id' => $file_id
    ]);

    /*
     * if ($st_update->errorCode() != '00000') {
     *      // тут можно просто записать в лог ошибку, не прерывая работу сайта
     *      // или лучше отправить на сервер syslog-a
     * }
     */ 

    $file = $st->fetch(PDO::FETCH_ASSOC); // Получаем найденную запись

    return $file;
}

function upload_image()
{
    
    // Выбранные разрешения
    $resolutions = [
        [
            320,
            240,
        ],
        [
            640,
            480,
        ],
        [
            1024,
            786,
        ],
        [
            1280,
            720
        ]
    ];

    // Подключаемся к базе данных
    $db = db_connect();
    
    foreach ($_FILES as $file) { // в цикле перебираем каждый загруженный файл

        if ($file['error'] != 0) { // если загрузка с ошибкой
	    return '<div class="error_msg">Ошибка при загрузке файла - загружаемый '
                . 'файл отсутствует!</div>';
	}

        if ($file['size'] == 0) { // если размер файла нулевой (файл пустой)
	    return '<div class="error_msg">Ошибка при загрузке файла - загружаемый '
                . 'файл имеет нулевой размер!</div>';
	}

	$fileinfo = pathinfo($file['name']); // информация о файле
        $filename = md5($file['name']) . '_' . time() . '.' . $fileinfo['extension'];

        foreach ($resolutions as $size) { // для каждого из эеранов делаем ум. копию
            
            $thumb = create_thumbnail(
                $file['tmp_name'], 
                THUMB_DIR . implode('_', $size) . '/' . $filename, 
                $size[0], 
                $size[1]
            );

            if ($thumb === FALSE) { // если не удалось сохранить или файл не изо.
                return '<div class="error_msg">Ошибка при загрузке файла - файл не '
                    . 'является изображением или не удалось сохранить уменьшенную '
                    . 'копию!</div>';
            }
        }

        // пробуем сохранить оригинал
	if (move_uploaded_file ($file['tmp_name'], UPLOAD_DIR . $filename) === FALSE) {
	    return '<div class="error_msg">Ошибка при загрузке файла - файл не '
                . 'является изображением или не удалось сохранить оригинал!</div>';
	}

        // Сохранение в базу данных
        $sql = 
        '
            INSERT INTO `files`
            SET         `local_name`    = :local_name,
                        `origin_name`   = :origin_name,
                        `size`          = :size
        ';
        $st = $db->prepare($sql);

        $params = [
            ':local_name' => $filename, 
            ':origin_name' => $file['name'],
            ':size' => $file['size'],
        ];
        $st->execute($params);

        if ($st->errorCode() != '00000') { // если запрос завершился с ошибкой
            $error = $st->errorInfo();

            return '<div class="error_msg">При сохранении информации о файле в базу данных произошла '
            . 'ошибка: ' . $error[2] . '</div>';
        }
    }

    return true;
}

function create_thumbnail($path, $save, $width, $height) 
{
    $info = getimagesize($path); //получаем размеры картинки и ее тип
    $size = array($info[0], $info[1]); //закидываем размеры в массив

    //В зависимости от расширения картинки вызываем соответствующую функцию
    if ($info['mime'] == 'image/png') {
            $src = imagecreatefrompng($path); //создаём новое изображение из файла
    } else if ($info['mime'] == 'image/jpeg') {
            $src = imagecreatefromjpeg($path);
    } else if ($info['mime'] == 'image/gif') {
            $src = imagecreatefromgif($path);
    } else {
            return false;
    }

    $thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
    $src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
    $thumb_aspect = $width / $height; //отношение ширины к высоте аватарки

    if($src_aspect < $thumb_aspect) { //узкий вариант (фиксированная ширина)

        if ($size[1] <= $height) {
            return true;
        }

        $scale = $width / $size[0];
        $new_size = array($width, $width / $src_aspect);
        $src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); //Ищем расстояние по высоте от края картинки до начала картины после обрезки
    } else if ($src_aspect > $thumb_aspect) {

        if ($size[0] <= $width) {
            return true;
        }

        //широкий вариант (фиксированная высота)
        $scale = $height / $size[1];
        $new_size = array($height * $src_aspect, $height);
        $src_pos = array(($size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
    } else {
        //другое
        $new_size = array($width, $height);
        $src_pos = array(0,0);
    }

    $new_size[0] = max($new_size[0], 1);
    $new_size[1] = max($new_size[1], 1);

    imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);
    //Копирование и изменение размера изображения с ресемплированием

    if($save === false) {
        return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
    } else {
        return imagepng($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
    }
}