<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);

// Connexion BD
require_once('../models/H_databaseConnection.php');
$H_dbConnect = F_databaseConnection("localhost", "m&ystore", "root", "");

// Fonctions
require_once('../models/H_functionsModels.php');

// Liste des clients
$Y_clients = F_executeRequeteSql("SELECT idClient, nomComplet, adresse, telephone_client FROM client WHERE Type_client = 1");

// Liste des fournisseurs
$Y_fournisseurs = F_executeRequeteSql("SELECT id_fournisseur, nom_fournisseur, adresse FROM fournisseur");

// Vue
require('../views/rapport/rapportView.php');
