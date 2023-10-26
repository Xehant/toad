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
    $imagetweet = $row['tweet_image'];

    $imageSrc = "data:image/jpeg;base64," . $imageData;
    echo '<img src="' . $imageSrc . '" alt="Photo de profil" class="profil">';
    echo '<p><strong>@' . $row['User_nom'] . '</strong></p>';
    echo "<a href='../tweet/details_tweet.php?tweet_id=" . $row['ID'] . "'><p class='tweet_text'>" . $row['texte'] . "</p></a>";

    if (!empty($imagetweet)) {
        echo '<img src="data:image/jpeg;base64,' . base64_encode($imagetweet) . '" alt="Image du tweet">';
    }

    echo '<p class="timestamp">' . $row['created_at'] . '</p>';
    echo '<div class="rating">';
    echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';

    $comments_difference = $row['likes_count'] - $row['dislikes_count'];
    echo '<p class="comments-count">' . $comments_difference . '</p>';
    echo '<p class="dislikes-count"><a href="../tweet/dislike_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-regular fa-down-long"></i></a></p>';
    include_once("../tweet/comment_tweet.php");
    $commentCount = Comments_count($row['ID'],$db);
    if ($commentCount >= 0) {
        echo '<i class="fa-regular fa-comment"></i>' . $commentCount .'</div>';
    } else {
        echo "Une erreur s'est produite lors du comptage des commentaires.";
    }
    // Formulaire pour ajouter un commentaire
    include('../tweet/comments.php');

    // Commentaires pour ce tweet
    $stmtComments = $db->prepare("SELECT * FROM Comments WHERE Tweets_ID = :tweet_id");
    $stmtComments->bindParam(':tweet_id', $row['ID']);
    $stmtComments->execute();

    if ($stmtComments->rowCount() > 0) {
        while ($comment = $stmtComments->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="tweet">'; // Utiliser la classe "tweet" pour le commentaire
            $imageDatac = base64_encode($comment['User_photo']);

            $imageSrcc = "data:image/jpeg;base64," . $imageDatac;
            include('../tweet/image_reponse.php');
            echo '<img src="' . $imageSrcc . '" alt="Photo de profil" class="profil">'; // Utiliser la classe "profil"
            echo '<p><strong>@' . $comment['User_nom'] . '</strong></p>'; // Utiliser la classe "tweet_text"
            echo '<p class="tweet_text">' . $comment['Comment_text'] . '</p>'; // Utiliser la classe "tweet_text"

            $imagereponse = $comment['c_image'];
            if (!empty($imagereponse)) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagereponse) . '" alt="Image du commentaire">';
            }

            echo '<p class="timestamp">' . $comment['created_at'] . '</p>';
            echo '<div class="rating">'; // Utiliser la classe "rating"
            echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $comment['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>'; // Utiliser la classe "likes-count"

            $comments_difference = $comment['likes_count'] - $comment['dislikes_count'];
            echo '<p class="comments-count">' . $comments_difference . '</p>'; // Utiliser la classe "comments-count"
            echo '<p class="dislikes-count"><a href="../tweet/dislike_tweet.php?tweets_id=' . $comment['ID'] . '"><i class="fa-regular fa-down-long"></i></a></p>'; // Utiliser la classe "dislikes-count"
            echo '</div>';
            echo '</div>'; // Fermeture de la div du commentaire
        }
    } else {
        echo "Aucun commentaire trouvé pour ce tweet.";
    }

    echo '</div>'; // Fermeture de la div du tweet
}

include('../include/footer.php');?>