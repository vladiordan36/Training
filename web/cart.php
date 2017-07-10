<?php require_once('common.php'); ?>

<?php
$result = getProducts();
foreach($result as $row) {
    if (isset($_GET[$row['ID']])) {
        $_SESSION['cart'][$row['ID']] = $_GET[$row['ID']];
    }
}
?>

<?php
if(isset($_GET['mail'])){
    checkout($_GET['mail']);
}
?>

<?php foreach($result as $row): ?>
    <?php if(isset($_SESSION['cart'][$row['ID']]) && $_SESSION['cart'][$row['ID']] > 0): ?>
        <div style="float:left;"><img src="<?php echo sanitize($row["image"]); ?>" style="height:15%;" /></div>
        <div><p><?php echo sanitize($row["title"]) ?></p></div>
        <div><p><?php echo sanitize($row["description"]) ?></p></div>

         <div style = "margin-left:10%;">
         <form method="GET" action = "cart.php">
            <input type = "text" placeholder="<?php echo translate('quantity'); ?>" name="<?php echo sanitize($row['ID']) ?>" value="<?php echo $_SESSION['cart'][$row['ID']] ?>" required="required" />
            <input  type = "submit" value="<?php echo translate('save'); ?>" />
         </form>
        </div>

        <div><p>Cost: <?php echo $_SESSION['cart'][$row['ID']]." x ".$row['price']."$ = ".$_SESSION['cart'][$row['ID']]*$row['price']."$"; ?></p></div>
        <div style="clear:both;"><br /></div>
    <?php endif; ?>
<?php endforeach; ?>

<?php if(cartIsEmpty()):?>
    <p><?php echo translate("empty"); ?></p>
    <br/>

<?php else: ?>
    <div>
        <form>
            <input name="mail" placeholder="<?php echo translate("email"); ?>" />
            <input type="submit" value="<?php echo translate('chkout'); ?>" />
        </form>
    </div>
<?php endif; ?>

<div>
    <a href="index.php"><?php echo translate('back'); ?></a>
</div>