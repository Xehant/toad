<?php
include_once '../include/config.php';

if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];

    if (!empty($id)) {
        // Get image data from database
        $stmt = $db->prepare("SELECT photo FROM User WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Check if any rows were returned
        if ($stmt->rowCount() > 0) {
            $imgData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Output the image data as an <img> element
            echo '<img src="data:image/jpeg;base64,' . base64_encode($imgData['photo']) . '" alt="Photo de profil">';
        } else {
            echo 'Image not found...';
        }
    } else {
        echo 'ID is empty...';
    }
} else {
    echo 'ID is not set...';
}
?>
