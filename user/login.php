<?php include "../include/header.php" ;
include '../user/verif_login.php';?>
<fieldset>
<h2>Connexion</h2> 

<form action="" method="post">
        <div class="from-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control">
        </div>
        

        <div class=from-group>
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" class="form-control">
        </div>

        <div class=from-group>
          <input type="submit" class="submit" name="logger"value="Se connecter"></input>
        </div>
        <h2 class="log">Pas encore inscrit? <a href="login.php">Inscrivez-vous</a></h2>
</form>
</fieldset>
<?php include("../include/footer.php");?>