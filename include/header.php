<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../include/style.css">
    <link id="night-mode-stylesheet" rel="stylesheet" href="../include/night-mode.css" disabled>

    <title>Document</title>
</head>
<body>
<header><a href="../base/index.php"><img src="../image/toad.jpg" alt=""></a>
<div>
    
    <ul class="menu">
        <li><a href="../base/index.php">Accueil</a></li>
        <li><a href="../user/login.php">Connexion</a></li>
        <li><a href="../user/register.php">Inscription</a></li>
        <li><div id="../include/night-mode-toggle"><i class="fa-light fa-cloud-moon" style="color: #20511f;"></i>Activer le mode nuit</div></li>
        <a href="../user/espace.php">
        <?php if (isset($_SESSION["id"])){
            include '../user/view.php'?></a>
       <?php }else  {?>
            <a href="../user/login.php"><img src="../image/default.jpg" alt=""></a> <?php
        }
        ?>
    </ul>
</div></header>