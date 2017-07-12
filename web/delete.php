<?php
require_once("common.php");
if(isset($_SESSION['admin'])){
    if(isset($_GET['id'])){
        $stmt = "";
        $id = sanitize($_GET['id']);
        if(!($stmt = $link->prepare("delete from products where ID=(?)"))){
            echo "Update Prepare error ".$link->error;
        }
        if(!($stmt->bind_param('d',$id))){
            echo "Update Bind error ".$link->error;
        }
        $result = getProduct($id);
        unlink($result['image']);

        if (!($stmt->execute())) {
            echo "Execute error " . $link->error;
        }
    }
}
header("Location:admin.php");

