<?php
require_once("common.php");

if(isset($_GET['id'])){
    $option = "delete from products where id=".$_GET['id'].";";
    if(!mysqli_query($link,$option))
        echo mysqli_error($link);
}
header("Location:admin.php");

