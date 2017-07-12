<?php
session_start();

require_once('config.php');

$link = mysqli_connect(DBSERVER,DBUSER, DBPASS, DBNAME);

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
    global $link;
    $id = sanitize($id);

    $stmt = $link->prepare("select * from products where ID=(?)");
    $stmt->bind_param('d',$id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function checkout($mail,$result){
    $msg = translate("order")."<br /><br />";
    $total = 0;
    foreach($result as $row) {
        if(isset($_SESSION['cart'][$row['ID']])){
            if ($_SESSION['cart'][$row['ID']] > 0) {
                $msg = $msg . $_SESSION['cart'][$row['ID']] . ' x ' . $row['title'] . ' : ' . $_SESSION['cart'][$row['ID']] * $row['price'] . '$<br />';
                $total = $total + $_SESSION['cart'][$row['ID']] * $row['price'];
            }
        }
    }
    $msg = $msg.' <br /> Total: '.$total.'$';
    $msg = sanitize($msg);
    mail($mail,"Order",$msg,"From: shop1@local.com");
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
    "new" => "Add product",
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
    "invalid file" => "File is invalid! Try again with a different file.",
    "cpyerr" => "Upload error! Try again.",
    "order" => "Your order: "

];
function translate($text){
    global $translate;
    return isset($translate[$text]) ? $translate[$text] : $text;
};

function validateFile($file){
    if(file_exists($file) || $_FILES['image']['size'] > 5000000
        || !preg_match('/image\/.*/', $_FILES["image"]["type"])
        || $_FILES['image']['error'] > 0){
            echo $_FILES['image']['type'];
            return false;
    }
    else{
        return true;
    }
}

