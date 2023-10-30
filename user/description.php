<?php
// Assurez-vous d'appeler session_start() au début du fichier
include_once '../include/config.php';

if (isset($_SESSION["id"])) {
    // Récupérez l'ID de l'utilisateur connecté
    $user_id = $_SESSION["id"];

    // Récupérez la nouvelle description depuis le formulaire
    if (isset($_POST["description"])) {
        $new_description = $_POST["description"];
        
        // Effectuez la mise à jour de la description dans la base de données (remplacez cela par votre propre logique)
   // Incluez votre fichier de configuration de base de données

        // Préparez la requête SQL pour mettre à jour la description
        $query = "UPDATE user SET description = :description WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':description', $new_description);
        $stmt->bindParam(':id', $user_id);

        if ($stmt->execute()) {
            header("Location:../user/espace.php");
        } else {
            echo "Une erreur est survenue lors de la mise à jour de la description.";
        }
    }}
?>
