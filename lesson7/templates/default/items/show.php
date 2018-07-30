<h2><a class="breads-link" href="/items/index.php?category_id=<?= $category_id ?>" title="В раздел Товары">Назад в Товары</a></h2>

<div class="item_info">
    <div class="item_image">
        <img src="/uploads/<?= $item['image_name'] ?>">
    </div>
    <div class="item_description">
        <h2>Цена:</h2>
        <?= $item['cost'] ?> руб.
        <br>
        <h2>Купить товар</h2>
        <div>
            Количество:<br>
            <input type="number" min="1" value="1" id="quantity">
        </div>
        <div>
            <br>
            
            <?php if (isset ($_SESSION['email'])) : ?>
            
                <button class="btn" type="button" data-itemid="<?= $item['id'] ?>">Добавить в корзину</button>
                
            <?php else : ?>
    
                Для покупки товара нужно выполнить <a href="/account/login.php">Вход</a> в систему.
    
            <?php endif; ?>
                
        </div>
        <br>
        <h2>Описание товара:</h2>
        <?= $item['descriptions'] ?>
    </div>
</div>
<div class="item-feedbacks">
    <h3>Отзывы о товаре:</h3>
    <div class="feedbacks">
        <?= renderItemFeedbacks($item['id']) ?>
    </div>
    <form class="add-form" method="POST" enctype="multipart/form-data">
        <div>
            Ваше имя:<br>
            <input type="text" name="name" required>
        </div>
        <div>
            Email:<br>
            <input type="email" name="email" required>
        </div>
        <div>
            Отзыв:<br>
            <textarea name="feedback" required></textarea>
        </div>
        <div>
            <button type="submit">Добавить отзыв</button>
        </div>
    </form>
</div>

<script language="JavaScript">
    $('.btn').on('click', function () {
        var quantity = parseInt ($('#quantity').val());
        var item_id = parseInt ($(this).data('itemid'));
        
        $.post({
            url: '/orders/add.php',
            dataType: 'json',
            data: {
                'item_id': item_id,
                'quantity': quantity,
            },
            success: function (data) {
                
                if (data.success === true) {
                    alert ('Товар добавлен!');
                    var nQ = parseInt ($('#order-cnt').html());
                    $('#order-cnt').html(nQ + quantity);
                } else {
                    alert (data.error_msg);
                }
            }
        });
    });
</script>