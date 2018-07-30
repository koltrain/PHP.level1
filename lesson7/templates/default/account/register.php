<h2>Регистрация:</h2>

<?php if (isset ($error_msg)) : ?>
    <div class="error_msg"><?= $error_msg ?></div>
<?php endif; ?>

<form class="add-form" method="POST">
    <div>
        Email:<br>
        <input type="email" name="email" value="<?= $email ?>" required>
    </div>
    <div>
        Пароль:<br>
        <input type="password" name="password" value="<?= $password ?>" required minlength="8">
    </div>
    <div>
        Подтвердите пароль:<br>
        <input type="password" name="confirm-password" value="<?= $confirmPassword ?>" required minlength="8">
    </div>
    <div>
        <button type="submit">Зарегистрироваться</button>
    </div>
</form>