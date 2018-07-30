<?php

/*
 * Функция вывода списка товаров в html
 */

function indexItems()
{
    if (empty ($_GET) || ! isset ($_GET['category_id'])) {
        render ('items/index.php', 'Не задана категория!');
    }
    
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    
    if ($category_id === FALSE) {
        // todo render error msg
    }
    
     $sql = 
    '
        SELECT      *
        FROM        `items`
        WHERE       `category_id`   = :category_id
        AND         `is_deleted`    = 0
        GROUP BY    `position` ASC, `name`
    ';
    
    $st = db_execute($sql, [':category_id' => $category_id]);
    
    if (!is_object($st)) {
        $data = $st;
    } else {
        $data['items'] = $st->fetchAll(PDO::FETCH_ASSOC);
        $data['category_id'] = $category_id;
    }
    
    return render ('items/index.php', $data);
}

/*
 * Функция получения информации о товаре по ID
 */

function showItem()
{
    
    if (empty ($_GET) || ! isset ($_GET['item_id'])) {
        render ('items/show.php', 'Не задан товар!');
    }
    
    $item_id = filter_input(INPUT_GET, 'item_id', FILTER_SANITIZE_NUMBER_INT);
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    
    if ($item_id === FALSE) {
        // todo render error msg
    }
    
    $sql =
    '
        SELECT  *
        FROM    items
        WHERE   id          = :item_id
        AND     is_deleted  = 0
    ';
    
    $st = db_execute($sql, [':item_id' => $item_id]);
    
    if (!is_object($st)) {
        $data = $st;
    } else {
        $data['item'] = $st->fetch(PDO::FETCH_ASSOC);
        $data['category_id'] = $category_id;
    }
    
    return render ('items/show.php', $data);
}

/*
 * Функция добавления товара в категорию
 */

