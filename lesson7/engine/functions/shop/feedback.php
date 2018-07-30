<?php

/*
 * Функция показа отзывов для товаров в HTML
 */

function renderItemFeedbacks($id)
{
    $data = getFeedbacksById('items', $id);
    
    if (!is_array($data)) {
        return '<div class="error_msg">' . $data . '</div>';
    }
    
    if (count ($data) == 0) {
        return '<div>Отзывы отсутствуют, станьте первым, кто напишет отзыв.</div>';
    }
    
    $html = '';
    
    foreach ($data as $feedback) {
        $html .= '<div>';
        $html .= '<strong>' . $feedback['name'] . ' ' . date ('d-m-Y H:i' ,$feedback['created_at']) . '</strong>: ';
        $html .= $feedback['feedback'];
        $html .= '</div>';
    }
    
    return $html;
}

/*
 * Функция получения отзывов о конкретном товаре
 */

function getFeedbacksById($module, $id)
{
    $sql = 
    '
        SELECT      *
        FROM        feedbacks
        WHERE       module      = :module
        AND         module_id   = :id
        ORDER BY    created_at  DESC
    ';
    
    $params = [
        ':module' => $module,
        ':id' => $id
    ];
    
    $st = db_execute($sql, $params);
    
    if (!is_object($st)) {
        return $st;
    }
    
    return $st->fetchAll(PDO::FETCH_ASSOC);
}

/*
 * Функция добавления отзыва к товару
 */

function addFeedback($module, $id)
{
    $name = filter_input (INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input (INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $feedback = filter_input (INPUT_POST, 'feedback', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if ($name === FALSE || $email === FALSE || $feedback === FALSE) {
        return 'Ошибка валидации переменных!';
    }
    
    $sql = 
    '          
        INSERT INTO feedbacks
        SET         `module`        = :module,
                    `module_id`     = :id,
                    `name`          = :name,
                    `email`         = :email,
                    `feedback`      = :feedback,
                    `created_at`    = UNIX_TIMESTAMP()
    ';
    
    $params = [
        ':module' => $module,
        ':id' => $id,
        ':name' => $name,
        ':email' => $email,
        ':feedback' => $feedback
    ];
    
    $st = db_execute($sql, $params);
    
    if (!is_object($st)) {
        return $st;
    }
    
    return TRUE;
}