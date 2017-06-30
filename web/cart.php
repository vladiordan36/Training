<?php
require_once('common.php');

$_SESSION['admin'] = "nope";
foreach($result as $row)
    if(isset($_POST[$row['ID']]))
        $cart[$row['ID']-1] -= $_POST[$row['ID']];
$_SESSION['cart'] = $cart;

if(isset($_POST['mail']))
    checkout($_POST['mail']);

foreach($result as $row){
    if($cart[$row['ID']-1] > 0){
        echo '<div style="float:left"><img src="'.$row["image"].'" style="height:15%"></img></div>
              <div><p>'.$row['ID'].'.'.$row["title"].'</p></div>
              <div><p>'.$row["desc"].'</p></div>
              
              <div style = "margin-left:10%">
                 <form method="POST" action = "cart.php">
                    <input type = "text" placeholder="Quantity" name='.$row['ID'].' value="'.$cart[$row['ID']-1].'" required>
                    <input  type = "submit" Value="Remove from cart">
                 </form>
              </div>
              
              <div><p>'.$row["price"].'$ * '.$cart[$row['ID']-1].'pc. = '.$row["price"]*$cart[$row['ID']-1].'$</p></div>
              <div style="clear:both"><br/></div>';
    }
}

mysqli_close($link);



echo '<br />
<div style="float:left"><form method="POST" action = "index.php"><input  type = "submit" Value="<--Back"></form></div>';
if(!emptyCart()){
    echo '<div><form method="POST" action = cart.php>
            <input  type = "submit" Value="Checkout-->">
            <input  type = "text" name="mail" placeholder="Enter eMail">
        </form></div>';
}
