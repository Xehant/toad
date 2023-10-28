<?php 
include '../include/header.php';
include_once '../include/config.php';
include '../user/action.php';
if(isset($_GET["p"])){
$cle = $_GET["p"];
$req =$db->query("SELECT * FROM user WHERE cle = '".$cle."'");
$result=$req->fetchAll();

foreach($result as $results){
    $nom_parrain=$results["nom"];
}
$champ ="<div class='form-group'><label>Parrain</label><input type='text 'class='form-control 'name='name' value='".$nom_parrain."' readonly></div>";
}
?>
<fieldset>
    <form action="" method="post">
        <?php if(isset($champ)): ?>
            <?= $champ;?>
            <?php endif;?>
            <div class="form-group">
    <label for="nom">Pseudo</label>
    <input type="text" name="nom" id="nom" class="form-control">
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" class="form-control">
</div>
<div class="form-group">
    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" id="mdp" class="form-control">
</div>
<div class="form-group">
    <label for="rmdp">Confirmer mot de passe</label>
    <input type="password" name="rmdp" id="rmdp" class="form-control">
</div>
<div class="form-group">
    <input type="submit" class="submit" name="inscrire" value="S'inscrire">
</div>

        <h2 class="log">Déjà inscrit? <a href="login.php">connectez-vous</a></h2>
    </form>
        </fieldset>
<?php include("../include/footer.php");?>