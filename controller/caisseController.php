<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']); 


// 1. Connexion à la BD (comme dans votre exemple)
require_once('../models/H_databaseConnection.php');
$H_dbConnect = F_databaseConnection("localhost", "m&ystore", "root", "");

//**********appel du fichier des fonctions creer ************ */
require("../models/H_functionsModels.php");

// 2. SOMME DES MONTANT DES ENTREE
$Y_executeSommeCaisseEntree = F_executeRequeteSql("SELECT SUM(c.MontantT) AS Montant_Caisse_Entree FROM ciasse c WHERE c.type = '0' ");
foreach($Y_executeSommeCaisseEntree as $sommeCaisseEntree){

    if ($sommeCaisseEntree->Montant_Caisse_Entree == NULL){
        $sommeEntree = 0;
    }else
        $sommeEntree = $sommeCaisseEntree->Montant_Caisse_Entree;
}

// 3. SOMME DES MONTANT DES SORTIE
$Y_executeSommeCaisseSortie = F_executeRequeteSql("SELECT SUM(c.MontantT) AS Montant_Caisse_Sortie FROM ciasse c WHERE c.type = '1' ");
foreach($Y_executeSommeCaisseSortie as $sommeCaisseSortie){

    if ($sommeCaisseSortie->Montant_Caisse_Sortie == NULL){
        $sommeSortie = 0;
    }else
        $sommeSortie = $sommeCaisseSortie->Montant_Caisse_Sortie;
}

// 4. SOMME DES DETTE
$Y_executeSommeDette = F_executeRequeteSql("SELECT SUM(tp.quantite_recue * tp.prix_unitaire) AS total_valeur
FROM transaction_produit tp
JOIN `transaction` t ON tp.id_transaction = t.id_transaction
WHERE t.status_transaction = 1;
");
foreach($Y_executeSommeDette as $dette){

    if ($dette->total_valeur == NULL){
        $sommeDette = 0;
    }else
        $sommeDette = $dette->total_valeur;
}

// 5. SOMME DES MONTANT DES ENTREE
$Y_executeSommeCaisseEntree1 = F_executeRequeteSql("SELECT SUM(c.MontantT) AS Montant_Caisse_Entree1 FROM ciasse c ");
foreach($Y_executeSommeCaisseEntree1 as $sommeCaisseEntree1){

    if ($sommeCaisseEntree1->Montant_Caisse_Entree1 == NULL){
        $sommeEntree1 = 0;
    }else
        $sommeEntree1 = $sommeCaisseEntree1->Montant_Caisse_Entree1;
}

// 6. SELECTIONER TOUTE LES TRANSACTIONS
$Y_executeTransaction3 = F_executeRequeteSql("SELECT t.id_transaction, DATE_FORMAT(t.date_reception, '%d/%m/%Y %H:%i') AS date_formatee, c.nomComplet, COUNT(DISTINCT tp.id_produit) AS nombre_articles_distincts, SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total, t.id_type_transaction  FROM client c JOIN `transaction` t ON t.idClient = c.idClient JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction GROUP BY t.id_transaction, t.date_reception, c.nomComplet, t.status_transaction ORDER BY t.date_reception ");
require('../views/caisse/caisseView.php');
?>