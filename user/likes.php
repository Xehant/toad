<?php // Assurez-vous d'appeler session_start() au début du fichier
include_once '../include/config.php';

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Construisez la requête SQL pour récupérer les tweets likés par l'utilisateur
    $queryLikedTweets = "SELECT * FROM Tweets 
    INNER JOIN Likes  ON Tweets.ID = Likes.Tweets_ID
    WHERE Likes.User_ID = :user_id";
    $stmtLikedTweets = $db->prepare($queryLikedTweets);
    $stmtLikedTweets->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmtLikedTweets->execute();

    $likedTweets = $stmtLikedTweets->fetchAll(PDO::FETCH_ASSOC);

    // Maintenant, $likedTweets contient tous les tweets que l'utilisateur a likés
    // Vous pouvez les afficher ou les traiter comme vous le souhaitez
    

if (count($likedTweets) > 0) {
    foreach ($likedTweets as $likes) {
        // Afficher les informations de la réponse
        echo '<div class="tweet">';
        $imageData = base64_encode($likes['User_photo']);
        $imageSrc = "data:image/jpeg;base64," . $imageData;
        echo '<img src="' . $imageSrc . '" alt="Photo de profil" class="profil">';
        echo '<p><strong>@' . $likes['User_nom'] . '</strong></p>';
        echo "<a href='../tweet/details_tweet.php?tweet_id=" . $likes['ID'] . "'><p class='tweet_text'>" . $likes['texte'] . "</p>";
        echo '<p class="timestamp">' . $likes['created_at'] . '</p>';
        echo '<div class="rating">';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $likes['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';
        $tweetID2 = $likes['ID'];
        include_once('../tweet/image_tweet.php');
        if (!empty($likes['c_image'])) {
            $imagetweet2 = $likes['c_image'];
            echo '<img src="data:image/jpeg;base64,' . base64_encode($imagetweet2) . '" alt="Image de la réponse"></a>';
        }
        $likes_difference2 = $likes['likes_count'] - $likes['dislikes_count'];
        echo '<p class="likes-count">' . $likes_difference2 . '</p>';
        echo '<p class="dislikes-count"><a href="../tweet/dislike_tweet.php?tweets_id=' . $likes['ID'] . '"><i class="fa-solid fa-arrow-down" style="color: #df2a2a;"></i></a></p>';
        include_once("../tweet/comment_tweet.php");

        // Formulaire pour ajouter un commentaire
        include('../tweet/comments.php');
        echo '</div></div>'; 
    }
} else {
    echo "Aucune réponse trouvée pour cet utilisateur.";
}

// Afficher la pagination pour les réponses
$queryCount = "SELECT COUNT(*) as total FROM Tweets WHERE User_ID = :user_id";
$stmtCount = $db->prepare($queryCount);
$stmtCount->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmtCount->execute();

if ($stmtCount->rowCount() > 0) {
    $data = $stmtCount->fetch(PDO::FETCH_ASSOC);
    $totalTweets = $data['total'];
    $totalPages = ceil($totalTweets / $itemsPerPage);

    echo '<div class="pagination">';
    if ($currentPage > 1) {
        echo '<a href="?page=' . ($currentPage - 1) . '">Page précédente</a>';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            echo '<span class="current-page">' . $i . '</span>';
        } else {
            echo '<a href="?page=' . $i . '">' . $i . '</a>';
        }
    }
    if ($currentPage < $totalPages) {
        echo '<a href="?page=' . ($currentPage + 1) . '">Page suivante</a>';

    }
   
} else {
    echo "Aucun tweet trouvé pour cet utilisateur.";
}
 echo '</div>';
}
?>