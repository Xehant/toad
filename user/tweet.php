<?php
include('../include/page.php');
// Construisez la requête SQL pour récupérer les tweets de l'utilisateur
$query = "SELECT * FROM Tweets WHERE User_ID = :user_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($results) > 0) {
    foreach ($results as $row) {
        // Afficher les informations du tweet
        echo '<div class="tweet">';
        $imageData = base64_encode($row['User_photo']);
        $imagetweet = $row['tweet_image']; // Pas besoin de le réencoder

        $imageSrc = "data:image/jpeg;base64," . $imageData;
        echo '<img src="' . $imageSrc . '" alt="Photo de profil" class="profil">';
        echo '<p><strong>     @' . $row['User_nom'] . '</strong></p>';
        echo "<a href='../tweet/details_tweet.php?tweet_id=" . $row['ID'] . "'><p class='tweet_text'>" . $row['texte'] . "</p>";

        echo '<p class="timestamp">' . $row['created_at'] . '</p>';
        echo '<div class "rating">';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';
        $tweetID = $row['ID'];
        include '../tweet/image_tweet.php';
        if (!empty($imagetweet)) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($imagetweet) . '" alt="Image du tweet"></a>';
        }
        $likes_difference = $row['likes_count'] - $row['dislikes_count'];
        echo '<p class="likes-count">' . $likes_difference . '</p>';
        echo '<p class="dislikes-count"><a href="../tweet/dislike_tweet.php?tweets_id=' . $row['ID'] . '"><i class="fa-solid fa-arrow-down" style="color: #df2a2a;"></i></a></p>';
        include_once("../tweet/comment_tweet.php");

        // Formulaire pour ajouter un commentaire
        include('../tweet/comments.php');
        echo '</div></div>'; 
        
    }
} else {
    echo "Aucun tweet trouvé pour cet utilisateur.";
}

// Afficher la pagination
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
 echo '</div>'
?>
