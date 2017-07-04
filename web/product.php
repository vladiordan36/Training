<?php require_once("common.php"); ?>


<?php if(!isset($_GET['title'])) :?>
    <p>List an Item</p>
    <form action="product.php" method="GET">
        <input type="text" name="title" placeholder = <?php echo translate('title'); ?> required/>
        <input type="text" name="description" placeholder = <?php echo translate('desc'); ?> required/>
        <input type="number" min="0" name="price" placeholder = <?php echo translate('price'); ?> required/>
        <input type="file" name="image" placeholder = <?php echo translate('url'); ?> required/>
        <input type ="submit" value=<?php echo translate("listprod");?> />
    </form>

<?php else:?>
<?
    $title = sanitize($_GET['title']);
    $description = sanitize($_GET['description']);
    $price = sanitize($_GET['price']);
    $image = "media\\\\".sanitize($_GET['image']);

    if(isset($_SESSION['update'])){
        echo "Updating ";
         if(!($stmt = $link->prepare("update products p set p.title = (?), p.description = (?), p.price = (?), p.image = (?) where p.id = (?)"))){
            echo "Update Prepare error ".$link->error;
        }
        if(!($stmt->bind_param('ssdsd',$title,$description,$price,$image,$_SESSION['update']))){
            echo "Update Bind error ".$link->error;
        }
    }
    else {
        echo "Inserting ";

        if (!($stmt = $link->prepare("Insert into products (title,description,price,image) values (?,?,?,?)"))) {
            echo "Prepare error " . $link->error;
        }
        if (!($stmt->bind_param('ssds', $title,$description,$price,$image))) {
            echo "Bind error " . $link->error;
        }
    }
    if (!($stmt->execute())) {
        echo "Execute error " . $link->error;
    }
    else {
        unset($_SESSION['update']);
        echo 'Success 
        <div><form method="GET" action = admin.php><input  type = "submit" Value='.translate("back").'></form></div>';

    }
    ?>
<?php endif; ?>


