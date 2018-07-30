<h2><a class="breads-link" href="items.php?category_id=<?= $category_id ?>" title="В раздел Товары">Товары</a> > Добавление товара в категорию</h2>
<div class="add-form">
    <form method="post" enctype="multipart/form-data">
        <div>
            Имя товара:<br>
            <input type="text" name="name" required>
        </div>
        <div>
            Цена товара:<br>
            <input type="text" name="cost" required>
        </div>
        <div>
            Описание товара:<br>
            <textarea name="description" required></textarea>
        </div>
        <div>
            Видимость товара:<br>
            <input type="checkbox" name="visible" value="1">
        </div>
        <div>
            Позиция товара:
            <input type="number" name="position" value="1" min="1">
        </div>
        <div>
            Картинка:<br>
            <input type="file" name="main_image" required>
        </div>
        <div>
            <button type="submit">Создать</button>
        </div>
    </form>
</div>
