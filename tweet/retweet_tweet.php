<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        

<?php
include_once '../include/config.php';

if (isset($_GET['tweets_id'])) {
    $user_id = $_SESSION['id'];
    $tweets_id = $_GET['tweets_id'];

    // Vérifier si l'utilisateur n'a pas déjà aimé ce tweet
    $queryCheck = "SELECT * FROM Retweets WHERE User_ID = :user_id AND Tweets_ID = :tweets_id";
    $stmtCheck = $db->prepare($queryCheck);
    $stmtCheck->bindParam(':user_id', $user_id);
    $stmtCheck->bindParam(':tweets_id', $tweets_id);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() == 0) {
        // L'utilisateur n'a pas encore aimé ce tweet, enregistrez le like
        $queryInsert = "INSERT INTO Retweets (User_ID, Tweets_ID, Created_At) VALUES (:user_id, :tweets_id, NOW())";
        $stmtInsert = $db->prepare($queryInsert);
        $stmtInsert->bindParam(':user_id', $user_id);
        $stmtInsert->bindParam(':tweets_id', $tweets_id);
        $stmtInsert->execute();
         // Mettre à jour le compteur de Retweets dans la table Tweets
         $queryUpdateRetweets = "UPDATE Tweets SET Retweets_count = Retweets_count + 1 WHERE ID = :tweets_id";
         $stmtUpdateRetweets = $db->prepare($queryUpdateRetweets);
         $stmtUpdateRetweets->bindParam(':tweets_id', $tweets_id);
         $stmtUpdateRetweets->execute();
    } else {
        // Si l'utilisateur annule son like, supprimez le like
        $queryDelete = "DELETE FROM Retweets WHERE User_ID = :user_id AND Tweets_ID = :tweets_id";
        $stmtDelete = $db->prepare($queryDelete);
        $stmtDelete->bindParam(':user_id', $user_id);
        $stmtDelete->bindParam(':tweets_id', $tweets_id);
        $stmtDelete->execute();

        // Mettre à jour le compteur de Retweets dans la table Tweets
        $queryUpdateRetweets = "UPDATE Tweets SET Retweets_count = Retweets_count - 1 WHERE ID = :tweets_id";
        $stmtUpdateRetweets = $db->prepare($queryUpdateRetweets);
        $stmtUpdateRetweets->bindParam(':tweets_id', $tweets_id);
        $stmtUpdateRetweets->execute();
    }

}

// Rediriger l'utilisateur vers la page précédente ou une autre page
 header("Location: ../base/index.php");
exit();
?>
</body>
</html>