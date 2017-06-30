<?php
require_once("common.php");

if(strcmp($_SESSION['admin'], "y")==0){
    echo '<h3>Welcome Admin</h3><br />';

    foreach($result as $row){
        if(isset($_POST[$row['ID']])){
            if(strcmp($_POST[$row['ID']],"Delete")==0 || strcmp($_POST[$row['ID']],"delete")==0){
                $option = "delete from products where id=".$row['ID'].";";
                if(!mysqli_query($link,$option))
                    echo mysqli_error(($link));
            }
            if(strcmp($_POST[$row['ID']],"Update")==0 || strcmp($_POST[$row['ID']],"update")==0){
                $_SESSION['update'] = $row['ID'];
                header("Location:product.php");
            }
        }
    }

    $result = mysqli_query($link, "select * from products");

    foreach($result as $row){
        echo '<div style="float:left"><img src="'.$row["image"].'" style="height:15%"></img></div>
              <div><p>'.$row['ID'].'.'.$row["title"].'</p></div>
              <div><p>'.$row["desc"].'</p></div>
              
              <div style="float:left">
                  <form method="POST" action = admin.php>
                      <input type="text" name='.$row['ID'].' placeholder="Enter Delete or Update" />
                      <input  type = "submit" Value="Submit">
                  </form>
              </div>
              
              <div style="clear:both"><br/></div>';
    }

    echo '<div style="float:left"><form method="POST" action = index.php><input  type = "submit" Value="<--Back>"></form></div>
          <div><form method="POST" action = product.php><input  type = "submit" Value="List Product>"></form></div>';
}
    else{
        echo '<h3>You shall not pass!</h3><br />
        <div style="float:left"><form method="POST" action = index.php><input  type = "submit" Value="<--Back>"></form></div>';
}