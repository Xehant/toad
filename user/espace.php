<?php
// Assurez-vous d'appeler session_start() au début du fichier
include_once '../include/config.php';

if(isset($_SESSION["id"])){
   $id = $_SESSION["id"];
 

   $req = $db->prepare("SELECT * FROM user WHERE id = :id");
   $req->bindParam(':id', $id);
   $req->execute();
   
   if($result = $req->fetch()){
      $nom = $result['nom'];
   }
}
include "../include/header.php";
//var_dump($_SESSION);
?>

<div class="container">
   <h1>MON ESPACE</h1>
  <h2>Modifier mon profil</h2>
  <p>Modifier ma photo de profil</p>
  <?php include 'view.php';
  include 'upload.php'; ?>
  <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="image"/>
        <input type="submit" name="submit" value="UPLOAD" class="submit"/>
    </form>
<form action="logout" method="get">
   <a href="logout.php">Se déconnecter</a>
</form>
<p>div</p>
   <div class="card-body">
   <ul>
        <li onclick="showCategory('all')">Tous les Tweets</li>
        <li onclick="showCategory('tweets')">Tweets</li>
        <li onclick="showCategory('replies')">Réponses</li>
        <li onclick="showCategory('media')">Média</li>
        <li onclick="showCategory('likes')">Tweets Likés</li>
    </ul>

    <div class="category" id="all">
        <!-- Contenu de la catégorie "Tous les Tweets" -->
    </div>

    <div class="category" id="tweets">
        <!-- Contenu de la catégorie "Tweets" -->
    </div>

    <div class="category" id="replies">
        <!-- Contenu de la catégorie "Réponses" --><p><a href="" class="btn btn-primary">Je partage mon lien via Facebook</a></p>
    </div>

    <div class="category" id="media">
        <!-- Contenu de la catégorie "Média" -->
    </div>

    <div class="category" id="likes">
        <!-- Contenu de la catégorie "Tweets Likés" -->
    </div>
         
      
      <p><a href="" class="btn btn-danger">Je partage mon lien via Google</a></p>
   </div>
</div></div>
<?php include("../include/footer.php");?>
