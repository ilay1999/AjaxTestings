<?php 
    class batchingDataDB{
        public $name;
        public $category;
        public $left;
        public $cost;

        public function __construct($getBatchArr){
            $this->name = $getBatchArr['name'];
            $this->category = $getBatchArr['category'];
            $this->left = $getBatchArr['left'];
            $this->cost = $getBatchArr['cost'];
        }
        public function __destruct(){
            print_r($this);
        }
    };

    function connect($name){
        try{
            $pdo = new PDO("mysql:host=127.0.0.1;dbname=products;port=3306;", "root", "");
        }catch(PDOException $exception){
            echo "Err: {$exception->getMessage()}";
        };
        $Data = $pdo->query("SELECT * FROM $name");
        return $Data;
    };

    function  displayProducts(){
        $displayResultArr = [];
        $Data = connect("prods");
        foreach($Data as $item){
            $product = new batchingDataDB($item);
            array_push($displayResultArr, $product);
        };
        return $displayResultArr;
    };
?>

<html>
    <pre>
        <?=print_r(displayProducts())?>
    </pre>
</html>