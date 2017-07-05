<?php
require_once("common.php");

if(isset($_GET['id'])){
    $option = "delete from products where id=".$_GET['id'].";";

    $result = getProduct($_GET['id']);
    unlink($result['image']);

    if(!mysqli_query($link,$option)){
        echo mysqli_error($link);
    }
}
header("Location:admin.php");

