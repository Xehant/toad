<?php
include_once 'config.php';

if (isset($_POST['tweet_text'])) {
    // Récupérer l'ID de l'utilisateur connecté
    $user_id = $_SESSION['id'];
    
    // Récupérer le texte du tweet depuis le formulaire
    $tweet_text = $_POST['tweet_text'];

    // Récupérer le nom de l'utilisateur connecté
    $queryUser = "SELECT * FROM User WHERE ID = :user_id";
    $stmtUser = $db->prepare($queryUser);
    $stmtUser->bindParam(':user_id', $user_id);
    $stmtUser->execute();
    $userInfo = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($userInfo) {
        // Récupérer le nom de l'utilisateur
        $user_name = $userInfo['nom'];
        $user_photo = $userInfo['photo'];

        // Insérer le tweet dans la base de données avec le nom de l'utilisateur
        $query = "INSERT INTO Tweets (User_nom, User_photo, texte, created_at) VALUES (:user_name,:user_photo, :tweet_text, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':tweet_text', $tweet_text);
        $stmt->bindParam(':user_photo', $user_photo);

        if ($stmt->execute()) {
            // Rediriger l'utilisateur vers la page d'accueil ou une autre page après la publication du tweet
            header("Location: index.php");
            exit();
        } else {
            echo "Une erreur est survenue lors de la publication du tweet.";
        }
    } else {
        echo "Utilisateur introuvable.";
    }
}

?>
