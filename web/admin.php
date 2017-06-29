<?php
function name() {
    return 'Vlad';
}

echo 'My name is: '. name();
$cart = $_SESSION['cart'];
print_r($cart);
?>
<div><a href='login.php'>Logout</a></div>