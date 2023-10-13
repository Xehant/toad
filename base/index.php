<?php include_once '../include/config.php'?>
<?php include '../include/header.php'; ?>

<div class="container">
    <h1>Accueil</h1>

    <!-- Formulaire pour publier un tweet -->
    <form action="../tweet/publier_tweet.php" method="post">
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
        echo '<p>' . $row['texte'] . '</p>';
        echo '<p class="timestamp">' . $row['created_at'] . '</p>';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-regular fa-heart"></i></a>' . $row['likes_count'] . '</p>';
        echo '<p class="retweets-count"><a href="../tweet/retweet_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-retweet"></i></a>' . $row['retweets_count'] . '</p>';
        echo '<p class="comments-count"><a href="../tweet/reponse_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-regular fa-comment"></i></a> ' . $row['comments_count'] . '</p>';

        // Formulaire pour ajouter un commentaire
        echo '<form action="../tweet/reponse_tweet.php" method="post">';
        echo '<input type="hidden" name="tweets_id" value="' . $row['ID'] . '">';
        echo '<textarea name="reponse_tweet" placeholder="Écrivez votre réponse ici" rows="4" cols="50"></textarea>';
        echo '<input type="submit" value="Publier">';
        echo '</form>';

        // Commentaires pour ce tweet
        $stmtComments = $db->prepare("SELECT * FROM Comments WHERE Tweets_ID = :tweet_id");
        $stmtComments->bindParam(':tweet_id', $row['ID']);
        $stmtComments->execute();

        while ($comment = $stmtComments->fetch(PDO::FETCH_ASSOC)) {
                       echo '<div class="comment">';
                        $imageDatac = base64_encode($comment['User_photo']);
            $imageSrcc = "data:image/jpeg;base64," . $imageDatac;
            echo '<img src="' . $imageSrcc . '" >';
            echo '<p><strong>' . $comment['User_nom'] . '</strong></p>';
            echo '<p>' . $comment['Comment_text'] . '</p>';
            echo '<p class="timestamp">' . $comment['created_at'] . '</p>';
            echo '</div>';
        }

        echo '</div>'; // Fermeture de la div du tweet
    }
    ?>

</div>

<?php include '../include/footer.php'; ?>
