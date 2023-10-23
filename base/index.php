<?php include_once '../include/config.php'?>
<?php include '../include/header.php'; ?>

<div class="container">
    <!-- Formulaire pour publier un tweet -->
    <form action="../tweet/publier_tweet.php" method="post" class="publication">
        <input type="text" name="tweet_text" placeholder="Écrivez votre tweet ici" rows="4" cols="50"></input>
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
        $imageSrc = "data:image/jpeg;base64," . $imageData;
        echo '<img src="' . $imageSrc . '" >';
        echo '<p><strong>     @' . $row['User_nom'] . '</strong></p>';
        echo "<a href='../tweet/details_tweet.php?tweet_id=" . $row['ID'] . "'><p class='tweet_text'>" . $row['texte'] . "</p></a>";

        echo '<p class="timestamp">' . $row['created_at'] . '</p>';
        echo '<div class="rating">';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';
       
$comments_difference = $row['likes_count'] - $row['retweets_count'];
echo '<p class="comments-count">' . $comments_difference . '</p>';
echo '<p class="retweets-count"><a href="../tweet/retweet_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-down" style="color: #df2a2a;"></i></a></p></div>';
        // Formulaire pour ajouter un commentaire
        echo '<form action="../tweet/reponse_tweet.php" method="post">';
        echo '<input type="hidden" name="tweets_id" value="' . $row['ID'] . '">';
        echo '<input type="text" name="reponse_tweet" placeholder="Écrivez votre réponse ici" rows="4" cols="50"></input>';
        echo '<input type="submit" value="Publier" class="submit">';
        echo '</form>';

      

        echo '</div>'; // Fermeture de la div du tweet
    }
    if(!isset($_SESSION['id'])){ echo '<div id="login-popup" class="popup" style="display: none;">';
        echo '<h2>Connectez-vous pour publier</h2>';
        echo '<p>Vous devez être connecté pour publier des commentaires ou des tweets.</p>';
        echo '<button id="close-popup">Fermer</button>';
        echo '</div>';}
    ?>

</div>

<?php include '../include/footer.php'; ?>
