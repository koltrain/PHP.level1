<h2>Для совершения покупок нужно выполнить вход:</h2>

<?php if (isset ($error_msg)) : ?>
    <div class="error_msg"><?= $error_msg ?></div>
<?php endif; ?>

<form class="add-form" method="POST">
    <div>
        Логин:<br>
        <input type="email" name="email" value="<?= $email ?>" required>
    </div>
    <div>
        Пароль:<br>
        <input type="password" name="password" value="<?= $password ?>" required><br>
    </div>
    <div>
        <button type="submit">Войти</button> или <a href="/account/register.php">
            Зарегистрироваться
        </a>
    </div>
</form>

