<?php

/*
 * Функции для работы с калькулятором
 */

/*
 * Общая функция, которая принимает переменные и вызывает необходимую функцию
 */

function calculate($var1, $var2, $oper)
{
    if (! is_numeric($var1) || !is_numeric($var2)) {
        return [
            'success' => false,
            'msg' => 'Одна из переменных не является числом!'
        ];
    }

    if (! is_callable($oper)) {
        return [
            'success' => false,
            'msg' => 'Передана неверная операция',
        ];
    }
    
    $result = call_user_func($oper, $var1, $var2);
    
    if (! is_numeric($result)) {
        return [
            'success' => false,
            'msg' => $result
        ];
    } else {
        return [
            'success' => true,
            'data' => $result
        ];
    }
}

/*
 * Функция сложения
 */

function addition($var1, $var2)
{
    return $var1 + $var2;
}

/*
 * Функция вычитания
 */

function substraction($var1, $var2)
{
    return $var1 - $var2;
}

/*
 * Функция умножения
 */

function multiplication($var1, $var2)
{
    return $var1 * $var2;
}

/*
 * Функция деления
 */

function division($var1, $var2)
{
    if ((int) $var2 == 0) {
        return 'Делить на 0 нельзя!';
    }

    return $var1 / $var2;
}