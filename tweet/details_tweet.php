<?php
include('../include/config.php');
include('../include/header.php');
$tweet_id = $_GET['tweet_id'];
$query = "SELECT * FROM Tweets WHERE Id = $tweet_id";
$result = $db->query($query);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    // Afficher les informations du tweet
    echo '<div class="tweet">';
    $imageData = base64_encode($row['User_photo']);
    $imageSrc = "data:image/jpeg;base64," . $imageData;
    echo '<img src="' . $imageSrc . '" >';
    echo '<p><strong>' . $row['User_nom'] . '</strong></p>';
    echo "<p class='tweet_text'>" . $row['texte'] . "</p>";
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