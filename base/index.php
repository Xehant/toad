<?php include_once '../include/config.php'?>


    <?php include '../include/header.php'; ?>
    
    <div class="container">
        <h1>Accueil</h1>
        
        <!-- Formulaire pour publier un tweet -->
        <form action="../tweet/publier_tweet.php" method="post">
    <textarea name="tweet_text" placeholder="Écrivez votre tweet ici" rows="4" cols="50"></textarea>
    <input type="submit" value="Publier">
</form>
        <?php // Effectuez une requête SQL pour récupérer tous les tweets
$query = "SELECT * FROM Tweets ORDER BY created_at DESC";
$result = $db->query($query);

        ?>
<!-- Afficher les tweets récents -->
<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
    <div class="tweet">
    <?php
        // Encodage de l'image en base64
        $imageData = base64_encode($row['User_photo']);
        $imageSrc = "data:image/jpeg;base64," . $imageData;
        ?>
        <img src="<?php echo $imageSrc ; ?>" >
        <p><strong><?php echo $row['User_nom']; ?></strong></p>
        <p><?php echo $row['texte']; ?></p>
        <p class="timestamp"><?php echo $row['created_at']; ?></p>
        <p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=<?php echo $row['ID'] ?>"><i class="fa-regular fa-heart"></a></i>
        <?php echo $row['likes_count']; ?></p>

        <p class="retweets-count"><a href="../tweet/retweet_tweet.php?tweets_id=<?php echo $row['ID'] ?>"><i class="fa-regular fa-heart"></a></i>
        <?php echo $row['retweets_count']; ?></p>

        <p class="comments-count"><a href="../tweet/comment_tweet.php?tweets_id=<?php echo $row['ID'] ?>"><i class="fa-regular fa-heart"></a></i>
        <?php echo $row['comments_count']; ?></p>
    </div>
<?php } ?>
    </div>
    
    <?php include 'include/footer.php'; ?>

