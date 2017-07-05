<?php require_once("common.php"); ?>


<?php if(!isset($_POST['title'])): ?>
    <?php if(!isset($_GET['update'])): ?>
        <p><?php echo translate("list"); ?></p>
        <form action="product.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder = <?php echo translate('title'); ?> required/><br /><br />
            <input type="text" name="description" placeholder = <?php echo translate('desc'); ?> required/><br /><br />
            <input type="number" min="0" name="price" placeholder = <?php echo translate('price'); ?> required/><br /><br />
            <input type="file" name="image" accept="image/*" /><br /><br />
            <input type ="submit" value=<?php echo translate("listprod"); ?> /><br /><br />
        </form>
    <?php else: ?>
        <?php $list = getProduct($_GET['update']); ?>
        <p><?php echo translate("update"); ?></p>
        <form action="product.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" value=<?php echo $list['title']; ?> placeholder = <?php echo translate('title'); ?> required/><br /><br />
            <input type="text" name="description" value=<?php echo $list['description']; ?> placeholder = <?php echo translate('desc'); ?> required/><br /><br />
            <input type="number" min="0" name="price" value=<?php echo $list['price']; ?> placeholder = <?php echo translate('price'); ?> required/><br /><br />
            <input type="file" name="image" accept="image/*"/><br /><br />
            <input type ="submit" value=<?php echo translate("save"); ?> /><br />
            <input type="hidden" name="update" value=<?php echo $_GET['update']; ?>/>
        </form>
    <?php endif; ?>
<?php else: ?>
<?php
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $price = sanitize($_POST['price']);

    if(!validateFile($_FILES['image']['name']) || empty($_FILES['image'])){
        echo translate("invalid file")."<br />";
        $image = "media\\default.jpg";
    }
    else{
        $image = "media/".sanitize($_POST['title'].uniqid(rand(5,10)).".".pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
        $source = $_FILES['image']['tmp_name'];

        if(!copy($source,$image)){
            echo "Copy error! The image will be set by default. <br />";
            $image = "media\\default.jpg";
        }
    }

    if(isset($_POST['update'])){
        echo "Updating ";

        if(!($stmt = $link->prepare("update products p set p.title = (?), p.description = (?), p.price = (?), p.image = (?) where p.id = (?)"))){
            echo "Update Prepare error ".$link->error;
        }
        if(!($stmt->bind_param('ssdsd',$title,$description,$price,$image,$_POST['update']))){
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
        <div><form method="POST" action = "admin.php"><input type = "submit" value=<?php echo translate("back"); ?>></form></div>
<?
    }
    ?>
<?php endif; ?>


