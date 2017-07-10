<?php require_once('common.php'); ?>
<h3><?php echo translate('welcomeuser'); ?></h3><br />

<?php
    $result = getProducts();
    foreach ($result as $row) {
        if (isset($_GET[$row['ID']])) {
            if(isset($_SESSION['cart'][$row['ID']])){
                $_SESSION['cart'][$row['ID']] += $_GET[$row['ID']];
            }
            else{
                $_SESSION['cart'][$row['ID']] = $_GET[$row['ID']];
            }
        }
    }
?>

<?php foreach ($result as $row): ?>
    <?php if (!isset($_SESSION['cart'][$row['ID']]) || !$_SESSION['cart'][$row['ID']]): ?>
        <div style="float: left;"><img src="<?php echo sanitize($row["image"]); ?>" style="height: 15%;" /></div>
        <div><p><?php echo sanitize($row["title"]); ?></p></div>
        <div><p><?php echo sanitize($row["description"]); ?></p></div>
        <div style="margin-left: 10%;">
          <form method="GET" action="index.php">
              <input type="number" min="0"  placeholder="Quantity" name="<?php echo sanitize($row['ID']); ?>" required="required" />
              <input type="submit" value="<?php echo translate('add'); ?>" />
          </form>
        </div>
        <div><p><?php echo sanitize($row["price"]); ?>$</p></div>
        <div style="clear:both;"><br/></div>
    <?php endif; ?>
<?php endforeach; ?>


<br/>
<div>
    <a href="login.php"><?php echo translate('log'); ?></a>
</div>
<div>
    <a href="cart.php"><?php echo translate('cart'); ?></a>
</div>


