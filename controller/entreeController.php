<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']); 

// 1. Connexion à la BD (comme dans votre exemple)
require_once('../models/H_databaseConnection.php');
$H_dbConnect = F_databaseConnection("localhost", "m&ystore", "root", "");

//**********appel du fichier des fonctions creer ************ */
require("../models/H_functionsModels.php");

// 1.1 PAGINATION
$transactionsParPage = 5;
$pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($pageActuelle - 1) * $transactionsParPage;

// LE NOMBRE TOTAL
$Y_count = "SELECT COUNT(DISTINCT t.id_transaction) as total 
            FROM `transaction` t
            JOIN fournisseur f ON t.id_fournisseur = f.id_fournisseur
            JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction
            WHERE t.id_type_transaction = 'TPT00001'";

$totalResult = F_executeRequeteSql($Y_count);
$totalTransactions = $totalResult[0]->total;
$totalPages = ceil($totalTransactions / $transactionsParPage);



// 2. LE NOMBRE DE PRODUIT ENTREE AUJOURD'HUI
$Y_nombreSortie = "SELECT SUM(tp.quantite_recue) AS total_produits_recus_aujourdhui FROM transaction_produit tp JOIN transaction t ON tp.id_transaction = t.id_transaction WHERE t.id_type_transaction = 'TPT00001' AND DATE(t.date_reception) = CURDATE() ";
$Y_executeNombreSortie = F_executeRequeteSql($Y_nombreSortie);

foreach($Y_executeNombreSortie as $nombreSortie){

    if ($nombreSortie->total_produits_recus_aujourdhui == NULL){
        $nombre = 0;
    }else
        $nombre = $nombreSortie->total_produits_recus_aujourdhui;
}

