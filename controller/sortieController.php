<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']); 

// 1. Connexion à la BD (comme dans votre exemple)
require_once('../models/H_databaseConnection.php');
$H_dbConnect = F_databaseConnection("localhost", "m&ystore", "root", "");

//**********appel du fichier des fonctions creer ************ */
require("../models/H_functionsModels.php");

// 1.1 PAGINATION
$transactionsParPage = 6;
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
$Y_nombreSortie = "SELECT COUNT(t.id_transaction) AS total_produits_sortie_aujourdhui FROM `transaction` t WHERE t.id_type_transaction = 'TPT00002' AND DATE(t.date_reception) = CURDATE() ";
$Y_executeNombreSortie = F_executeRequeteSql($Y_nombreSortie);

foreach($Y_executeNombreSortie as $nombreSortie){

    if ($nombreSortie->total_produits_sortie_aujourdhui == NULL){
        $nombre = 0;
    }else
    $nombre = $nombreSortie->total_produits_sortie_aujourdhui;
}

// 3. LE NOMBRE DE CLIENT
$Y_nombreClient = "SELECT COUNT(c.idClient) AS total_nombre_client FROM client c ";
$Y_executeNombreClient = F_executeRequeteSql($Y_nombreClient);

foreach($Y_executeNombreClient as $totalClient){

    if ($totalClient->total_nombre_client == NULL){
        $totals = 0;
    }else
    $totals = $totalClient->total_nombre_client;
}

// 3.1. LES CLIENT
$Y_clients = F_executeRequeteSql("SELECT c.nomComplet, c.idClient FROM client c ");


// 3.2. LES CLIENT
$Y_produitss = F_executeRequeteSql("SELECT * FROM produit ");

// 4. SOMME DETTE
$Y_totalDette = "SELECT SUM(tp.quantite_recue * tp.prix_unitaire) AS total_dette_aujourdhui FROM transaction_produit tp JOIN `transaction` t ON tp.id_transaction = t.id_transaction WHERE t.id_type_transaction = 'TPT00002' AND status_transaction = 1 AND DATE(t.date_reception) = CURDATE() ";
$Y_executeTotalDette = F_executeRequeteSql($Y_totalDette);

foreach($Y_executeTotalDette as $totalDette){

    if ($totalDette->total_dette_aujourdhui == NULL){
        $DetteSomme = 0;
    }else
    $DetteSomme = $totalDette->total_dette_aujourdhui;
}

// 5. ENCAISSER AUJOURD'HUI
$Y_totalEncaisser = "SELECT SUM(tp.quantite_recue * tp.prix_unitaire) AS total_encaisser_aujourdhui FROM transaction_produit tp JOIN transaction t ON tp.id_transaction = t.id_transaction WHERE t.id_type_transaction = 'TPT00002' AND status_transaction = 0 AND DATE(t.date_reception) = CURDATE() ";
$Y_executeTotalEncaisser = F_executeRequeteSql($Y_totalEncaisser);

foreach($Y_executeTotalEncaisser as $totalEncaisser){

    if ($totalEncaisser->total_encaisser_aujourdhui == NULL){
        $EncaisserSomme = 0;
    }else
    $EncaisserSomme = $totalEncaisser->total_encaisser_aujourdhui;
}

// 6. SELECTIONER TOUTE LES TRANSACTIONS
$Y_transaction = "SELECT t.id_transaction, t.idClient, DATE_FORMAT(t.date_reception, '%d/%m/%Y %H:%i') AS date_formatee, c.nomComplet, COUNT(DISTINCT tp.id_produit) AS nombre_articles_distincts, SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total, t.status_transaction FROM client c JOIN `transaction` t ON t.idClient = c.idClient JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction WHERE t.id_type_transaction = 'TPT00002' GROUP BY t.id_transaction, t.date_reception, c.nomComplet, t.status_transaction ORDER BY t.date_reception DESC LIMIT $transactionsParPage OFFSET $offset";
$Y_executeTransaction = F_executeRequeteSql($Y_transaction);

