<?php require_once("common.php"); ?>


<?php if(!isset($_GET['title'])): ?>
    <?php if(!isset($_GET['update'])): ?>
        <p><?php echo translate("list"); ?></p>
        <form action="product.php" method="GET">
            <input type="text" name="title" placeholder = <?php echo translate('title'); ?> required/><br /><br />
            <input type="text" name="description" placeholder = <?php echo translate('desc'); ?> required/><br /><br />
            <input type="number" min="0" name="price" placeholder = <?php echo translate('price'); ?> required/><br /><br />
            <input type="file" name="image" accept="image/*" /><br /><br />
            <input type ="submit" value=<?php echo translate("listprod"); ?> /><br /><br />
        </form>
    <?php else: ?>
        <?php $list = getProduct($_GET['update']); ?>
        <p><?php echo translate("update"); ?></p>
        <form action="product.php" method="GET">
            <input type="text" name="title" value=<?php echo $list['title']; ?> placeholder = <?php echo translate('title'); ?> required/><br /><br />
            <input type="text" name="description" value=<?php echo $list['description']; ?> placeholder = <?php echo translate('desc'); ?> required/><br /><br />
            <input type="number" min="0" name="price" value=<?php echo $list['price']; ?> placeholder = <?php echo translate('price'); ?> required/><br /><br />
            <input type="file" name="image" accept="image/*"/><br /><br />
            <input type ="submit" value=<?php echo translate("save"); ?> /><br />
            <input type="hidden" name="update" value=<?php echo $_GET['update']; ?> />
        </form>
    <?php endif; ?>
<?php else: ?>
<?php
    $title = sanitize($_GET['title']);
    $description = sanitize($_GET['description']);
    $price = sanitize($_GET['price']);
    copy($_GET['image'],"media\\".$_GET['title']);
    $image = "media\\".sanitize($_GET['image']);

    if(isset($_GET['update'])){
        echo "Updating ";

        if(!($stmt = $link->prepare("update products p set p.title = (?), p.description = (?), p.price = (?), p.image = (?) where p.id = (?)"))){
            echo "Update Prepare error ".$link->error;
        }
        if(!($stmt->bind_param('ssdsd',$title,$description,$price,$image,$_GET['update']))){
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
        echo 'success';
        ?>
        <div><form method="GET" action = "admin.php"><input type = "submit" value=<?php echo translate("back"); ?>></form></div>
<?
    }
    ?>
<?php endif; ?>


