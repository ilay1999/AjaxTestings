<?php 
    session_start();
    include '../display/displayController.php';
?>

<html>
<head>
<meta charset="utf-8">
    <title>Тестовый вариант</title>
    <link rel="stylesheet" href="../csstemp/main.css"/>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/main.js"></script>
</head>
    <body>
        <div id="header" class="header">
            <div id="brow" class="brow">
                <a onclick="ResetCart('../')" href="#"><div id="cartButton" class="cartButton back-color-red"><p class="Manrope text-mid text-white">Очистить корзину</p></div></a>
                <div id="divCartCnt" class="divCartCnt back-color-white"><a href="index.php"><p id="CartCnt" class="Manrope text-mid text-black">Товаров в коризне: <b class="text-red"><?=count($_SESSION['cart'])?></b></p></a></div>
            </div>
        </div>
        <div id="mainDivStaffCart" class="mainDivStaffCart back-color-pinkGrey">
            <?php
                drawCart();
            ?>
        </div>
    </body>
</html>
