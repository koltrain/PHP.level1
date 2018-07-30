<h2><a class="breads-link" href="/index.php" title="В раздел Категории">Категории</a> > Редактирование категории товаров</h2>

<div class="add-form">
    <form method="post" enctype="multipart/form-data">
        <div>
            Имя категории:<br>
            <input type="text" name="name" value="<?= $category['name'] ?>" required>
        </div>
        <div>
            Видимость категории:<br>
            <input type="checkbox" name="visible" <?= $category['is_visible'] == 1 ? 'checked' : '' ?> value="1">
        </div>
        <div>
            Позиция категории:
            <input type="number" name="position" value="<?= $category['position'] ?>" min="1">
        </div>
        <div>
            Картинка (если не загружать, то останется прежняя):<br>
            <img src="/uploads/<?= $category['image_name'] ?>" alt="<?= $category['name'] ?>"><br><br>
            <input type="file" name="image">
        </div>
        <div>
            <button type="submit">Изменить</button>
        </div>
    </form>
</div>

