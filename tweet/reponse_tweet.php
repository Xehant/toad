<?php
include_once '../include/config.php';

if (isset($_POST['tweets_id'], $_POST['reponse_tweet'])) {
    // Récupérer l'ID de l'utilisateur connecté
    $user_id = $_SESSION['id'];

    // Récupérer l'ID du tweet
    $tweet_id = $_POST['tweets_id'];

    // Récupérer le texte du commentaire depuis le formulaire
    $reponse_tweet = $_POST['reponse_tweet'];

    // Récupérer les informations de l'utilisateur connecté
    $queryUser = "SELECT * FROM User WHERE ID = :user_id";
    $stmtUser = $db->prepare($queryUser);
    $stmtUser->bindParam(':user_id', $user_id);
    $stmtUser->execute();
    $userInfo = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($userInfo) {
        // Récupérer le nom de l'utilisateur
        $user_nom = $userInfo['nom'];
        $user_photo = $userInfo['photo'];

        // Insérer le commentaire dans la base de données avec les informations de l'utilisateur
        $query = "INSERT INTO Comments (Tweets_ID, User_ID, User_nom, User_photo, Comment_text, created_at) VALUES (:tweet_id, :user_id, :user_nom, :user_photo, :reponse_tweet, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':tweet_id', $tweet_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':user_nom', $user_nom, PDO::PARAM_STR, 20);
        $stmt->bindParam(':user_photo', $user_photo, PDO::PARAM_LOB);
        $stmt->bindParam(':reponse_tweet', $reponse_tweet);

        if ($stmt->execute()) {
            // Rediriger l'utilisateur vers la page actuelle ou une autre page après avoir ajouté le commentaire
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Une erreur est survenue lors de l'ajout du commentaire.";
        }
    } else {
        echo "Utilisateur introuvable.";
    }
} else {
    echo "Le tweet n'est pas trouvé.";
}
?>