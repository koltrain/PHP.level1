<h2><a class="breads-link" href="index.php" title="В раздел Категории">Категории</a> > Добавление категории товаров</h2>

<div class="add-form">
    <form method="post" enctype="multipart/form-data">
        <div>
            Имя категории:<br>
            <input type="text" name="name" required>
        </div>
        <div>
            Видимость категории:<br>
            <input type="checkbox" name="visible" value="1">
        </div>
        <div>
            Позиция категории:
            <input type="number" name="position" value="1" min="1">
        </div>
        <div>
            Картинка (будет обрезана до 140px/140px):<br>
            <input type="file" name="image" required>
        </div>
        <div>
            <button type="submit">Создать</button>
        </div>
    </form>
</div>

