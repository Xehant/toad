<?php include_once '../include/config.php'?>
<?php include '../include/header.php'; ?>

<div class="container">
    <h1>Accueil</h1>

    <!-- Formulaire pour publier un tweet -->
    <form action="../tweet/publier_tweet.php" method="post" class="publication">
        <textarea name="tweet_text" placeholder="Écrivez votre tweet ici" rows="4" cols="50"></textarea>
        <input type="submit" value="Publier">
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
        echo '<p><strong>' . $row['User_nom'] . '</strong></p>';
        echo "<p class='tweet_text'><a href='../tweet/details_tweet.php?tweet_id=" . $row['ID'] . "'>" . $row['texte'] . "</a></p>";

        echo '<p class="timestamp">' . $row['created_at'] . '</p>';
         echo '<div class="rating">';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-light fa-up-long"></i></a></p>';
       
$comments_difference = $row['likes_count'] - $row['retweets_count'];
echo '<p class="comments-count">' . $comments_difference . '</p>';
echo '<p class="retweets-count"><a href="../tweet/retweet_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-regular fa-down-long"></i></a></p></div>';
        // Formulaire pour ajouter un commentaire
        echo '<form action="../tweet/reponse_tweet.php" method="post">';
        echo '<input type="hidden" name="tweets_id" value="' . $row['ID'] . '">';
        echo '<textarea name="reponse_tweet" placeholder="Écrivez votre réponse ici" rows="4" cols="50"></textarea>';
        echo '<input type="submit" value="Publier">';
        echo '</form>';

      

        echo '</div>'; // Fermeture de la div du tweet
    }
    ?>

</div>

<?php include '../include/footer.php'; ?>
