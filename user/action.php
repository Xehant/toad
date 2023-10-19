<?php
if (isset($_POST['inscrire'])) {
    if (!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['mdp']) && !empty($_POST['rmdp'])) {
        $name = $_POST['nom'];
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        $rmdp = $_POST['rmdp'];

        // Utilisation d'une expression régulière pour vérifier la complexité du mot de passe
        $passwordPattern = '/^(?=.*[A-Z])(?=.*\d).{8,}$/';

        if ($mdp == $rmdp && preg_match($passwordPattern, $mdp)) {
            $cle = rand(100, 100000);
            $mdp = password_hash($mdp, PASSWORD_BCRYPT);

            $insert = $db->prepare("INSERT INTO user(nom,email,mdp) VALUES(?,?,?)");
            $insert->execute(array($name, $email, $mdp));

            echo '<h2 class="alert alert-danger">Vous êtes inscrit</h2>';
        } elseif ($mdp != $rmdp) {
            echo '<h2 class="alert alert-danger">Les mots de passe ne correspondent pas</h2>';
        } else {
            echo '<h2 class="alert alert-danger">Le mot de passe doit contenir au moins 8 caractères, dont au moins 1 majuscule et 1 chiffre</h2>';
        }
    } else {
        echo '<h2">Tous les champs sont obligatoires</h2>';
    }
}

?>
