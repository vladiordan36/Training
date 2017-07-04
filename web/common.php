<?php
session_start();

require_once('config.php');

$link = mysqli_connect(DBSERVER, DBUSER, DBPASS, DBNAME);

if (!$link) {
    echo "Connection failed" . PHP_EOL . "<br />";
    echo "Error number: " . mysqli_connect_errno() . PHP_EOL . "<br />";
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

function getProducts(){
    global $link;
    return mysqli_query($link, "select * from products");

}

function checkout($mail){
    global $result;
    $msg = "Your Order:<br />";
    $total = 0;
    foreach($result as $row) {
        if(isset($_SESSION['cart'][$row['ID']])){
            if ($_SESSION['cart'][$row['ID']] > 0) {
                $msg = $msg . $_SESSION['cart'][$row['ID']] . 'x' . $row['title'] . ' : ' . $_SESSION['cart'][$row['ID']] * $row['price'] . '$<br />';
                $total = $total + $_SESSION['cart'][$row['ID']] * $row['price'];
            }
        }
    }
    $msg = $msg.'Total: '.$total.'$';
    mail($mail,"Order",$msg);
    $_SESSION['cart'] = array();
    echo $msg;
}


function cartIsEmpty() {
    return array_sum($_SESSION['cart']) == 0;
}

function sanitize($text){
    return  htmlentities(strip_tags($text));
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=array();
}

$translate = [
    "log" => "Login",
    "cart" => "Cart",
    "back" => "Back",
    "chkout" => "Checkout",
    "listprod" => "List Product",
    "tryagain" => "Try Again",
    "mail" => "mail",
    "email" => "Enter your email",
    "list" => "List product",
    "welcomeadmin" => "Welcome Admin",
    "welcomeuser" => "Welcome User",
    "notallowed" => "You shall not pass",
    "logout" => "Logout",
    "login" => "Login",
    "add" => "Add to cart",
    "user" => "Username",
    "pass" => "Password",
    "quantity" => "Quantity",
    "save" => "Save",
    "title" => "Title",
    "desc" => "Description",
    "price" => "Price",
    "url" => "Image URL",
    "empty" => "Your cart is empty."

];
function translate($text){
    global $translate;
    return isset($translate[$text]) ? $translate[$text] : $text;
};

