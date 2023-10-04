<?php
// Assurez-vous d'appeler session_start() au début du fichier
include_once 'config.php';

if(isset($_SESSION["id"])){
   $id = $_SESSION["id"];
 

   $req = $db->prepare("SELECT * FROM user WHERE id = :id");
   $req->bindParam(':id', $id);
   $req->execute();
   
   if($result = $req->fetch()){
      $nom = $result['nom'];
   }
}
include "include/header.php";
//var_dump($_SESSION);
?>

<div class="container">
   <h1>MON ESPACE</h1></div>
  <h2>Modifier mon profil</h2>
  <p>Modifier ma photo de profil</p>
  <?php include 'view.php';
  include 'upload.php'; ?>
  <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="image"/>
        <input type="submit" name="submit" value="UPLOAD"/>
    </form>
<form action="logout" method="get">
   <a href="logout.php">Se déconnecter</a>
</form>
   <div class="card-body">
      <h2>Lien de parrainage</h2>
      <p class="card-text">
         <b>http://localhost/toad/register.php?p=<?php echo($id) ; ?></b>
      </p>
      <p><a href="" class="btn btn-primary">Je partage mon lien via Facebook</a></p>
      <p><a href="" class="btn btn-danger">Je partage mon lien via Google</a></p>
   </div>
</div>
</body>
</html>
