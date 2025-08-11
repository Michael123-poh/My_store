<?php
session_start();

// 1. Connexion à la BD (comme dans votre exemple)
require_once('models/H_databaseConnection.php');
$H_dbConnect = F_databaseConnection("localhost", "m&ystore", "root", "");

//**********appel du fichier des fonctions creer ************ */
require("models/H_functionsModels.php");


if (isset($_POST['connecter'])){
    extract($_POST);

    $Y_clientConnecter = 'SELECT * FROM user WHERE nomUser = ? AND passwordUser = ?';
    $Y_executeClientConnecter = F_executeRequeteSql($Y_clientConnecter, [$username, $password]);

    $_SESSION['H_idEmploye'] = $Y_executeClientConnecter->idUser;
    if (!empty($Y_executeClientConnecter)){
        header('Location:controller/produitController.php?H_idEmploye='.$_SESSION['H_idEmploye'].'');
    }
}

require('views/login/loginView.php');
?>