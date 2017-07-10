<?php
require_once('common.php');

unset($_SESSION['admin']);


function auth() {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if(strcmp($user,USER)==0 && strcmp($pass,PASS)==0){
        $_SESSION['admin'] = "y";
        header("Location:admin.php");
    }
    else{
        header("Location:index.php");
    }
}

if(isset($_POST['user'])){
    auth();
}
else {
?>
    <br />
    <form action="login.php" method="POST">
    <input type="text" placeholder="<?php echo translate("user"); ?>" name="user" required="required" autofocus/>
    <input type="password" placeholder="<?php echo translate("pass"); ?>" name="pass" required="required"/>
    <input type="submit" name="submit" value="<? echo translate("login") ?>" />
    </form>
<?php
}

