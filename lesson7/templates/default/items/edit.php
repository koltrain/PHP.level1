<h2><a class="breads-link" href="items.php?category_id=<?= $category_id ?>" title="В раздел Товары">Товары</a> > Редактирование товара <?= $item_data['name'] ?></h2>
<div class="add-form">
    <form method="post" enctype="multipart/form-data">
        <div>
            Имя товара:<br>
            <input type="text" name="name" value="<?= $item['name'] ?>" required>
        </div>
        <div>
            Цена товара:<br>
            <input type="text" name="cost" value="<?= $item['cost'] ?>" required>
        </div>
        <div>
            Описание товара:<br>
            <textarea name="description" required><?= $item['descriptions'] ?></textarea>
        </div>
        <div>
            Видимость товара:<br>
            <input type="checkbox" name="visible" <?= $item['is_visible'] == 1 ? 'checked' : '' ?> value="1">
        </div>
        <div>
            Позиция товара:
            <input type="number" name="position" value="<?= $item['position'] ?>" min="1">
        </div>
        <div>
            Главная картинка (если не загружать, то останется прежняя):<br>
            <img src="/uploads/thumbs/<?= $item['image_name'] ?>" alt="<?= $item['name'] ?>"><br><br>
            <input type="file" name="main_image">
        </div>
        <div>
            <button type="submit">Изменить</button>
        </div>
    </form>
</div>