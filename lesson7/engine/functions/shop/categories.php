<?php

/*
 * Функция вывода списка категорий в html
 */

function indexCategories()
{
    
    $sql = 
    '
        SELECT      * 
        FROM        `categories`
        WHERE       `is_deleted` = 0
        ORDER BY    `position` asc, `name`
    ';
    
    $st = db_execute ($sql);
    
    if (!is_object($st)) {
        $data = $st;
    } else {
        $data['categories'] = $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return render('categories/index.php', $data);
}

/*
 * Функция добавления категории
 */

function addCategory()
{
    
    if (! empty ($_POST)) {
        
        $name = filter_input (INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $position = filter_input (INPUT_POST, 'position', FILTER_SANITIZE_NUMBER_INT);

        if (isset ($_POST['visible'])) {
            $visible = 1;
        } else {
            $visible = 0;
        }

        $file = $_FILES['image'];

        if ($file['error'] != 0) { // если загрузка с ошибкой
            return render ('categories/add.php', 'Не удалось загрузить сайт');
        }

        if ($file['size'] == 0) { // если размер файла нулевой (файл пустой)
            return render ('categories/add.php', 'Ошибка при загрузке файла - загружаемый '
                . 'файл имеет нулевой размер!');
        }

        $fileinfo = pathinfo($file['name']); // информация о файле
        $filename = md5($file['name']) . '_' . time() . '.' . $fileinfo['extension'];
        $filepath = UPLOAD_DIR . $filename;

        $result = create_thumbnail($file['tmp_name'], $filepath, 140, 140);

        if ($result !== TRUE) {
            return render ('categories/add.php', 'Ошибка при загрузке файла - не удалось '
            . 'сохранить файл!');
        }

        $sql = 
        '
            INSERT INTO `categories`
            SET         `name`          = :name,
                        `position`      = :position,
                        `is_visible`    = :visible,
                        `image_name`    = :local_name,
                        `created_at`    = UNIX_TIMESTAMP()
        ';

        $params = [
            ':name' => $name,
            ':position' => $position,
            ':visible' => $visible,
            ':local_name' => $filename
        ];

        $st = db_execute($sql, $params);

        if (!is_object($st)) {
            return render ('categories/add.php', 'Ошибка при добавлении категории: '
                . $st);
        }
        
        return header ('Location: /index.php');
    }
    
    return render('categories/add.php');
}

/*
 * Функция редактирования категории
 */

function editCategory()
{
    
    if (empty ($_GET['id']) || ! isset ($_GET['id'])) {
        render ('categories/index.php', 'не задана категория!');
    }
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    if (! empty ($_POST)) { // Если пришли данные на обновление

        $name = filter_input (INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $position = filter_input (INPUT_POST, 'position', FILTER_SANITIZE_NUMBER_INT);

        if (isset ($_POST['visible'])) {
            $visible = 1;
        } else {
            $visible = 0;
        }

        if (empty ($_FILES['image']['name'])) {
            $sql = 
            '
                UPDATE  `categories`
                SET     `name`          = :name,
                        `position`      = :position,
                        `is_visible`    = :visible,
                        `updated_at`    = UNIX_TIMESTAMP()
                WHERE   `id`            = :id
            ';

            $params = [
                ':name' => $name,
                ':position' => $position,
                ':visible' => $visible,
                ':id' => $id
            ];
        } else {
            $file = $_FILES['image'];

            if ($file['error'] != 0) { // если загрузка с ошибкой
                return render ('categories/edit.php', 'Ошибка при загрузке файла - загружаемый '
                    . 'файл отсутствует!');
            }

            if ($file['size'] == 0) { // если размер файла нулевой (файл пустой)
                return render ('categories/edit.php', 'Ошибка при загрузке файла - загружаемый '
                    . 'файл имеет нулевой размер!');
            }

            $fileinfo = pathinfo($file['name']); // информация о файле
            $filename = md5($file['name']) . '_' . time() . '.' . $fileinfo['extension'];
            $filepath = UPLOAD_DIR . $filename;

            $result = create_thumbnail($file['tmp_name'], $filepath, 140, 140);

            if ($result !== TRUE) {
                return render ('categories/edit.php', 'Ошибка при загрузке файла - не удалось '
                . 'сохранить файл!');
            }

            $sql = 
            '
                UPDATE  `categories`
                SET     `name`          = :name,
                        `position`      = :position,
                        `is_visible`    = :visible,
                        `image_name`    = :local_name,
                        `updated_at`    = UNIX_TIMESTAMP()
                WHERE   `id`            = :id
            ';

            $params = [
                ':name' => $name,
                ':position' => $position,
                ':visible' => $visible,
                ':local_name' => $filename,
                ':id' => $id
            ];
        }
        
        $st = db_execute($sql, $params);
        
        if (!is_object($st)) {
            return render ('categories/edit.php', $st);
        }
        
        return header ('Location: /index.php');
    }
    
    $sql =
    '
        SELECT  *
        FROM    `categories`
        WHERE   `id`            = :id
        AND     `is_deleted`    = 0
    ';
    
    $params = [
        ':id' => $id
    ];
    
    $st = db_execute($sql, $params);
    
    if (!is_object($st)) {
        $data = $st;
    } else {
        $data['category'] = $st->fetch(PDO::FETCH_ASSOC);
    }
    
    return render ('categories/edit.php', $data);
}

/*
 * Функция удаления категории
 */

function deleteCategory()
{
    
    if (empty ($_GET) || ! isset ($_GET['id'])) {
        return render ('categories/delete.php', 'Не задана категория!');
    }
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    if ($id === FALSE) {
        // todo render error
    }
    
    $sql =
    '
        UPDATE  `categories`
        SET     `is_deleted`    = 1
        WHERE   `id`            = :id
    ';
    
    $st = db_execute($sql, [':id' => $id]);
    
    if (!is_object($st)) {
        return render ('categories/delete.php', 'При попытке удаления произошла '
            . 'ошибка:' . $st);
    }
    
    return header ('Location: /index.php');
}