<h2><a class="breads-link" href="/index.php" title="В раздел Категории">Назад в Категории</a></h2>

<div class="items">

<?php if (count ($items) > 0) : ?>

    <?php foreach ($items as $item) : ?>

        <div class="item">
            <a href="/items/show.php?item_id=<?= $item['id'] ?>&category_id=<?= $category_id ?>" title="<?= $item['name'] ?>">
            <img src="/uploads/thumbs/<?= $item['image_name'] ?>" alt="<?= $item['name'] ?>">
            <br><?= $item['name'] ?></a>
            <a class="item-action" href="/items/edit.php?id=<?= $item['id'] ?>&category_id=<?= $category_id ?>" title="Редактировать">
            <i class="fas fa-edit"></i></a>&nbsp;
            <a class="item-action" href="/items/delete.php?id=<?= $item['id'] ?>&category_id=<?= $category_id ?>" title="Удалить">
            <i class="fas fa-times-circle"></i></a>
        </div>

    <?php endforeach; ?>

<?php endif; ?>

    <div class="item item-add">
        <a href="add.php?category_id=<?= $category_id ?>" 
           title="Добавить новый товар"><i class="fas fa-9x fa-plus-circle"></i></a>
    </div>

</div>