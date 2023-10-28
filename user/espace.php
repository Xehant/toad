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

?>

<div class="container">
   <h1>MON ESPACE</h1>
   <h2>Modifier mon profil</h2>

   <form action="logout" method="get">
      <a href="logout.php">Se déconnecter</a>
   </form>
  
   <div class="card-body">
      <ul class="twitter-nav">
         <li onclick="showCategory('all')">Modifier mon profil</li>
         <li onclick="showCategory('tweets')">Tweets</li>
         <li onclick="showCategory('replies')">Réponses</li>
         <li onclick="showCategory('media')">Média</li>
         <li onclick="showCategory('likes')">Tweets Likés</li>
      </ul>

      <div class="category" id="all">
         <!-- Contenu de la catégorie "Tous les Tweets" --> <!-- Déplacez le formulaire d'ajout de publication ici -->
   <form action="upload.php" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="image" />
      <input type="submit" name="submit" value="UPLOAD" class="submit" />
   </form>
         <?php include ('../user/view.php'); ?>
      </div>
      <div class="category" id="tweets">
         <!-- Contenu de la catégorie "Tweets" -->
         <?php include('../user/tweet.php'); ?>
      </div>

      <div class="category" id="replies">
         <!-- Contenu de la catégorie "Réponses" -->
         <?php include('../user/reponse.php'); ?>
      </div>

      <div class="category" id="media">
         <!-- Contenu de la catégorie "Média" -->
         <?php include('../user/media_review.php'); ?>
      </div>

      <div class="category" id="likes">
         <!-- Contenu de la catégorie "Tweets Likés" -->
         <?php include('../user/likes.php'); ?>
      </div>
      <p><a href="" class="btn btn-danger">Je partage mon lien via Google</a></p>
   </div>
</div>

<?php include("../include/footer.php");?>