// 7. AFFICHER LES DETAIL DE LA SORTIE 
if(isset($_POST['id_transaction'])) {
    extract($_POST);

    $Y_DetailProduit = "SELECT p.nomProduit AS nom, p.id_produit AS code, tp.quantite_recue AS quantite, tp.prix_unitaire, tp.note_transaction FROM produit p  JOIN transaction_produit tp ON p.id_produit = tp.id_produit  JOIN `transaction` t ON t.id_transaction = tp.id_transaction WHERE tp.id_transaction = ? AND t.id_type_transaction = 'TPT00002' ";
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
                         WHERE t.id_transaction = ? AND t.id_type_transaction = 'TPT00002'
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

// 7. VALIDER/PAYER L'ENTREE
if(isset($_POST['payer'])){
    extract($_POST);
    $type = 1;
    // Sortie pour 1
    $Y_updateStatutEntree = "UPDATE `transaction` SET `status_transaction` = '0' WHERE `transaction`.`id_transaction` = ? ";
    $Y_executUpdateStatutEntree  = F_executeRequeteSql($Y_updateStatutEntree, [$payer]);

    // 6. SELECTIONER TOUTE LES TRANSACTIONS
    $Y_Somme = "SELECT SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total FROM `transaction` t JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction WHERE t.id_type_transaction = 'TPT00002' AND t.id_transaction = ? ";
    $Y_executeSomme = F_executeRequeteSql($Y_Somme, [$payer]);

    $SommeT = $Y_executeSomme->montant_total;

    $Y_caisseDernier = F_executeRequeteSql("SELECT id_caisse FROM ciasse ORDER BY id_caisse DESC LIMIT 1");

    foreach($Y_caisseDernier as $caisse){
        $caisse1 = $caisse->id_caisse;
    }

    $nouvelleIdCaisse = F_genereMatricule($caisse1, 'CAI00001');
    $Y_insertCaisse = 'INSERT INTO `ciasse`(id_caisse, id_transaction, `type`, 	MontantT, date_create) VALUES(?, ?, ?, ?, NOW())';
    $Y_tableauValeurs = [$nouvelleIdCaisse, $payer, $type, $SommeT];
    $Y_executeInsertCaisse = F_executeRequeteSql($Y_insertCaisse, $Y_tableauValeurs);

    $Y_updateStockProduits = "UPDATE produit p
    JOIN transaction_produit tp ON p.id_produit = tp.id_produit
    SET p.quantiteProduit = p.quantiteProduit - tp.quantite_recue
    WHERE tp.id_transaction = ?
    ";
    F_executeRequeteSql($Y_updateStockProduits, [$payer]);


    header('Location:sortieController.php');
}

// 8. ANNULER UN PAIEMENT 
if(isset($_POST['annuler'])){
    extract($_POST);
    // Annulee pour 2
    $Y_updateStatutEntree2 = "UPDATE `transaction` SET `status_transaction` = '2' WHERE `transaction`.`id_transaction` = ? ";
    $Y_executUpdateStatutEntree2  = F_executeRequeteSql($Y_updateStatutEntree2, [$annuler]);
    header('Location:sortieController.php');
}

// 9. HISTORIQUE
$Y_historique = "SELECT 
    t.id_transaction,
    c.nomComplet,
    t.status_transaction,
    SUM(tp.quantite_recue * tp.prix_unitaire) AS montant_total,
    COUNT(tp.id_produit) AS nombre_articles,
    CASE
        WHEN TIMESTAMPDIFF(MINUTE, t.date_reception, NOW()) < 60
            THEN CONCAT(TIMESTAMPDIFF(MINUTE, t.date_reception, NOW()), ' min')
        WHEN TIMESTAMPDIFF(HOUR, t.date_reception, NOW()) < 24
            THEN CONCAT(TIMESTAMPDIFF(HOUR, t.date_reception, NOW()), ' h')
        ELSE CONCAT(TIMESTAMPDIFF(DAY, t.date_reception, NOW()), ' j')
    END AS duree_depuis_transaction
FROM client c
JOIN `transaction` t ON c.idClient = t.idClient
JOIN transaction_produit tp ON tp.id_transaction = t.id_transaction
WHERE t.id_type_transaction = 'TPT00002'
GROUP BY t.id_transaction, c.nomComplet, t.date_reception
ORDER BY t.date_reception DESC
LIMIT 5";
$Y_executeHistorique = F_executeRequeteSql($Y_historique);

// 10. LISTE DES CLIENT ET LEURS DETTES
$Y_executeClients = F_executeRequeteSql(" SELECT 
        c.*, c.telephone_client, c.Type_client,
        COUNT(DISTINCT t.id_transaction) AS nombre_commandes,
        COALESCE(SUM(CASE WHEN t.status_transaction = 1 THEN tp.quantite_recue * tp.prix_unitaire ELSE 0 END), 0) AS total_dette,
        COALESCE(SUM(CASE WHEN t.status_transaction = 0 THEN tp.quantite_recue * tp.prix_unitaire ELSE 0 END), 0) AS total_verse
    FROM client c
    LEFT JOIN transaction t ON c.idClient = t.idClient
    LEFT JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction
    WHERE c.Type_client = 1
    GROUP BY c.idClient
    ORDER BY c.nomComplet
");

// ENREGISTRER CLIENT
if(isset($_POST['EnregistreClient'])){
    extract($_POST);


    $Y_caisseClient = F_executeRequeteSql("SELECT idClient  FROM client ORDER BY idClient DESC LIMIT 1");

    foreach($Y_caisseClient as $client){
        $client1 = $client->idClient ;
    }

    $nouveauClient = F_genereMatricule($client1, 'CLI00001');
    $Y_insertClient = 'INSERT INTO `client`(idClient, nomComplet, adresse, telephone_client, date_create) VALUES(?, ?, ?, ?, NOW())';
    $Y_tableauValeurs = [$nouveauClient, $name, $adresse, $tel];
    $Y_executeInsertCaisse = F_executeRequeteSql($Y_insertClient, $Y_tableauValeurs);
    header('Location:sortieController.php');
}

// ENREGISTRER UNE NOUVELLE SORTIE
if (isset($_POST['enregistrerSortie'])) {
    extract($_POST);

    // Génération de l'ID de transaction
    $dernier = F_executeRequeteSql("SELECT id_transaction FROM transaction ORDER BY id_transaction DESC LIMIT 1");
    $dernierId = $dernier[0]->id_transaction ?? 'TRS00000';
    $nouvelleTransaction = F_genereMatricule($dernierId, 'TRS00001');

    $id_fournisseur = "FRN00000";
    $id_type_trs = "TPT00002"; // Sortie
    $status = 1; // Non payé

    // Insertion de la transaction
    $insertTransaction = "INSERT INTO transaction (id_transaction, id_fournisseur, idClient, id_type_transaction, status_transaction, date_reception) VALUES (?, ?, ?, ?, ?, ?)";
    F_executeRequeteSql($insertTransaction, [$nouvelleTransaction, $id_fournisseur, $client, $id_type_trs, $status, $date]);

    // Récupérer les produits depuis le JSON
    $produits = json_decode($_POST['produits_json'], true);

    foreach ($produits as $prod) {
        $prodId = $prod['id'];
        $qte_attendue = (int) $prod['expectedQty'];
        $qte_recue = (int) $prod['receivedQty'];
        $prix = (float) $prod['price'];

        // Génération ID produit transaction
        $dernierProd = F_executeRequeteSql("SELECT id_transaction_produit FROM transaction_produit ORDER BY id_transaction_produit DESC LIMIT 1");
        $dernierProdId = $dernierProd[0]->id_transaction_produit ?? 'TRP00000';
        $nouveauIdProduit = F_genereMatricule($dernierProdId, 'TRP00001');

        // Insertion dans transaction_produit
        $insertProduit = "INSERT INTO transaction_produit (id_transaction_produit, id_transaction, id_produit, quantite_attendue, quantite_recue, prix_unitaire) VALUES (?, ?, ?, ?, ?, ?)";
        F_executeRequeteSql($insertProduit, [$nouveauIdProduit, $nouvelleTransaction, $prodId, $qte_attendue, $qte_recue, $prix]);

        // Diminuer la quantité du stock produit
        $updateStock = "UPDATE produit SET quantiteProduit = quantiteProduit - ? WHERE id_produit = ?";
        F_executeRequeteSql($updateStock, [$qte_recue, $prodId]);
    }

    header('Location:sortieController.php');
    exit;
}


// FUNCTION POUR LE NOM DES PROFILE
function getInitialesClient($nomComplet) {
    // On enlève les espaces en début/fin
    $nomComplet = trim($nomComplet);

    // On découpe le nom en mots
    $mots = explode(' ', $nomComplet);

    // Si au moins deux mots (ex: "Jean Dupont")
    if (count($mots) >= 2) {
        return strtoupper(mb_substr($mots[0], 0, 1) . mb_substr($mots[1], 0, 1));
    } else {
        // Sinon on prend les deux premières lettres du nom unique
        return strtoupper(mb_substr($nomComplet, 0, 2));
    }
}

require('../views/sortie/sortieView.php');
?>
