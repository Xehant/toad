<?php
include('../include/page.php');

// Construisez la requête SQL pour récupérer les réponses de l'utilisateur
$query = "SELECT * FROM Comments WHERE User_ID = :user_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$stmt2 = $db->prepare($query);
$stmt2->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt2->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt2->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt2->execute();

$results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

if (count($results2) > 0) {
    foreach ($results2 as $comment) {
        // Afficher les informations de la réponse
        echo '<div class="tweet">';
        $imageData = base64_encode($comment['User_photo']);
        $imageSrc = "data:image/jpeg;base64," . $imageData;
        echo '<img src="' . $imageSrc . '" alt="Photo de profil" class="profil">';
        echo '<p><strong>@' . $comment['User_nom'] . '</strong></p>';
        echo "<a href='../tweet/details_tweet.php?tweet_id=" . $comment['ID'] . "'><p class='tweet_text'>" . $comment['Comment_text'] . "</p>";
        echo '<p class="timestamp">' . $comment['created_at'] . '</p>';
        echo '<div class="rating">';
        echo '<p class="likes-count"><a href="../tweet/like_tweet.php?tweets_id=' . $comment['ID'] . '"><i class="fa-solid fa-arrow-up" style="color: #2a511f;"></i></a></p>';
        $tweetID2 = $comment['ID'];
        include_once('../tweet/image_tweet.php');
        if (!empty($comment['c_image'])) {
            $imagetweet2 = $comment['c_image'];
            echo '<img src="data:image/jpeg;base64,' . base64_encode($imagetweet2) . '" alt="Image de la réponse"></a>';
        }
        $likes_difference2 = $comment['likes_count'] - $comment['dislikes_count'];
        echo '<p class="likes-count">' . $likes_difference2 . '</p>';
        echo '<p class="dislikes-count"><a href="../tweet/dislike_tweet.php?tweets_id=' . $comment['ID'] . '"><i class="fa-solid fa-arrow-down" style="color: #df2a2a;"></i></a></p>';
        echo '</div></div>'; 
    }
} else {
    echo "Aucune réponse trouvée pour cet utilisateur.";
}

// Afficher la pagination pour les réponses
$queryCount = "SELECT COUNT(*) as total FROM Comments WHERE User_ID = :user_id";
$stmtCount = $db->prepare($queryCount);
$stmtCount->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmtCount->execute();

if ($stmtCount->rowCount() > 0) {
    $data = $stmtCount->fetch(PDO::FETCH_ASSOC);
    $totalComments = $data['total'];
    $totalPages = ceil($totalComments / $itemsPerPage);

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
    echo '</div>';
} else {
    echo "Aucune réponse trouvée pour cet utilisateur.";
}

?>