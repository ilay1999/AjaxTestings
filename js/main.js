
// Сбросить всю корзину
function ResetCart(short) {
        $.ajax ({
            url: short + "cart/CartController.php",
            type: "POST",
            data: {
                func: 2                     // func для обращения по свичу в нужную функцию контроллера 
            },                
            dataType: "html",
            success:  function(data){
                renewCartCnt(data);
                redrawCart();
                }
        });
};
//Удаляет 1 товар из корзины, выбранный
function DeleteCartStaff(ID) {
    $.ajax ({
        url: "../cart/CartController.php",
        type: "POST",
        data: {
            func: 4,
            id: ID                     
        },                
        dataType: "html",
        success:  function(data){
            renewCartCnt(data);
            redrawCart();
            }
    });
};
// Добавить товар в корзину
function addToCart(Data) {
    let struct = document.getElementById(Data).value;
    //console.log(Data, struct);
        $.ajax ({
            url: "cart/CartController.php",
            type: "POST",
            data: {
                func: 1, 
                id: Data, 
                cnt: struct
            },
            dataType: "html",
            beforeSend: "",
            success:  function(data){
                renewCartCnt(data);
                }
        });
};
// Проверяет корзину на наличие товаров в ней
function checkCart() {
    let path = "cart/CartController.php";
        $.ajax ({
            url: path,
            type: "POST",
            data: {
                func: 3
            },
            dataType: "html",
            beforeSend: "",
            success:  function(data){
                renewCartCnt(data);
                }
        });
};
    // Обновляет номер колчиества товаров на значке корзины
    function renewCartCnt(Data){
        destroy('CartCnt');
        document.getElementById('CartCnt').innerHTML = "Товаров в коризне: " + '<b class="text-red">' + Data + '</b>';
    };
// Переход на сл страницу товаров
function swtichPage(Page){
    $.ajax ({
        url: "display/displayController.php",
        type: "POST",
        data: {
            func: 1,
            page: Page,
            ItemsPerPage: "",
            path: 1
        },
        beforeSend: destroy("mainDivStaff"),
        success:  function (render){
                //console.log(render);
                $('#mainDivStaff').html(render);
            }
    });
};
//Запрос на перерисовку страниц с товаром
    function drawPages(){
        let page = document.getElementById("pageNm").html;
        $.ajax ({
            url: "display/displayController.php",
            type: "POST",
            data: {
                func: 1,
                page: Page,
                ItemsPerPage: ""
            },
            success:  function (render){
                    //console.log(render);
                    $('#pageNm').html(render);
                }
        });
    };
// Поиск товара по наиболее совпавшим
var tick;    
function findStaff()
{
  if(tick){
    clearTimeout(tick);
    tick = setTimeout(filterTrigger, 1000);
  }else{
    tick = setTimeout(filterTrigger, 1000);
  }
};
    function filterTrigger(){
        let stf = document.getElementById("SearchFilter").value;
        if(stf !== null && stf !== ''){
            $.ajax ({
                url: "display/displayController.php",
                type: "POST",
                data: {
                    func: 1,
                    page: "",
                    ItemsPerPage: "",
                    filter: stf,
                    path: '../conf/DBConnect.php'
                },
                success: function (render){
                        $('#mainDivStaff').html(render);
                    }
            });
        }else{
            $.ajax ({
                url: "display/displayController.php",
                type: "POST",
                data: {
                    func: 1,
                    path: '../conf/DBConnect.php'
                },
                success: function (render){
                        $('#mainDivStaff').html(render);
                    }
            });
        };
    };
// Переотрисовкакорзины после удаления товара
function redrawCart(){
    $.ajax ({
        url: "../display/displayController.php",
        type: "POST",
        data: {
            func: 2
        },
        beforeSend: destroy("mainDivStaffCart"),
        success:  function (render){
                //console.log(render);
                $('#mainDivStaffCart').html(render);
            }
    });
};
// Фукнция созданная для очистки элементов используется практически всегда 
function destroy(destroyTo){
    document.getElementById(destroyTo).innerHTML = "";
};
