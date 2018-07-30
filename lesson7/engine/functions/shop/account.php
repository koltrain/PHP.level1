<?php

/*
 * Функция логина
 */

function login()
{
    if (! empty ($_POST)) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($email === FALSE || $password === FALSE) {
            return render ('account/login.php', [
                'email' => $email,
                'password' => $password,
                'error_msg' => 'Данные имеют неверный формат!'
            ]);
        }
        
        $sql = 
        '
            SELECT  *
            FROM    `users`
            WHERE   `email`         = :email
            AND     `is_deleted`    = 0
        ';
        
        $params = [
            ':email' => $email
        ];
        
        $st = db_execute($sql, $params);
        
        if (!is_object($st)) {
            return render ('account/login.php', [
                'email' => $email,
                'password' => $password,
                'error_msg' => $st
            ]);
        }
        
        if ($st->rowCount() == 0) {
            return render ('account/login.php', [
                'email' => $email,
                'password' => $password,
                'error_msg' => 'Пользователь с таким логином не существует!'
            ]);
        }
        
        $user = $st->fetch(PDO::FETCH_ASSOC);
        
        if (confirmPassword($user['password'], $password)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['orders']['count'] = 0;
            
            header ('Location: /index.php');
        } else {
            return render ('account/login.php', [
                'email' => $email,
                'password' => $password,
                'error_msg' => 'Неверный логин и/или пароль'
            ]);
        }
    }
    
    if (isset ($_SESSION['user_id']) && ! empty ($_SESSION['user_id'])) {
        return header ('Location: /index.php');
    }
    
    return render ('account/login.php', [
        'email' => '',
        'password' => ''
    ]);
}

/*
 * Функция регистрации
 */

function register()
{
    
    if (! empty ($_POST)) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST, 'confirm-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($email === FALSE || $password === FALSE || $confirmPassword === FALSE) {
            return render ('account/register.php', [
                'email' => $email,
                'password' => $password,
                'confirmPassword' => $confirmPassword,
                'error_msg' => 'Неправильно заполнен один из параметров!'
            ]);
        }
        
        if ($password != $confirmPassword) {
            return render ('account/register.php', [
                'email' => $email,
                'password' => $password,
                'confirmPassword' => $confirmPassword,
                'error_msg' => 'Пароли не совпадают!'
            ]);
        }
        
        $sql = 
        '
            INSERT INTO `users`
            SET         `email`         = :email,
                        `password`      = :password,
                        `created_at`    = UNIX_TIMESTAMP()
        ';
        
        $params = [
            ':email' => $email,
            ':password' => hashPassword($password)
        ];
        
        $st = db_execute($sql, $params);
        
        if (!is_object($st)) {
            return render ('account/register.php', [
                'email' => $email,
                'password' => $password,
                'confirmPassword' => $confirmPassword,
                'error_msg' => $st
            ]);
        }
        
        return header ('Location: /account/login.php');
    }
    
    if (isset ($_SESSION['user_id']) && ! empty ($_SESSION['user_id'])) {
        return header ('Location: /index.php');
    }
    
    return render ('account/register.php', [
        'email' => '',
        'password' => '',
        'confimPassword' => ''
    ]);
}

/*
 * Функция подтверждения пароля
 */
function confirmPassword($hash, $password)
{
    return crypt($password, $hash) === $hash;
}

/*
 * Функция шифрования пароля
 */
function hashPassword($password)
{
    $salt = md5(uniqid('as191g1', true));
    $salt = substr(strtr(base64_encode($salt), '+', '.'), 0, 22);
    return crypt($password, '$2a$08$' . $salt);
}