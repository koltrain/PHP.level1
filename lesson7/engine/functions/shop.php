<?php

require_once FUNCTIONS_DIR . 'shop/categories.php'; // Функции для категорий
require_once FUNCTIONS_DIR . 'shop/items.php';      // Функции для товаров
require_once FUNCTIONS_DIR . 'shop/feedback.php';   // Функции для отзывов
require_once FUNCTIONS_DIR . 'shop/account.php';    // Функции аккаутинга
require_once FUNCTIONS_DIR . 'shop/orders.php';     // Функции работы с корзиной

/*
 * Функция управления модулем
 */

function doFeedbackAction($module, $action, $id = null)
{
    if (empty ($module) || empty ($action)) {
        return 'Не передан модуль или дейтствия для модуля!';
    }
    
    $func = $action . $module;
    
    if (! is_callable($func)) {
        return 'Функции ' . $func . ' не существует!';
    }
    
    if ($id == null) {
        return call_user_func($func);
    } else {
        return call_user_func($func, $id);
    }
}