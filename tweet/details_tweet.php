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
    $imagetweet = $row['tweet_image']; // Pas besoin de le réencoder

    $imageSrc = "data:image/jpeg;base64," . $imageData;
    echo '<img src="' . $imageSrc . '" alt="Photo de profil" class="profil">';
    echo '<p><strong>     @' . $row['User_nom'] . '</strong></p>';
    echo "<a href='../tweet/details_tweet.php?tweet_id=" . $row['ID'] . "'><p class='tweet_text'>" . $row['texte'] . "</p></a>";
        include '../tweet/image_tweet.php'; 
    if (!empty($imagetweet)) {
        echo '<img src="data:image/jpeg;base64,' . base64_encode($imagetweet) . '" alt="Image du tweet">';
    }echo '<p class="timestamp">' . $row['created_at'] . '</p>';
    echo '<div class="rating">';
    echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';


$comments_difference = $row['likes_count'] - $row['retweets_count'];
echo '<p class="comments-count">' . $comments_difference . '</p>';
echo '<p class="retweets-count"><a href="../tweet/retweet_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-regular fa-down-long"></i></a></p></div>';
    // Formulaire pour ajouter un commentaire
    include('../tweet/comments.php');

    // Commentaires pour ce tweet
    $stmtComments = $db->prepare("SELECT * FROM Comments WHERE Tweets_ID = :tweet_id");
    $stmtComments->bindParam(':tweet_id', $row['ID']);
    $stmtComments->execute();
include('image_reponse.php');
    while ($comment = $stmtComments->fetch(PDO::FETCH_ASSOC)) {
                   echo '<div class="comment">';
                    $imageDatac = base64_encode($comment['User_photo']);
        $imageSrcc = "data:image/jpeg;base64," . $imageDatac;
        echo '<img src="' . $imageSrcc . '" >';
        echo '<p><strong>' . $comment['User_nom'] . '</strong></p>';
        echo '<p>' . $comment['Comment_text'] . '</p>';
        echo '<p class="timestamp">' . $comment['created_at'] . '</p>';
        echo '<div class="rating">';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';
    
    
    $comments_difference = $row['likes_count'] - $row['retweets_count'];
    echo '<p class="comments-count">' . $comments_difference . '</p>';
    echo '<p class="retweets-count"><a href="../tweet/retweet_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-regular fa-down-long"></i></a></p></div>';

    }

    echo '</div>'; // Fermeture de la div du tweet
}
?>