<?php
require_once("common.php");
$result = getProducts();
?>

<?php if(isset($_SESSION['admin'])): ?>
    <h3><?php echo translate("welcomeadmin"); ?></h3><br />


    <?php foreach($result as $row) : ?>
        <div style="float:left;"><img style="height:15%;" src=<?php echo sanitize($row["image"]); ?> /></div>
        <div><p><?php echo sanitize($row["title"]); ?></p></div>
        <div><p><?php echo sanitize($row["description"]); ?></p></div>

        <div style="float:left;">
            <form method="GET" action = admin.php>
                <input type="text" name=<?php echo sanitize($row['ID']); ?> placeholder="Enter Delete or Update" />
                <input  type = "submit" >
            </form>
        </div>
        <div style="clear:both;"><br /></div>

        <?php if(isset($_GET[$row['ID']])): ?>
            <?php if(strcmp(strtolower($_GET[$row['ID']]),"delete")==0):?>
                <? $option = "delete from products where id=".$row['ID'].";"; ?>
                <?php if(!mysqli_query($link,$option)): ?>
                    <? echo mysqli_error(($link)); ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(strcmp(strtolower($_GET[$row['ID']]),"update") == 0): ?>
                     <?php $_SESSION['update'] = $row['ID'];
                        header("Location:product.php"); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>


    <div style="float: left;">
        <a href="index.php"><?php echo translate('logout'); ?></a>
    </div>
    <div>
        <a href="product.php"><?php echo translate('list'); ?></a>
    </div>

<?php else: ?>
        <h3><?php echo translate("notallowed"); ?></h3><br />
        <div style="float:left;">
            <form method="GET" action = index.php>
                <input  type = "submit" value=<?php echo translate("logout"); ?>>
            </form>
        </div>
<?php endif; ?>
