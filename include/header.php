<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="include/style.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body>
<header><a href="index.php"><img src="../toad/image/toad.jpg" alt=""></a>
<div>
    
    <ul>
        <a href="index.php"><li>Accueil</li></a>
        <a href="login.php"><li>Connexion</li></a>
        <a href="register.php"><li>Inscription</li></a>
        <a href="espace.php">
        <?php if (isset($_SESSION["id"])){
            include 'view.php';?></a>
       <?php }else  {?>
            <a href="login.php"><img src="image/default.jpg" alt=""></a>; <?php
        }
        ?>
    </ul>
</div></header>