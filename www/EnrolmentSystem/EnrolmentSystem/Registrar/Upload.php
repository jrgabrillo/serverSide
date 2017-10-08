<?php
if(isset($_POST['FileUpload'])){
    if(!empty($_FILES['ImageUpload'])){
        if($_FILES['ImageUpload']['error'] == 0 && move_uploaded_file($_FILES['ImageUpload']['tmp_name'],'../StudentsPicture/'.$_FILES['ImageUpload']['name'])){
            echo 'wow';
        }
    }
}
?>
