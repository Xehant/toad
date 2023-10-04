<?php
include_once('config.php');
      if(isset($_POST["submit"])){
          $check = getimagesize($_FILES["image"]["tmp_name"]);
          if($check !== false){
              $image = $_FILES['image']['tmp_name'];
              $imgContent = addslashes(file_get_contents($image));
            $userId= $_SESSION['id'];

            //Insert image content into database
            $insert = $db->query("UPDATE user SET photo = '$imgContent' WHERE ID = $userId");
            if($insert){
                echo "File uploaded successfully.";
                header("Location: espace.php");
            }else{
                echo "File upload failed, please try again.";
            } 
        }else{
            echo "Please select an image file to upload.";
        }
    }
    ?>
    