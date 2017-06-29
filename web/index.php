<?php
require_once('common.php');

$cart = array();

$result = mysqli_query($link, "select * from products");
#$row = mysqli_fetch_row($result);
foreach($result as $row){
    echo '<div style="float:left"><img src="'.$row["image"].'" style="height:15%"></img></div>
          <div><p>'.$row["title"].'</p></div>
          <div><p>'.$row["desc"].'</p></div>
          <div style = "margin-left:10%">
             <form method="POST" action = "index.php">
                <input type = "text" placeholder="Quantity" name="nr" required>
                <input type = "submit" Value="Add to cart">
             </form>
          </div>
          <div><p>'.$row["price"].'$</p></div>
          <div style="clear:both"><br/></div>';
}
if(isset($_POST['nr']))
    array_push($cart,$_POST['nr']);

$_SESSION['cart'] = $cart;
print_r($cart);
?>

<div style="float:left"><a href='login.php'>Login</a></div>
<div style="margin-left:5%"><a href='cart.php'>Cart</a></div>