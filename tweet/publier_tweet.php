<?php
include_once '../include/config.php';

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

        // Vérifiez si une image a été téléversée
        $tweet_image = null;

        if (!empty($_FILES['tweet_image']['tmp_name'])) {
            // Vérifiez le type MIME
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $imageInfo = getimagesize($_FILES['tweet_image']['tmp_name']);
            
            if (in_array($imageInfo['mime'], $allowedTypes)) {
                // Conversion de l'image en format binaire
                $tweet_image = file_get_contents($_FILES['tweet_image']['tmp_name']);
            } else {
                echo "Le type de fichier n'est pas autorisé. Seuls les fichiers JPEG, PNG ou GIF sont acceptés.";
                exit();
            }
        }

        // Insérer le tweet dans la base de données avec le texte et l'image (peut être NULL)
        $query = "INSERT INTO Tweets (User_nom, User_photo, texte, tweet_image, created_at) VALUES (:user_name, :user_photo, :tweet_text, :tweet_image, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':tweet_text', $tweet_text);
        $stmt->bindParam(':user_photo', $user_photo);
        $stmt->bindParam(':tweet_image', $tweet_image, PDO::PARAM_LOB);

        if ($stmt->execute()) {
            // Rediriger l'utilisateur vers la page d'accueil ou une autre page après la publication du tweet
            header("Location: ../base/index.php");
            exit();
        } else {
            echo "Une erreur est survenue lors de la publication du tweet.";
        }
    } else {
        echo "Utilisateur introuvable.";
    }
} else {
    header("Location:../base/index.php");
}
?>