function addItem()
{
    
    if (empty ($_GET) || ! isset ($_GET['category_id'])) {
        render ('items/index.php', 'Не задана категория!');
    }
    
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    
    if ($category_id === FALSE) {
        // todo render error msg
    }
    
    if (! empty ($_POST)) {

        $name = filter_input (INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cost = filter_input (INPUT_POST, 'cost', FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input (INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $position = filter_input (INPUT_POST, 'position', FILTER_SANITIZE_NUMBER_INT);

        if (isset ($_POST['visible'])) {
            $visible = 1;
        } else {
            $visible = 0;
        }

        $file = $_FILES['main_image'];

        if ($file['error'] != 0) { // если загрузка с ошибкой
            return render ('items/add.php', 'Ошибка при загрузке файла - загружаемый '
                . 'файл отсутствует!');
        }

        if ($file['size'] == 0) { // если размер файла нулевой (файл пустой)
            return render ('items/add.php', 'Ошибка при загрузке файла - загружаемый '
                . 'файл имеет нулевой размер!');
        }

        $fileinfo = pathinfo($file['name']); // информация о файле
        $filename = md5($file['name']) . '_' . time() . '.' . $fileinfo['extension'];
        $filepath = THUMB_DIR . $filename;

        $result = create_thumbnail($file['tmp_name'], $filepath, 140, 140);

        if ($result !== TRUE) {
            return render ('items/add.php', 'Ошибка при загрузке файла - не удалось '
            . 'сохранить файл!');
        }

        // пробуем сохранить оригинал
        if (move_uploaded_file ($file['tmp_name'], UPLOAD_DIR . $filename) === FALSE) {
            return render ('items/add.php', 'Ошибка при загрузке файла - файл не '
                . 'является изображением или не удалось сохранить оригинал!');
        }

        $sql = 
        '
            INSERT INTO `items`
            SET         `name`          = :name,
                        `cost`          = :cost,
                        `descriptions`  = :description,
                        `category_id`   = :category_id,
                        `position`      = :position,
                        `is_visible`    = :visible,
                        `image_name`    = :local_name,
                        `created_at`    = UNIX_TIMESTAMP()
        ';

        $params = [
            ':name' => $name,
            ':cost' => $cost,
            ':description' => $description,
            ':category_id' => $category_id,
            ':position' => $position,
            ':visible' => $visible,
            ':local_name' => $filename
        ];

        $st = db_execute($sql, $params);

        if (!is_object($st)) {
            return render ('items/add.php', 'Ошибка при добавлении категории: '
                . $st);
        }
        
        header('Location: /items/index.php?category_id=' . $category_id);
    }
    
    return render ('items/add.php', ['category_id' => $category_id]);
}

/*
 * Функция редактирования информации о товаре
 */

function editItem()
{
    
    if (empty ($_GET) || ! isset ($_GET['id'])) {
        render ('items/index.php', 'Не задан товар!');
    }
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    
    if ($id === FALSE) {
        // todo render error msg
    }
    
    if (! empty ($_POST)) {
    
        $name = filter_input (INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cost = filter_input (INPUT_POST, 'cost', FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input (INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $position = filter_input (INPUT_POST, 'position', FILTER_SANITIZE_NUMBER_INT);

        if (isset ($_POST['visible'])) {
            $visible = 1;
        } else {
            $visible = 0;
        }

        if (empty ($_FILES['main_image']['name'])) {
            $sql = 
            '
                UPDATE  `items`
                SET     `name`          = :name,
                        `cost`          = :cost,
                        `descriptions`  = :description,
                        `position`      = :position,
                        `is_visible`    = :visible,
                        `updated_at`    = UNIX_TIMESTAMP()
                WHERE   `id`            = :id
            ';

            $params = [
                ':name' => $name,
                ':cost' => $cost,
                ':description' => $description,
                ':position' => $position,
                ':visible' => $visible,
                ':id' => $id
            ];
        } else {
            $file = $_FILES['main_image'];

            if ($file['error'] != 0) { // если загрузка с ошибкой
                return render ('items/edit.php', 'Ошибка при загрузке файла - загружаемый '
                    . 'файл отсутствует!');
            }

            if ($file['size'] == 0) { // если размер файла нулевой (файл пустой)
                return render ('items/edit.php', 'Ошибка при загрузке файла - загружаемый '
                    . 'файл имеет нулевой размер!');
            }

            $fileinfo = pathinfo($file['name']); // информация о файле
            $filename = md5($file['name']) . '_' . time() . '.' . $fileinfo['extension'];
            $filepath = UPLOAD_DIR . $filename;

            $result = create_thumbnail($file['tmp_name'], $filepath, 140, 140);

            if ($result !== TRUE) {
                return render ('items/edit.php', 'Ошибка при загрузке файла - не удалось '
                . 'сохранить файл!');
            }

            $sql = 
            '
                UPDATE  `items`
                SET     `name`          = :name,
                        `cost`          = :cost,
                        `descriptions`  = :description,
                        `position`      = :position,
                        `is_visible`    = :visible,
                        `image_name`    = :local_name,
                        `updated_at`    = UNIX_TIMESTAMP()
                WHERE   `id`            = :id
            ';

            $params = [
                ':name' => $name,
                ':cost' => $cost,
                ':description' => $description,
                ':position' => $position,
                ':visible' => $visible,
                ':local_name' => $filename,
                ':id' => $id
            ];
        }

        $st = db_execute($sql, $params);

        if (!is_object($st)) {
            return render ('items/edit.php', $st);
        }
        
        header ('Location: /items/index.php?category_id=' . $category_id);
    }
    
    $sql = 
    '
        SELECT  *
        FROM    `items`
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
        $data['item'] = $st->fetch(PDO::FETCH_ASSOC);
        $data['category_id'] = $category_id;
    }
    
    return render ('items/edit.php', $data);
}

/*
 * Функция удаления товара
 */

function deleteItem()
{
    
    if (empty ($_GET) || ! isset ($_GET['id'])) {
        render ('items/delete.php', 'Не задан товар!');
    }
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    
    if ($id === FALSE) {
        // todo render error msg
    }
    
    $sql =
    '
        UPDATE  `items`
        SET     `is_deleted`    = 1
        WHERE   `id`            = :id
    ';
    
    $st = db_execute($sql, [':id' => $id]);
    
    if (!is_object($st)) {
        return render ('items/delete.php', 'При попытке удаления произошла ошибка:'
                . $st);
    }
    
    return header ('Location: /items/index.php?category_id=' . $category_id);
}