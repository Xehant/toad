<?php include "../include/header.php" ;
include 'verif_login.php';?>
<fieldset style="width:270px">
<legend>Contact details</legend> 

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
          <button type="submit" name="logger">Se connecter</button>
        </div>
</form>
</fieldset>
</body>  
</html>