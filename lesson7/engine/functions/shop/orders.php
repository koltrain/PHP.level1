<?php

/*
 * Функция добавления товара в корзину
 */

function addOrder()
{
    if (! empty ($_POST)) {
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
        
        if ($item_id === FALSE || $quantity === FALSE) {
            return json_encode([
                'success' => false,
                'error_msg' => 'Переданы неверные данне'
            ]);
        }
        
        if (isset ($_SESSION['orders']['items'][$item_id])) {
            $_SESSION['orders']['items'][$item_id] = $_SESSION['orders'][$item_id] + $quantity;
        } else {
            $_SESSION['orders']['items'][$item_id] = $quantity;
        }
        
        $_SESSION['orders']['count'] = $_SESSION['orders']['count'] + $quantity;
        
        return json_encode([
            'success' => true,
        ]);
    }
}

/*
 * Функция удаления из корзины
 */

function deleteOrder()
{
    if (! empty ($_POST)) {
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_NUMBER_INT);
        
        if ($item_id === FALSE) {
            return json_encode([
                'success' => false,
                'error_msg' => 'Переданы неверные данне'
            ]);
        }
        
        $quantity = $_SESSION['orders']['items'][$item_id];
        
        unset ($_SESSION['orders']['items'][$item_id]);
        
        $_SESSION['orders']['count'] = $_SESSION['orders']['count'] - $quantity;
        
        return json_encode([
            'success' => true,
        ]);
    }
}

/*
 * Функция вывода данных корзины
 */

function indexOrders()
{
    if (! isset ($_SESSION['orders']['items'])) {
        return render ('orders/index.php', ['orders']);
    }
    
    $data['orders'] = [];
    
    $i = 1;
    $allCost = 0;
    
    foreach ($_SESSION['orders']['items'] as $item_id => $quantity) {
        
        $sql = 
        '
            SELECT  *
            FROM    `items`
            WHERE   `id` = :id
            AND     `is_deleted` = 0
        ';
        
        $params = [
            ':id' => $item_id
        ];
        
        $st = db_execute($sql, $params);
        
        if (!is_object($st)) {
            return render ('orders/index.php', $st);
        }
        
        $item_data = $st->fetch(PDO::FETCH_ASSOC);
        
        $data['orders'][] = [
            'i' => $i++,
            'item_id' => $item_id,
            'name' => $item_data['name'],
            'quantity' => $quantity,
            'cost' => $item_data['cost'],
            'price' => $quantity * $item_data['cost']
        ];
        
        $allCost = $allCost + $quantity * $item_data['cost'];
    }
    
    $data['allCost'] = $allCost;
    $data['allCnt'] = $i;
    
    return render ('orders/index.php', $data);
}