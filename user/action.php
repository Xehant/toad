<?php
if (isset($_POST['inscrire'])) {
    
        if (!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['mdp']) && !empty($_POST['rmdp'])) {
            $name = $_POST['nom'];
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            $rmdp = $_POST['rmdp'];

            if ($mdp == $rmdp) {
                $cle = rand(100, 100000);
                $mdp = password_hash($mdp, PASSWORD_BCRYPT);

                $insert = $db->prepare("INSERT INTO user(nom,email,mdp)VALUES(?,?,?)");
                $insert->execute(array($name, $email, $mdp));

                echo '<div class="alert alert-danger">Vous êtes inscrit</div>';
            } else {
                echo '<div class="alert alert-danger">Les mots de passe ne correspondent pas</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Tous les champs sont obligatoires</div>';
        }
    }

?>
