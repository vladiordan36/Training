<?php require_once("common.php"); ?>


<?php if(!isset($_POST['title'])): ?>

    <?php if(isset($_GET['update'])){ $list = getProduct($_GET['update']); } ; ?>
    <p><?php echo isset($_GET['update']) ? translate("update") : translate("new"); ?></p>
    <p><?php echo isset($_GET['error']) ? translate("invalid file"): NULL; ?></p>
    <form action="product.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" value="<?php echo isset($_GET['update']) ? $list['title'] : NULL; ?>" placeholder = "<?php echo translate('title'); ?>" required="required"/><br /><br />
        <input type="text" name="description" value="<?php echo isset($_GET['update']) ? $list['description']: NULL; ?>" placeholder = "<?php echo translate('desc'); ?>" required="required"/><br /><br />
        <input type="number" min="0" name="price" value="<?php echo isset($_GET['update']) ? $list['price']: NULL; ?>" placeholder = "<?php echo translate('price'); ?>" required="required"/><br /><br />
        <input type="file" name="image" accept="image/*"/><br /><br />
        <input type ="submit" value="<?php echo isset($_GET['update']) ? translate("save") : translate("new"); ?>" /><br />
        <input type="hidden" name="update" value="<?php echo isset($_GET['update']) ? $_GET['update']: NULL; ?>"/>
    </form>

<?php else: ?>
<?php
    $title = sanitize($_POST['title']);
    $title = preg_replace("/[^A-Za-z0-9 ]/", '', $title);
    $description = sanitize($_POST['description']);
    $price = sanitize($_POST['price']);

    if(!validateFile($_FILES['image']['name']) || empty($_FILES['image'])) {
        echo translate("invalid file") . "<br />";
        unset($_POST['title']);
        if (isset($_POST['update']) && !empty($_POST['update'])) {
            header("Location:product.php?error=invalid_file&update=".$_POST['update']);
        }
        else{
            header("Location:product.php?error=invalid_file");
        }
    }
    else {
        $image = "media/" . sanitize( uniqid(rand(5, 10)) . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $source = $_FILES['image']['tmp_name'];

        if (!move_uploaded_file($source, $image)) {
            echo "Copy error! The image will be set by default. <br />";
            $image = "media\\default.jpg";
        }


        if (isset($_POST['update']) && !empty($_POST['update'])) {
            echo "Updating ";

            if (!($stmt = $link->prepare("update products p set p.title = (?), p.description = (?), p.price = (?), p.image = (?) where p.id = (?)"))) {
                echo "Update Prepare error " . $link->error;
            }
            if (!($stmt->bind_param('ssdsd', $title, $description, $price, $image, $_POST['update']))) {
                echo "Update Bind error " . $link->error;
            }
        } else {
            echo "Inserting ";
            if (!($stmt = $link->prepare("Insert into products (title,description,price,image) values (?,?,?,?)"))) {
                echo "Prepare error " . $link->error;
            }
            if (!($stmt->bind_param('ssds', $title, $description, $price, $image))) {
                echo "Bind error " . $link->error;
            }
        }

        if (!($stmt->execute())) {
            echo "Execute error " . $link->error;
        } else {
            echo 'success';
            ?>
            <div><a href="admin.php"><?php echo translate("back"); ?></a></div>
            <?
        }
    }
    ?>
<?php endif; ?>


