<?php
include_once '../include/config.php';

if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];

    if (!empty($id)) {
        // Récupérer les données de l'image depuis la base de données
        $stmt = $db->prepare("SELECT c_image FROM Comments WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Vérifier si des lignes ont été retournées
        if ($stmt->rowCount() > 0) {
            $imgData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Afficher les données de l'image en tant qu'élément <img>
           
        } else {
            echo 'Image non trouvée...';
        }
    } else {
        echo 'ID est vide...';
    }
} else {
    echo 'ID n\'est pas défini...';
}
?>
