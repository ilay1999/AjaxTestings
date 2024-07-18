<?php 
    session_start();

    $Method = $_POST['func']??'0';

    switch ($Method) {
        case 1:
            AddToCart();
            break;
        case 2:
            ResetCart();
            break;
        case 3:
            reCnt();
            break;
        case 4:
            delOne();
            break;
    };
    //Добавить позицию в корзину
    function AddToCart(){
        array_push($_SESSION['cart'], array(
            'id' => $_POST['id'],
            'cnt' => $_POST['cnt']
        ));
        return reCnt();
    };
    //Сбросить всю корзину
    function ResetCart(){
        $_SESSION['cart']  = [];
        return reCnt();
    };
    //Удалить выбранный пункт из корзины по ИД
    function delOne(){
        $cartArr = [];
        $index = $_POST['id'];
        foreach($_SESSION['cart'] as $item){
            unset($_SESSION['cart'][$index]);
        };
        foreach ($_SESSION['cart'] as $item){
            array_push($cartArr, array(
                'id' => $item['id'],
                'cnt' => $item['cnt']
            ));
        };
        $_SESSION['cart'] = $cartArr;
        reCnt();
    };
    //Пересчет позиций в корзине
    function reCnt(){
        $cnt =  count($_SESSION['cart']);
        echo $cnt;
        return $cnt;
    };
?>