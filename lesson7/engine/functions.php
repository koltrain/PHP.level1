<?php

/*
 * Подключение функций
 */

require_once FUNCTIONS_DIR . 'images.php';          // Функции для работы с изо.
//require_once FUNCTIONS_DIR . 'file_manager.php';    // Функции файлового менеджера
//require_once FUNCTIONS_DIR . 'calc.php';            // Функции калькулятора
require_once FUNCTIONS_DIR . 'shop.php';            // Функции магазина


function render ($template, $params = []) 
{
    
    if (! is_array ($params)) { // Если парамс не массив, значит в нём ошибка
        $template_path = TEMPLATE_DIR . DEFAULT_TEMPLATE . '/layouts/error.php';
    } else {
        $template_path = TEMPLATE_DIR . DEFAULT_TEMPLATE . '/' . $template;
        extract($params);
    }
    
    if(file_exists($template_path)) {
        
        ob_start();
        require $template_path;
        $content = ob_get_clean();
        
        include TEMPLATE_DIR . DEFAULT_TEMPLATE . '/layouts/main.php';
        
    } else {
        $content = 'Страницы не существует, но вот вам кРотики';
    }
}