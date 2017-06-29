<?php
$translations = array(
    'user' => 'Username',
    'pass' => 'Password'
);
function trans($label) {
    global $translations;
    return isset($translations[$label]) ? $translations[$label] : $label;
}
function auth() {
    if(isset($_POST['user']))
        $user = $_POST['user'];
    else
        $user = "";
    if(isset($_POST['user']))
        $pass = $_POST['pass'];
    else
        $pass = "";
    if(strcmp($user,'admin')==0 && strcmp($pass,'admin')==0){
        header("Location:admin.php");
    }
    else
        header("Location:index.php");
}

if(isset($_POST['user']))
    auth();
else {
    echo "
    <br />
    <form action='login.php' method='POST'>
    <label><?= trans('user')?></label><input type='text' placeholder='Enter Username' name='user' required/>
    <label><?= trans('pass')?></label><input type='password' placeholder='Enter Password' name='pass' required/>
    <input type='submit' name='submit' value='Login' onclick='auth()' />
    </form>
";
}
?>
