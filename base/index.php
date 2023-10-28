<?php include_once '../include/config.php'?>
<?php include '../include/header.php'; ?>

<div class="container">
    <!-- Formulaire pour publier un tweet -->
    <form action="../tweet/publier_tweet.php" method="post" class="publication" enctype="multipart/form-data">
        <input type="text" name="tweet_text" placeholder="Écrivez votre tweet ici" rows="4" cols="50">
        <input type="file" name="tweet_image">
        <input type="submit" value="Publier" class="submit">
    </form>

    <?php
    // Effectuez une requête SQL pour récupérer tous les tweets
    $query = "SELECT * FROM Tweets ORDER BY created_at DESC";
    $result = $db->query($query);

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Afficher les informations du tweet
        echo '<div class="tweet">';
        $imageData = base64_encode($row['User_photo']);
        $imagetweet = $row['tweet_image']; // Pas besoin de le réencoder

        $imageSrc = "data:image/jpeg;base64," . $imageData;
        echo '<img src="' . $imageSrc . '" alt="Photo de profil" class="profil">';
        echo '<p><strong>     @' . $row['User_nom'] . '</strong></p>';
        echo "<a href='../tweet/details_tweet.php?tweet_id=" . $row['ID'] . "'><p class='tweet_text'>" . $row['texte'] . "</p>";
         include '../tweet/image_tweet.php';
         if (!empty($imagetweet)) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($imagetweet) . '" alt="Image du tweet"></a>';
        }
        echo '<p class="timestamp">' . $row['created_at'] . '</p>';
        echo '<div class="rating">';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';
        $tweetID = $row['ID'];
        $likes_difference = $row['likes_count'] - $row['dislikes_count'];
        echo '<p class="likes-count">' . $likes_difference . '</p>';
        echo '<p class="dislikes-count"><a href="../tweet/dislike_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-down" style="color: #df2a2a;"></i></a></p>';
include_once("../tweet/comment_tweet.php");
$commentCount = Comments_count($tweetID,$db);
if ($commentCount >= 0) {
    echo '<i class="fa-regular fa-comment"></i>' . $commentCount .'</div>';
} else {
    echo "Une erreur s'est produite lors du comptage des commentaires.";
}
        // Formulaire pour ajouter un commentaire
include('../tweet/comments.php');
        
        echo '</div>'; // Fermeture de la div du tweet
    }
    
    if(!isset($_SESSION['id'])) {
        echo '<div id="login-popup" class="popup" style="display: none;">';
        echo '<h2>Connectez-vous pour publier</h2>';
        echo '<p>Vous devez être connecté pour publier des commentaires ou des tweets.</p>';
        echo '<button id="close-popup">Fermer</button>';
        echo '</div>';
    }
    ?>

</div>

<?php include '../include/footer.php'; ?>
