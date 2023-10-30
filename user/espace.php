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
   

   <form action="logout" method="get">
      <a href="logout.php">Se déconnecter</a>
   </form>
  
   <div class="card-body">
      <ul class="twitter-nav">
         <li onclick="showCategory('profil')">Modifier mon profil</li>
         <li onclick="showCategory('tweets')">Tweets</li>
         <li onclick="showCategory('replies')">Réponses</li>
         <li onclick="showCategory('media')">Média</li>
         <li onclick="showCategory('likes')"> Likés</li>
         <li onclick="showCategory('dislikes')"> Dislikés</li>
      </ul>

      <div class="category" id="profil">
         <!-- Contenu de la catégorie "Tous les Tweets" --> <!-- Déplacez le formulaire d'ajout de publication ici -->
   <form action="upload.php" method="post" enctype="multipart/form-data">
      Modifier ma photo de profil:
      <input type="file" name="image" />
      <input type="submit" name="submit" value="UPLOAD" class="submit" />
   </form>
   <h1>Mise à jour de la description de l'utilisateur</h1>
    <form action="../user/description.php" method="POST">
        <label for="description">Nouvelle description :</label><br>
        <textarea name="description" id="description" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Mettre à jour la description">
    </form><?php
// Assurez-vous d'appeler session_start() au début du fichier


 include ('../user/description.php'); 
    $query = "SELECT description FROM user WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifiez si l'utilisateur a une description
        $description = $user["description"];
        if (!empty($description)) {
            echo "<h2>Description de l'utilisateur :</h2>";
            echo "<p>$description</p>";
        } else {
            echo "<p>L'utilisateur n'a pas encore de description.</p>";
        }
    } else {
        echo "Utilisateur introuvable.";
    }

?>

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
      <div class="category" id="dislikes">
         <!-- Contenu de la catégorie "Tweets Likés" -->
         <?php include('../user/dislikes.php'); ?>
      </div>
   </div>
</div>

<?php include("../include/footer.php");?>
