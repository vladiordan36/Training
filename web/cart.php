<?php
require_once('common.php');

$result = mysqli_query($link, "select * from products");
#$row = mysqli_fetch_row($result);
foreach($result as $row){
    echo '<div style="float:left"><img src="'.$row["image"].'" style="height:15%"></img></div>
          <div><p>'.$row["title"].'</p></div>
          <div><p>'.$row["desc"].'</p></div>
          <div style = "margin-left:10%"><img src="media\plus.png" style="height:3%"></img></div>
          <div><p>'.$row["price"].'$</p></div>
          <div style="clear:both"><br/></div>';
}
?>

<div style="float:left"><a href='index.php'><--Back</a></div>