// 2.1 SORTIE DU MOIs
$Y_SortieMois = F_executeRequeteSql("SELECT COUNT(t.id_transaction) AS total_produits_sortie_mois 
FROM `transaction` t 
WHERE t.id_type_transaction = 'TPT00001' 
AND MONTH(t.date_reception) = MONTH(CURDATE()) 
AND YEAR(t.date_reception) = YEAR(CURDATE());
");
foreach($Y_SortieMois as $moisNombre){
    if($moisNombre->total_produits_sortie_mois == NULL){
        $nombreMois = 0;
    }else
        $nombreMois = $moisNombre->total_produits_sortie_mois;
}

// 3. LA SOMME DES PAIEMENT RECUE CE JOUR
$Y_sommeEntree = "SELECT SUM(tp.quantite_recue * tp.prix_unitaire) AS total_paiements_aujourdhui FROM transaction_produit tp JOIN transaction t ON tp.id_transaction = t.id_transaction WHERE t.id_type_transaction = 'TPT00001' AND status_transaction = 0 AND DATE(t.date_reception) = CURDATE() ";
$Y_executeSommeEntree = F_executeRequeteSql($Y_sommeEntree);

foreach($Y_executeSommeEntree as $sommeEntree){
    $somme = $sommeEntree->total_paiements_aujourdhui;
}

// 4. LA SOMME DES DETTE DU JOUR
$Y_sommeDette = "SELECT SUM(tp.quantite_recue * tp.prix_unitaire) AS total_dette_aujourdhui FROM transaction_produit tp JOIN transaction t ON tp.id_transaction = t.id_transaction WHERE t.id_type_transaction = 'TPT00001' AND status_transaction = 1 AND DATE(t.date_reception) = CURDATE() ";
$Y_executeSommeDette = F_executeRequeteSql($Y_sommeDette);

    foreach($Y_executeSommeDette as $sommeDette){
        
        if ($sommeDette->total_dette_aujourdhui == NULL){
            $somme2 = 0;
        }else{
            $somme2 = $sommeDette->total_dette_aujourdhui;
        }
        
    }
// 5. LE NOMBRE DE PRODUIT DISTINCTS ET COMBINEE 
$Y_nombreProduitStock = "SELECT COUNT(DISTINCT nomProduit) AS nombre_produits_distincts, SUM(quantiteProduit) AS nombre_produits_total FROM produit";
$Y_executeNombreProduitStock = F_executeRequeteSql($Y_nombreProduitStock);

foreach($Y_executeNombreProduitStock as $nombreProduitStock){
    $nombreProduitStockDistinct = $nombreProduitStock->nombre_produits_distincts;
}

// 6. SELECTIONER TOUTE LES TRANSACTIONS
$Y_transaction = "SELECT t.id_transaction, DATE_FORMAT(t.date_reception, '%d/%m/%Y %H:%i') AS date_formatee, f.nom_fournisseur, COUNT(DISTINCT tp.id_produit) AS nombre_articles_distincts, SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total, t.status_transaction FROM transaction t JOIN fournisseur f ON t.id_fournisseur = f.id_fournisseur JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction WHERE t.id_type_transaction = 'TPT00001' GROUP BY t.id_transaction, t.date_reception, f.nom_fournisseur, t.status_transaction ORDER BY t.date_reception DESC LIMIT $transactionsParPage OFFSET $offset";
$Y_executeTransaction = F_executeRequeteSql($Y_transaction);

// 7. ON RECUPERE LES FOURNISSEUR
$Y_fournisseurs = F_executeRequeteSql("SELECT * FROM fournisseur");

// 8. ON RECUPERE LES PRODUIT
$Y_produitss = F_executeRequeteSql("SELECT * FROM produit");

// 9. AJOUTER UNE NOUVELLE ENTREE
if(isset($_POST['enregistrer'])){
    extract($_POST);

    //******************************Dans la table Acheteur********************************
    //on recupere le dernier produit enregistré dans la bd
    $Y_dernierTransaction = 'SELECT transaction.id_transaction FROM `transaction` ORDER BY id_transaction  DESC LIMIT 1';
    $Y_executeDernierTransaction = F_executeRequeteSql($Y_dernierTransaction);
                                            
                                                      
    foreach($Y_executeDernierTransaction as $Y_transaction)
    {
        $Y_transaction1 = $Y_transaction->id_transaction;                                                      
    }
                                                    
    $Y_nouveauIdTransaction = F_genereMatricule($Y_transaction1, 'TRS00001'); //sinon on incremente le nième Acheteur
    // IDUSER TEMP
    $idClient = "CLI00000";
    $id_type_trs = "TPT00001";
    $status = 1;
    $Y_insertTransaction = 'INSERT INTO `transaction`(id_transaction, id_fournisseur, idClient, id_type_transaction, status_transaction, date_reception) VALUES(?, ?, ?, ?, ?, NOW())';
    $Y_tableauValeurs = [$Y_nouveauIdTransaction, $fournisseur, $idClient, $id_type_trs, $status];
    $Y_executeInsertTransaction = F_executeRequeteSql($Y_insertTransaction, $Y_tableauValeurs); //ajoute le nouveau Acheteur pour la descente


    // INSERER LES PRODUIT DE LA COMMANDE
    if (!empty($_POST['products']) && is_array($_POST['products'])) {
        foreach ($_POST['products'] as $prods) {
            $idProduit = $prods['id'];
            $qteAttendue = $prods['expected_qty'];
            $qteRecue = $prods['received_qty'];
            $prixUnitaire = $prods['price'];

            $Y_produitss = F_executeRequeteSql("SELECT id_transaction_produit FROM transaction_produit ORDER BY id_transaction_produit DESC LIMIT 1");

            foreach($Y_produitss as $pro){
                $pro1 = $pro->id_transaction_produit;
            }

            $nouvelleIdPro = F_genereMatricule($pro1, 'TRP00001');
            $Y_insertTransactionPro = 'INSERT INTO `transaction_produit`(id_transaction_produit, id_transaction, id_produit, quantite_attendue, quantite_recue, prix_unitaire) VALUES(?, ?, ?, ?, ?, ?)';
            $Y_tableauValeurs = [$nouvelleIdPro, $Y_nouveauIdTransaction, $idProduit, $qteAttendue, $qteRecue, $prixUnitaire];
            $Y_executeInsertPro = F_executeRequeteSql($Y_insertTransactionPro, $Y_tableauValeurs); //ajoute le nouveau Acheteur pour la descente

        }
    }
}

// 10. AFFICHER LE DETAIL DES ENTREE
if(isset($_POST['id_transaction'])) {
    extract($_POST);

    $Y_DetailProduit = "SELECT p.nomProduit AS nom, p.id_produit AS code, tp.quantite_recue AS quantite, tp.prix_unitaire, tp.note_transaction FROM produit p  JOIN transaction_produit tp ON p.id_produit = tp.id_produit  JOIN `transaction` t ON t.id_transaction = tp.id_transaction WHERE tp.id_transaction = ? AND t.id_type_transaction = 'TPT00001' ";
    $resultatProduits  = F_executeRequeteSql($Y_DetailProduit, [$id_transaction]);

    if (!is_array($resultatProduits)) {
        $resultatProduits = [$resultatProduits];
    }

    // Infos générales de la transaction
    $Y_InfoPrincipale = "SELECT t.id_transaction, DATE_FORMAT(t.date_reception, '%d/%m/%Y %H:%i') AS date_formatee,
                                f.nom_fournisseur, SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total,
                                t.status_transaction
                         FROM transaction t
                         JOIN fournisseur f ON t.id_fournisseur = f.id_fournisseur
                         JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction
                         WHERE t.id_transaction = ? AND t.id_type_transaction = 'TPT00001'
                         GROUP BY t.id_transaction, t.date_reception, f.nom_fournisseur, t.status_transaction ";

    $infoPrincipale = F_executeRequeteSql($Y_InfoPrincipale, [$id_transaction]);
    if (is_array($infoPrincipale)) {
        $infoPrincipale = $infoPrincipale[0];
    }

    echo json_encode([
        'produits' => $resultatProduits,
        'infos' => [
            'id_transaction' => $infoPrincipale->id_transaction,
            'date_formatee' => $infoPrincipale->date_formatee,
            'nom_fournisseur' => $infoPrincipale->nom_fournisseur,
            'montant_total' => $infoPrincipale->montant_total,
            'status_transaction' => $infoPrincipale->status_transaction
        ]
    ]);
    exit;
}


// 11. VALIDER/PAYER L'ENTREE
if(isset($_POST['payer'])){
    extract($_POST);
    $type = 0;
    // Entree pour 0
    $Y_updateStatutEntree = "UPDATE `transaction` SET `status_transaction` = '0' WHERE `transaction`.`id_transaction` = ? ";
    $Y_executUpdateStatutEntree  = F_executeRequeteSql($Y_updateStatutEntree, [$payer]);

    // 6. SELECTIONER TOUTE LES TRANSACTIONS
    $Y_Somme = "SELECT SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total FROM `transaction` t JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction WHERE t.id_type_transaction = 'TPT00001' AND t.id_transaction = ? ";
    $Y_executeSomme = F_executeRequeteSql($Y_Somme, [$payer]);

    $SommeT = $Y_executeSomme->montant_total;

    $Y_caisseDernier = F_executeRequeteSql("SELECT id_caisse FROM ciasse ORDER BY id_caisse DESC LIMIT 1");

    foreach($Y_caisseDernier as $caisse){
        $caisse1 = $caisse->id_caisse;
    }

    $nouvelleIdCaisse = F_genereMatricule($caisse1, 'CAI00001');
    $Y_insertCaisse = 'INSERT INTO `ciasse`(id_caisse, id_transaction, `type`, 	MontantT, date_create) VALUES(?, ?, ?, ?, NOW())';
    $Y_tableauValeurs = [$nouvelleIdCaisse, $payer, $type, $SommeT];
    $Y_executeInsertCaisse = F_executeRequeteSql($Y_insertCaisse, $Y_tableauValeurs); //ajoute le nouveau Acheteur pour la descente

    header('Location:entreeController.php');
}

// 12. ANNULER UN PAIEMENT 
if(isset($_POST['annuler'])){
    extract($_POST);
    // Annulee pour 2
    $Y_updateStatutEntree2 = "UPDATE `transaction` SET `status_transaction` = '2' WHERE `transaction`.`id_transaction` = ? ";
    $Y_executUpdateStatutEntree2  = F_executeRequeteSql($Y_updateStatutEntree2, [$annuler]);
    header('Location:entreeController.php');
}

// 13. HISTORIQUE
$Y_historique = "SELECT 
    t.id_transaction,
    f.nom_fournisseur,
    t.status_transaction,
    COUNT(tp.id_produit) AS nombre_articles,
    CASE
        WHEN TIMESTAMPDIFF(MINUTE, t.date_reception, NOW()) < 60
            THEN CONCAT(TIMESTAMPDIFF(MINUTE, t.date_reception, NOW()), ' min')
        WHEN TIMESTAMPDIFF(HOUR, t.date_reception, NOW()) < 24
            THEN CONCAT(TIMESTAMPDIFF(HOUR, t.date_reception, NOW()), ' h')
        ELSE CONCAT(TIMESTAMPDIFF(DAY, t.date_reception, NOW()), ' j')
    END AS duree_depuis_transaction
FROM transaction t
JOIN fournisseur f ON t.id_fournisseur = f.id_fournisseur
JOIN transaction_produit tp ON tp.id_transaction = t.id_transaction
WHERE t.id_type_transaction = 'TPT00001'
GROUP BY t.id_transaction, f.nom_fournisseur, t.date_reception
ORDER BY t.date_reception DESC
LIMIT 5";
$Y_executeHistorique = F_executeRequeteSql($Y_historique);

// ENREGISTRER FOURNISSEUR
if(isset($_POST['enregistrerFournisseur'])){
    extract($_POST);
    $raison_Sociale = 'SARL';
    $Y_caisseFournisseur = F_executeRequeteSql("SELECT id_fournisseur FROM fournisseur ORDER BY id_fournisseur DESC LIMIT 1");

    foreach($Y_caisseFournisseur as $fournisseur){
        $fournisseur1 = $fournisseur->id_fournisseur ;
    }

    $nouveauFournisseur = F_genereMatricule($fournisseur1, 'FRN00000');
    $Y_insertFournisseur = 'INSERT INTO `fournisseur`(id_fournisseur, nom_fournisseur, raison_sociale, telephone, adresse, date_create) VALUES(?, ?, ?, ?, ?, NOW())';
    $Y_tableauValeurs = [$nouveauFournisseur, $name, $raison_Sociale, $telephone, $adresse];
    $Y_executeInsertFournisseur = F_executeRequeteSql($Y_insertFournisseur, $Y_tableauValeurs);
    header('Location:entreeController.php');
}


require('../views/entree/entreeView.php');
?>