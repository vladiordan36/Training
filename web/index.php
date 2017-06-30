<?php
require_once('common.php');

$_SESSION['admin'] = "nope";

foreach($result as $row){
    echo '<div style="float:left"><img src="'.$row["image"].'" style="height:15%"></img></div>
          <div><p>'.$row['ID'].'.'.$row["title"].'</p></div>
          <div><p>'.$row["desc"].'</p></div>
          <div style = "margin-left:10%">
             <form method="POST" action = "index.php">
                <input type = "text" placeholder="Quantity" name='.$row['ID'].' required>
                <input  type = "submit" Value="Add to cart">
             </form>
          </div>
          <div><p>'.$row["price"].'$</p></div>
          <div style="clear:both"><br/></div>';
}
foreach($result as $row)
    if(isset($_POST[$row['ID']]))
        $cart[$row['ID']-1] += $_POST[$row['ID']];

$_SESSION['cart'] = $cart;

echo '<br/>
<div style="float:left"><form method="POST" action = "login.php"><input  type = "submit" Value="Login"></form></div>
<div><form method="POST" action = "cart.php"><input  type = "submit" Value="Cart"></form></div>';

mysqli_close($link);
