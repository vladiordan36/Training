<?php
session_start();

require_once('config.php');

$link = mysqli_connect(DBSERVER, DBUSER, DBPASS, DBNAME);
$result = mysqli_query($link, "select * from products");

if (!$link) {
    echo "Connection failed" . PHP_EOL . "<br />";
    echo "Error number: " . mysqli_connect_errno() . PHP_EOL . "<br />";
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$cart = array();
$mail = "";

function getCart(){
    global $cart;
    $cart=array();
    if(isset($_SESSION['cart']))
        for($i =0;$i<count($_SESSION['cart']);$i++){
            array_push($cart,$_SESSION['cart'][$i]);
        }
    else
        $cart = arrayInit();
}

function arrayInit(){
    $carts=array();
    global $result;
    foreach($result as $line){
        array_push($carts,0);
    }
    return $carts;
}

function checkout($mail){
    global $result,$cart;
    $msg = "Your Order:<br />";
    $total = 0;
    foreach($result as $row){
        if($cart[$row['ID']-1] > 0) {
            $msg = $msg.$cart[$row['ID']-1].'x'.$row['title'].' : '.$cart[$row['ID']-1]*$row['price'].'<br />';
            $total = $total + $cart[$row['ID']-1]*$row['price'];
        }
    }
    $msg = $msg.'Total: '.$total;
    mail($mail,"Order",$msg);
    $cart = arrayInit();
    $_SESSION['cart']=$cart;
    echo $msg;
}

function emptyCart(){
    global $cart;
    for($I=0;$I<count($cart);$I++)
        if($cart[$I]!=0)
            return 0;
    return 1;
}

getCart();
