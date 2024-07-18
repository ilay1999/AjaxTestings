<?php 
    //Здесь вывод не вынесен в контроллер т.к. смысла не было ведь уже продемонстрировал ранее,стоит так как оно есть просто чтобы работало (для демонстрации).
    // Для хранения Get параметра, если  ничего не поступило ставит 0
    session_start();
    $ChosenID = $_GET['productid']??'0';

    // Выгрузка товара на страницу со всеми параметрами
    function loadBatch($filter){
        $prodArr = [];

        require_once '../conf/DBConnect.php';

        $products = mysqli_query($connect, "SELECT * FROM `staff` WHERE `staffID`='$filter'");
        while ($Data = mysqli_fetch_assoc($products)){
            array_push($prodArr, array(
                'ID' => $Data['staffID'],
                'name' => $Data['name'],
                'param1' => $Data['param1'],
                'param2' => $Data['param2'],
                'param3' => $Data['param3'],
                'descript' => $Data['descript'],
                'img' => $Data['img']
                )
            );
        };
        return $prodArr;
    };
?>

<html>
<head>
<meta charset="utf-8">
    <title>Тестовый вариант</title>
    <link rel="stylesheet" href="../csstemp/main.css"/>
    <script src="..js/jquery-3.7.1.min.js"></script>
    <script src="..js/main.js"></script>
</head>
    <body>
        <div id="header" class="header">
            <div id="brow" class="brow">
                <a onclick="ResetCart()" href="#"><div id="cartButton" class="cartButton back-color-red"><p class="Manrope text-mid text-white">Очистить корзину</p></div></a>
                <div id="divCartCnt" class="divCartCnt back-color-white"><p id="CartCnt" class="Manrope text-mid text-black">Товаров в коризне: <b class="text-red"><?=count($_SESSION['cart'])?></b></p></div>
            </div>
        </div>
        <div id="mainDivStaff" class="mainDivStaff">
            <?php
                $prodArr = loadBatch($ChosenID);
                foreach($prodArr as $item){
                    ?>
                        <div id="" class="">
                            <div id="ImgStaffDiv" class="ImgStaffDiv"><img src="data:image/jpeg;base64,<?=base64_encode( $item['img'])?>"></img></div>
                            <div id="StaffParams" class="StaffParams"><p class="Manrope text-black"><b class="text-red">Название:</b> <?= $item['name']?></p></div>
                            <div id="StaffParams" class="StaffParams"><p class="Manrope text-black"><b class="text-red">Параметр 1:</b> <?= $item['param1']?></p></div>
                            <div id="StaffParams" class="StaffParams"><p class="Manrope text-black"><b class="text-red">Параметр 2:</b> <?= $item['param2']?></p></div>
                            <div id="StaffParams" class="StaffParams"><p class="Manrope text-black"><b class="text-red">Параметр 3:</b> <?= $item['param3']?></p></div>
                            <div id="StaffParams" class="StaffParams"><p class="Manrope text-mid text-black"><b class="text-red">Описание:</b><?= $item['descript']?></p></div>
                            <div id="StaffParams" class="StaffParams"><input class="inpForCnt1" text_align="center" id="<?=$item['ID']?>" type="number" placeholder="Кол-во" min="0" max="100" step="1" ></div>
                            <div id="ButtonStaffDiv" class="ButtonStaffDiv">
                                <a onclick="addToCart(<?= $item['ID']?>)" href="#"><div id="StaffButton" class="StaffButton back-color-red"><p class="Manrope text-mid text-white">В корзину  (Не подключена, просто для демонстрации)</p></div></a>
                            </div>
                        </div>
                    <?php
                };
            ?>
        </div>
    </body>
</html>
