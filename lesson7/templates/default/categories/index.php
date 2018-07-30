<h2>Категории товаров</h2>

<div class="categories">

<?php if (count ($categories) > 0) : ?>

    <?php foreach ($categories as $category) : ?>

        <div class="category">
            <a href="/items/index.php?category_id=<?= $category['id'] ?>" title="<?= $category['name'] ?>">
            <img src="/uploads/<?= $category['image_name'] ?>" alt="<?= $category['name'] ?>">
            <br><?= $category['name'] ?></a>
            <a class="category-action" href="/categories/edit.php?id=<?= $category['id'] ?>" title="Редактировать">
            <i class="fas fa-edit"></i></a>&nbsp;
            <a class="category-action" href="/categories/delete.php?id=<?= $category['id'] ?>" title="Удалить">
            <i class="fas fa-times-circle"></i></a>
        </div>

    <?php endforeach; ?>

<?php endif; ?>

<div class="category category-add">
    <a href="/categories/add.php" title="Добавить новую категорию">
        <i class="fas fa-9x fa-plus-circle"></i></a>
</div>