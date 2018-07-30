<h2>Корзина:</h2>
<br>

<?php if (count ($orders) == 0) : ?>

    Корзина пока пустая.

<?php else : ?>
    
    <table width="100%" border="1" cellspacing=0>
        <thead>
            <td>№</td>
            <td>Наименование товара</td>
            <td>Количество</td>
            <td>Цена (1 шт.)</td>
            <td>Стоимость</td>
            <td>&nbsp</td>
        </thead>
        <tfoot>
            <td colspan="2">Итого:</td>
            <td><?= $allCnt ?></td>
            <td colspan="2"><?= $allCost ?></td>
            <td>&nbsp;</td>
        </tfoot>
        <tbody>
    
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?= $order['i'] ?></td>
                    <td><?= $order['name'] ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td><?= $order['cost'] ?></td>
                    <td><?= $order['price'] ?></td>
                    <td><a class="del-link" data-itemid="<?= $order['item_id'] ?>" href="javascript:void(0);">Удалить</a></td>
                </tr>
        
            <?php endforeach; ?>
    
        </tbody>
    </table>

    <script language="JavaScript">
        $('.del-link').on('click', function () {

            var item_id = parseInt ($(this).data('itemid'));

            $.post({
                url: '/orders/delete.php',
                dataType: 'json',
                data: {
                    'item_id': item_id
                },
                success: function (data) {

                    if (data.success === true) {
                        alert ('Товар удален!');
                        document.location.reload(true);
                    } else {
                        alert (data.error_msg);
                    }
                }
            });
        });
    </script>
    
<?php endif; ?>
