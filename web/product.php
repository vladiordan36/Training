<?php
require_once("common.php");

$_SESSION['admin'] = "nope";
if(!isset($_GET['title'])) {
    echo 'List an Item
    <form action="product.php" method="GET">
        <input type="text" name="title" placeholder = "Enter Title" required/>
        <input type="text" name="desc" placeholder = "Enter Description" required/>
        <input type="text" name="price" placeholder = "Enter Price" required/>
        <input type="file" name="image" placeholder = "Enter Image URL" required/>
        <input type ="submit" value="List Product" />
    </form>';
}
else{
    if(isset($_SESSION['update'])){
        $insert = "update products p set p.title='".$_GET['title']."', p.desc='".$_GET['desc']."', p.price=".$_GET['price'].", p.image='media\\\\".$_GET['image']."' where p.id=".$_SESSION['update'].";";
        unset($_SESSION['update']);
    }
    else
        $insert = "insert into products values (".(count($cart)+1).","."'".$_GET['title']."','".$_GET['desc']."',".$_GET['price'].",'media\\\\".$_GET['image']."'".");";

    if (mysqli_query($link,$insert)) {
        echo 'Success 
        <div><form method="POST" action = admin.php><input  type = "submit" Value="Back"></form></div>';
    }
    else {
        echo 'Error: ' . $insert . '<br>' . mysqli_error($link)."<br />".
        '<div style="float:left"><form method="POST" action = product.php><input  type = "submit" Value="Try again"></form></div>
        <div><form method="POST" action = admin.php><input  type = "submit" Value="Back"></form></div>';
    }
}

mysqli_close($link);

