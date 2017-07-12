<?php require_once("common.php"); ?>
<?php
if(isset($_GET['update'])){
    $_SESSION['update'] = $_GET['update'];
    unset($_SESSION['error']);
}
?>

<?php if(isset($_POST['title'])): ?>
    <?php
    $title = sanitize($_POST['title']);
    $title = preg_replace("/[^A-Za-z0-9 ]/", '', $title);
    $description = sanitize($_POST['description']);
    $price = sanitize($_POST['price']);

    if(!validateFile($_FILES['image']['name']) || empty($_FILES['image'])) {
        $_SESSION['error']= "true";
    }
    else {
        $image = "media/" . sanitize( uniqid(rand(5, 10)) . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $source = $_FILES['image']['tmp_name'];
        unset($_POST['title']);
        if (!move_uploaded_file($source, $image)) {
            echo translate("cpyerr") ."<br />";
            $image = "media\\default.jpg";
        }


        if (isset($_SESSION['update']) && !empty($_SESSION['update'])) {
            echo "Updating ";

            if (!($stmt = $link->prepare("update products p set p.title = (?), p.description = (?), p.price = (?), p.image = (?) where p.ID = (?)"))) {
                echo "Update Prepare error " . $link->error;
            }
            if (!($stmt->bind_param('ssdsd', $title, $description, $price, $image, $_SESSION['update']))) {
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
            unset($_SESSION['update']);
            unset($_SESSION['error']);
        }
    }
    ?>
<?php else: ?>

    <?php
        if(isset($_SESSION['update'])) {
            $list = getProduct($_SESSION['update']);
        }
    ?>

<?php endif; ?>


<p><?php echo isset($_SESSION['update']) ? translate("update") : translate("new"); ?></p>
<p><?php echo isset($_SESSION['error']) ? translate("invalid file"): NULL; ?></p>
<form action="product.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?php echo isset($_SESSION['update']) ? (isset($_POST['title']) ? $_POST['title'] : $list['title']) : (isset($_POST['title']) ? $_POST['title'] : ''); ?>" placeholder = "<?php echo translate('title'); ?>" required="required"/><br /><br />
    <input type="text" name="description" value="<?php echo isset($_SESSION['update']) ? (isset($_POST['description']) ? $_POST['description'] : $list['description']): (isset($_POST['description']) ? $_POST['description'] : ''); ?>" placeholder = "<?php echo translate('desc'); ?>" required="required"/><br /><br />
    <input type="number" min="0" name="price" value="<?php echo isset($_SESSION['update']) ? (isset($_POST['price']) ? $_POST['price'] : $list['price']): (isset($_POST['price']) ? $_POST['price'] : ''); ?>" placeholder = "<?php echo translate('price'); ?>" required="required"/><br /><br />
    <input type="file" name="image" accept="image/*"/><br /><br />
    <input type ="submit" value="<?php echo isset($_SESSION['update']) ? translate("save") : translate("new"); ?>" /><br />
</form>

<div><a href="admin.php"><?php echo translate("back"); ?></a></div>


