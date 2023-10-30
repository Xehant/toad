<?php
include_once('../include/config.php');
include('../include/page.php');
// Construisez la requête SQL pour récupérer les tweets de l'utilisateur
$query3 = "SELECT * FROM Tweets WHERE User_ID = :user_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$stmt3 = $db->prepare($query3);
$stmt3->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt3->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt3->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt3->execute();

$results3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

if (count($results3) > 0) {
    foreach ($results3 as $media) {
        if (!empty($media['tweet_image'])) {
        // Afficher les informations du tweet
        echo '<div class="tweet">';
        $imageData = base64_encode($media['User_photo']);
        $imagetweet = $media['tweet_image']; // Pas besoin de le réencoder

        $imageSrc = "data:image/jpeg;base64," . $imageData;
        echo '<img src="' . $imageSrc . '" alt="Photo de profil" class="profil">';
        echo '<p><strong>     @' . $media['User_nom'] . '</strong></p>';
        echo "<a href='../tweet/details_tweet.php?tweet_id=" . $media['ID'] . "'><p class='tweet_text'>" . $media['texte'] . "</p>";
        include '../tweet/image_tweet.php';
        if (!empty($media['tweet_image'])) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($media['tweet_image']) . '" alt="Image du tweet"></a>';
        }
        echo '<p class="timestamp">' . $media['created_at'] . '</p>';
        echo '<div class="rating">';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $media['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';
        $tweetID = $media['ID'];
        $likes_difference = $media['likes_count'] - $media['dislikes_count'];
        echo '<p class="likes-count">' . $likes_difference . '</p>';
        echo '<p class="dislikes-count"><a href="../tweet/dislike_tweet.php?tweets_id=' . $media['ID'] . '"><i class="fa-solid fa-arrow-down" style="color: #df2a2a;"></i></a></p>';
        include_once("../tweet/comment_tweet.php");
        $commentCount = Comments_count($tweetID, $db);
        if ($commentCount >= 0) {
            echo '<i class="fa-regular fa-comment"></i>' . $commentCount;
        } else {
            echo "Une erreur s'est produite lors du comptage des commentaires.";
        }
        include('../tweet/comments.php');
        echo '</div>'; 
         echo '</div>';
    }}
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
echo '</div>';
?>
