<?php
require_once("common.php");
$result = getProducts();
?>
<?php if(isset($_SESSION['admin'])): ?>
    <h3><?php echo translate("welcomeadmin"); ?></h3>


    <?php foreach($result as $row) : ?>

        <div style="float:left;"><img style="height:15%;" src=<?php echo sanitize($row["image"]); ?> /></div>
        <div><p><?php echo sanitize($row["title"]); ?></p></div>
        <div><p><?php echo sanitize($row["description"]); ?></p></div>
        <div><p><?php echo sanitize($row["price"])."$"; ?></p></div>
        <div>
            <a href="delete.php?id=<?php echo $row['ID']; ?>"><?php echo translate('delete'); ?></a>
        </div>
        <div>
            <a href="product.php?update=<?php echo $row['ID']; ?>"><?php echo translate('update'); ?></a>
        </div>
        <div style="clear:both;"><br /></div>


    <?php endforeach; ?>

    <div>
        <a href="index.php"><?php echo translate('logout'); ?></a>
    </div>
    <div>
        <a href="product.php"><?php echo translate('new'); ?></a>
    </div>

<?php else: ?>
        <h3><?php echo translate("notallowed"); ?></h3><br />
        <div style="float:left;">
            <a href="index.php"><?php echo translate('back'); ?></a>
        </div>
<?php endif; ?>
