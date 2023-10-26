<?php
// Supposons que vous ayez une variable $tweet_id contenant l'ID du tweet
?>
<form action="../tweet/reponse_tweet.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tweets_id" value="<?php echo $row['ID']; ?>">
    <input type="text" name="reponse_tweet" placeholder="Écrivez votre réponse ici" rows="4" cols="50"></input>
    <input type="file" name="reponse_image">
    <input type="submit" class="submit" value="Publier">
</form>
