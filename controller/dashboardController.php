<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']); 

require_once('../models/H_databaseConnection.php');
require("../models/H_functionsModels.php");

$H_dbConnect = F_databaseConnection("localhost", "m&ystore", "root", "");

// STATISTIQUES GLOBALES
$totalProduits = F_executeRequeteSql("SELECT COUNT(*) AS total FROM produit")[0]->total;
$totalClients = F_executeRequeteSql("SELECT COUNT(*) AS total FROM client WHERE Type_client = 1")[0]->total;
$totalFournisseurs = F_executeRequeteSql("SELECT COUNT(*) AS total FROM fournisseur")[0]->total;
$totalEntrees = F_executeRequeteSql("SELECT COUNT(*) AS total FROM transaction WHERE id_type_transaction = 'TPT00001'")[0]->total;
$totalSorties = F_executeRequeteSql("SELECT COUNT(*) AS total FROM transaction WHERE id_type_transaction = 'TPT00002'")[0]->total;

// PRODUITS EN ALERTE
$produitsAlerte = F_executeRequeteSql("SELECT * FROM produit WHERE quantiteProduit < seuile_minimum");

// HISTORIQUES
$recentEntrees = F_executeRequeteSql("
    SELECT t.id_transaction, f.nom_fournisseur, t.date_reception, t.status_transaction, 
           SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total
    FROM transaction t
    JOIN fournisseur f ON t.id_fournisseur = f.id_fournisseur
    JOIN transaction_produit tp ON tp.id_transaction = t.id_transaction
    WHERE t.id_type_transaction = 'TPT00001'
    GROUP BY t.id_transaction
    ORDER BY t.date_reception DESC
    LIMIT 5
");

$recentSorties = F_executeRequeteSql("
    SELECT t.id_transaction, c.nomComplet AS nom_client, t.date_reception, t.status_transaction,
           SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total
    FROM transaction t
    JOIN client c ON t.idClient = c.idClient
    JOIN transaction_produit tp ON tp.id_transaction = t.id_transaction
    WHERE t.id_type_transaction = 'TPT00002'
    GROUP BY t.id_transaction
    ORDER BY t.date_reception DESC
    LIMIT 5
");

// MOUVEMENTS DE CAISSE PAR MOIS (6 derniers mois)
$caisseMois = F_executeRequeteSql("
    SELECT DATE_FORMAT(date_create, '%Y-%m') AS mois,
           SUM(CASE WHEN type = 0 THEN MontantT ELSE 0 END) AS entree,
           SUM(CASE WHEN type = 1 THEN MontantT ELSE 0 END) AS sortie
    FROM ciasse
    GROUP BY mois
    ORDER BY mois DESC
    LIMIT 6
");

// TOP PRODUITS LES PLUS COMMANDES (par quantite totale sortante)
$topProduits = F_executeRequeteSql("
    SELECT p.nomProduit, SUM(tp.quantite_recue) AS quantite_totale
    FROM transaction_produit tp
    JOIN produit p ON tp.id_produit = p.id_produit
    JOIN transaction t ON tp.id_transaction = t.id_transaction
    WHERE t.id_type_transaction = 'TPT00002'
    GROUP BY p.nomProduit
    ORDER BY quantite_totale DESC
    LIMIT 5
");

require('../views/dashboard/dashboardView.php');
