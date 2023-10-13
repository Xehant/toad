<?php
// Supposons que vous ayez une variable $tweet_id contenant l'ID du tweet
?>
<form action="../tweet/reponse_tweet.php" method="post">
    <input type="hidden" name="tweets_id" value="<?php echo $row['ID']; ?>">
    <textarea name="reponse_tweet" placeholder="Écrivez votre réponse ici" rows="4" cols="50"></textarea>
    <input type="submit" value="Publier">
</form>
