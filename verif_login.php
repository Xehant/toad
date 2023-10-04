<?php
include_once 'config.php';

if(isset($_POST["logger"])){
    if(!empty($_POST["email"]) AND !empty($_POST["mdp"])){
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];

        $req = $db->prepare("SELECT id, mdp FROM User WHERE email = :email");
        $req->execute(array(':email' => $email));

        if($result = $req->fetch()){
            if (password_verify($mdp, $result['mdp'])) {
                // Mot de passe correct, l'utilisateur est connecté
                $_SESSION["id"] = $result["id"];
                header("Location: espace.php");
                exit(); // Arrête l'exécution du script après la redirection
            } else {
                echo '<div class="alert alert-danger">Le mot de passe ou l\'email est incorrect</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Le mot de passe ou l\'email est incorrect</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Le mot de passe ou l\'email est incorrect</div>';
    }
}
?>
