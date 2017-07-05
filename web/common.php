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
function getProduct($id){
    $res = getProducts();
    foreach($res as $row){
        if($row['ID'] == $id){
            return $row;
        }
    }

}

function checkout($mail){
    global $result;
    $msg = "Your Order:<br /><br />";
    $total = 0;
    foreach($result as $row) {
        if(isset($_SESSION['cart'][$row['ID']])){
            if ($_SESSION['cart'][$row['ID']] > 0) {
                $msg = $msg . $_SESSION['cart'][$row['ID']] . ' x ' . $row['title'] . ' : ' . $_SESSION['cart'][$row['ID']] * $row['price'] . '$<br />';
                $total = $total + $_SESSION['cart'][$row['ID']] * $row['price'];
            }
        }
    }
    $msg = $msg.'<br />Total: '.$total.'$';
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
    "empty" => "Your cart is empty.",
    "delete" => "Delete",
    "update" => "Edit",
    "save" => "Save",
    "invalid file" => "File is invalid! The image will be set by default.",
    "cpyerr" => "Copy error! The image will be set by default."

];
function translate($text){
    global $translate;
    return isset($translate[$text]) ? $translate[$text] : $text;
};

function validateFile($file){
    $ext = pathinfo($file,PATHINFO_EXTENSION);
    if(file_exists($file) || $_FILES['image']['size'] > 5000000 || ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif" ) || $_FILES['image']['error'] > 0){
        return false;
    }
    else{
        return true;
    }
}
function getSumId(){
    global $link;
    $max_result = mysqli_query($link,"select sum(id) as value_sum from products;");
    $max_row = mysqli_fetch_assoc($max_result);
    $max = $max_row['value_sum'];
    return $max;
}
