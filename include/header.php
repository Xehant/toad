<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../include/style.css">
    <link id="night-mode-stylesheet" rel="stylesheet" href="../include/night-mode.css" disabled>

    <title>Document</title>
</head>  <!-- Vos balises meta, liens vers les feuilles de style, etc. -->
</head>
<body>
    <!-- Barre latérale verticale (aside) -->
    <aside class="sidebar"><a href="../base/index.php"><img src="../image/toad.jpg" alt=""></a>
        <div class="aside-links">
        <ul class="menu">
            <!-- Liens de navigation dans la barre latérale -->
          
            <li><a href="../base/index.php"><i class="fa-regular fa-house" style="color: #2c511f;"></i>Accueil</a></li>
            <li><a href="../user/login.php">Connexion</a></li>
            <li><a href="../user/register.php">Inscription</a></li>
            <li><a id="night-mode-toggle"><i class="fa-light fa-cloud-moon" style="color: #20511f;"></i>Activer le mode nuit</a></li>
            </ul> 
       </div><a href="../user/espace.php">
        <?php if (isset($_SESSION["id"])){
            include '../user/view.php'?></a>
       <?php }else  {?>
            <a href="../user/login.php"><img src="../image/default.jpg" alt=""></a> <?php
        }
        ?>
    </aside>

    <!-- Contenu principal (main content) -->
    <main class="main-content">
        <!-- Le reste du contenu de votre page -->
        <!-- Tweets, formulaires, etc. -->
