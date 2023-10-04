<?php
// Inclure la configuration de la base de données
include_once 'config.php';

// Requête pour récupérer les tweets avec les informations de l'utilisateur
$query = "SELECT t.*, u.nom AS nom_utilisateur FROM Tweets AS t
          JOIN User AS u ON t.User_ID = u.ID
          ORDER BY t.created_at DESC";

$result = $db->query($query);

// Vérifier si des tweets sont disponibles
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $tweet_id = $row['ID'];
        $user_name = $row['nom_utilisateur'];
        $tweet_text = $row['texte'];

        // Afficher le tweet
        echo "<div class='tweet'>";
        echo "<p><strong>$user_name</strong></p>";
        echo "<p>$tweet_text</p>";

        // Afficher le bouton "Like" avec le nombre de likes (vous devez récupérer le nombre de likes pour ce tweet)
        // Afficher le bouton "Retweet" avec le nombre de retweets (vous devez récupérer le nombre de retweets pour ce tweet)
        // Afficher le bouton "Citer"

        echo "</div>";
    }
} else {
    echo "Aucun tweet n'a été trouvé.";
}
?>
