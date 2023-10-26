<?php
function Comments_count($tweetID, $db) {
    try {
        $query = "SELECT COUNT(*) AS comment_count FROM Comments WHERE Tweets_ID = :tweet_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':tweet_id', $tweetID);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['comment_count'])) {
            return $result['comment_count'];
        } else {
            return 0; // Aucun commentaire trouvé
        }
    } catch (PDOException $e) {
        // Gérer les erreurs, par exemple :
        // echo "Erreur : " . $e->getMessage();
        return -1; // Une erreur s'est produite
    }
}
?>
