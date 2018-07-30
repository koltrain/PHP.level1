<html>
<head>
    <meta charset='utf-8' />
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <script src="/js/jquery/jquery-3.3.1.min.js"></script>
    <script defer src="/js/fontawesome/all.js"></script>
</head>
<body>
    <header class="main_head">
        <div class="container_head">
            
            <?php if (isset ($_SESSION['email'])) : ?> 
                
                Привет, <?= $_SESSION['email'] ?>!
                <br><a href="/orders/index.php">Корзина (<span id="order-cnt"><?= $_SESSION['orders']['count'] ?></span>)</a>
                <br><a href="/account/logout.php">Выйти</a>
                
            <?php else : ?>
                
                <a href="/account/login.php">Войти</a>
                
            <?php endif; ?>
            
        </div>
    </header>
    <div class="container">
        <?= $content ?>
    </div>
</body>
</html>