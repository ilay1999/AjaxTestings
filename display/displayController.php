<?php
    session_start();
    
    if(isset($_SESSION['cart'])){
    }else{$_SESSION['cart'] = [];};

    $Path = $_POST['path']??'';
    $Method = $_POST['func']??'0';
    $Filter = $_POST['filter']??'';
    $Page = $_POST['page']??'1';
    $ItemsPerPage = $_SESSION['ItemsPerPage']??'3';

    // Выгрузка товаров на страницу, принимает в себя 2
    function loadBatch($Page, $ItemsPerPage, $Filter){
        $prodArr = [];
        if(empty($_POST['path'])){
            require_once 'conf/DBConnect.php';
        }else{
            require_once '../conf/DBConnect.php';
        };
        if(!empty($Filter)){
            $products = mysqli_query($connect, "SELECT * FROM `staff`");
            while ($Data = mysqli_fetch_assoc($products)){
                if (strpos($Data['name'], $Filter)!==false){ 
                    array_push($prodArr, array(
                        'ID' => $Data['staffID'],
                        'name' => $Data['name'],
                        'img' => $Data['img']
                        )
                    );         
                }  
            };
        }else{
            $fromId = ($Page - 1) * $ItemsPerPage;
            $products = mysqli_query($connect, "SELECT * FROM `staff` ORDER BY `staffID` DESC LIMIT $fromId, $ItemsPerPage");
                
            while ($Data = mysqli_fetch_assoc($products)){
                array_push($prodArr, array(
                    'ID' => $Data['staffID'],
                    'name' => $Data['name'],
                    'img' => $Data['img']
                    )
                );
            };
        };
        return $prodArr;
    };
        //Отрисовка товара на странице
        function drawBatch($Page, $ItemsPerPage, $Filter){
            $prodArr = loadBatch($Page, $ItemsPerPage, $Filter);
            foreach($prodArr as $item){
                ?>
                    <div id="StaffDiv" class="StaffDiv">
                        <div id="ImgStaffDiv" class="ImgStaffDiv">
                            <img src="data:image/jpeg;base64,<?=base64_encode( $item['img'])?>"></img>
                            <input class="inpForCnt1" text_align="center" id="<?=$item['ID']?>" type="number" placeholder="Кол-во" min="0" max="100" step="1" >
                        </div>
                        <div class="StaffDivAction">
                            <p class="Manrope text-mid text-black"><?= $item['name']?></p>
                            <div id="ButtonStaffDiv" class="ButtonStaffDiv">
                                <a href="staff/index.php?productid=<?=$item['ID']?>"><div id="StaffButton" class="StaffButton back-color-red"><p class="Manrope text-mid text-white">Подробнее</p></div></a>
                                <a onclick="addToCart(<?= $item['ID']; ?>)" href="#"><div id="StaffButton" class="StaffButton back-color-red"><p class="Manrope text-mid text-white">В корзину</p></div></a>
                            </div>
                        </div>
                    </div>
                <?php
            };
        };
    //Запрашивает количество записей из базы и считает количество страниц с учетом количества отображаемых товаров на ней
    function pageCnt($ItemsPerPage){
        require 'conf/DBConnect.php';
            $products = mysqli_query($connect, "SELECT COUNT(*) FROM `staff`");
            $Items = mysqli_fetch_assoc($products);
            $allPages = ceil($Items['COUNT(*)'] / $ItemsPerPage);
        return $allPages;
    }
        function pageCntDraw($ItemsPerPage){
            $pgCnt = pageCnt($ItemsPerPage);
                while ($pgCnt != 0){
            ?>  
                    <div id="pageButton" class="pageButton back-color-white"><a onclick="swtichPage(<?= $pgCnt?>)" href="#"><p class="Manrope text-mid text-black"><?=$pgCnt?></p></a></div>
            <?php
                    $pgCnt = $pgCnt - 1;
                };
        }
    //Подгрузка  массива товаров
    function loadCart(){
        include '../conf/DBConnect.php';
        $prodArr = [];
        $ind = 0;
        foreach($_SESSION['cart'] as $item){
            $ID = $item['id'];
            $products = mysqli_query($connect, "SELECT * FROM `staff` WHERE `staffID`='$ID'");
            while ($Data = mysqli_fetch_assoc($products)){
                array_push($prodArr, array(
                    'ID' => $Data['staffID'],
                    'name' => $Data['name'],
                    'param1' => $Data['param1'],
                    'param2' => $Data['param2'],
                    'param3' => $Data['param3'],
                    'img' => $Data['img'],
                    'index' => $ind
                    )
                );
            };
            $ind++;
        };
        return $prodArr;
    };
        //Отрисовка товаров в корзине  на станице
        function drawCart(){
            $prodArr = loadCart();
            foreach($prodArr as $item){
                ?>
                    <div class="cartStaff back-color-white">
                        <img src="data:image/jpeg;base64,<?=base64_encode( $item['img'])?>">
                        <p><?=$item['name']?></p>
                        <p><?=$item['param1']?></p>
                        <p><?=$item['param2']?></p>
                        <p><?=$item['param3']?></p>
                        <a onclick="DeleteCartStaff(<?=$item['index']?>)" href="#"><p>Удалить</p></a>
                    </div>
                <?php
            };
        }
?>

<html>
    <?php
        switch ($Method) {
            case 1:
                drawBatch($Page, $ItemsPerPage, $Filter, $Path);
                break;
            case 2:
                drawCart();
                break;
            case 3:
                pageCntDraw($ItemsPerPage);
                break;
        };
    ?>
</html>