<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);

// 1. Connexion à la BD (comme dans votre exemple)
require_once('../models/H_databaseConnection.php');
$H_dbConnect = F_databaseConnection("localhost", "m&ystore", "root", "");

//**********appel du fichier des fonctions creer ************ */
require("../models/H_functionsModels.php");

// Récupération des paramètres de filtre
$Y_categorieFilter = $_GET['Y_categorie'] ?? null;
$Y_sort = $_GET['Y_sort'] ?? 'name_asc'; // Défaut: tri par nom A-Z

// Construction de la requête principale
$Y_Produits = "SELECT p.*, c.nomCategorie, f.raison_sociale, f.nom_fournisseur FROM produit p JOIN categorie_produit c ON p.id_categorie = c.id_categorie JOIN fournisseur f ON p.id_fournisseur = f.id_fournisseur WHERE 1=1";
$Y_params = [];

// Application des filtres
if ($Y_categorieFilter) {
    $Y_Produits .= " AND p.id_categorie = ?";
    $Y_params[] = $Y_categorieFilter;
}

// Gestion du tri
switch ($Y_sort) {
    case 'name_asc':
        $Y_Produits .= " ORDER BY p.nomProduit ASC";
        break;
    case 'name_desc':
        $Y_Produits .= " ORDER BY p.nomProduit DESC";
        break;
    case 'price_asc':
        $Y_Produits .= " ORDER BY p.prix_vente ASC";
        break;
    case 'price_desc':
        $Y_Produits .= " ORDER BY p.prix_vente DESC";
        break;
    default:
        $Y_Produits .= " ORDER BY p.date_create DESC";
}

// Exécution avec ou sans paramètres
$Y_listeProduits = empty($Y_params) 
    ? F_executeRequeteSql($Y_Produits) 
    : F_executeRequeteSql($Y_Produits, $Y_params);


// 4. Récupérer catégories et fournisseurs pour les formulaires
$Y_categories = F_executeRequeteSql("SELECT * FROM categorie_produit");
$Y_fournisseurs = F_executeRequeteSql("SELECT * FROM fournisseur");

// 5. Récupérer le nombre total de produit et de produit par categorie
$Y_nombreProduit = F_executeRequeteSql("SELECT COUNT(*) AS Total FROM produit");

 
// 6. Ajout de produit
if(isset($_POST['enregistrer'])){
    extract($_POST);
    //******************************Dans la table Acheteur********************************
    //on recupere le dernier produit enregistré dans la bd
    $Y_dernierProduit = 'SELECT produit.id_produit  FROM produit ORDER BY id_produit  DESC LIMIT 1';
    $Y_executeDernierProduit = F_executeRequeteSql($Y_dernierProduit);
                                            
                                                      
    foreach($Y_executeDernierProduit as $Y_produit)
    {
        $Y_produit = $Y_produit->id_produit;                                                      
    }
                                                    
    $Y_nouveauIdProduit = F_genereMatricule($Y_produit, 'PRD00001'); //sinon on incremente le nième Acheteur
    // IDUSER TEMP
    $idUser = "USR00001";
    $Y_insertProduit = 'INSERT INTO produit(id_produit, id_categorie, idUser, id_fournisseur, nomProduit, descriptions, prix_vente, quantiteProduit, seuile_minimum, date_create) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())';
    $Y_tableauValeurs = [$Y_nouveauIdProduit, $categorie, $idUser, $fournisseur, strtoupper($nomProduit), $description, $prixUnitaire, $quantite, $seuilMinimum];
    $Y_executeInsertProduit = F_executeRequeteSql($Y_insertProduit, $Y_tableauValeurs); //ajoute le nouveau Acheteur pour la descente
    $H_tableauErreurs[] = 'Nouvel Acheteur enregistré avec success!!!';

}


// Paramètres de pagination
$itemsPerPage = $_GET['itemsPerPage'] ?? 12; // Valeur par défaut
$currentPage = $_GET['page'] ?? 1;

// Validation
$itemsPerPage = max(12, min(96, (int)$itemsPerPage)); // Limite entre 12 et 96
$currentPage = max(1, (int)$currentPage);

// Requête pour le nombre total de produits
$totalProducts = F_executeRequeteSql("SELECT COUNT(*) as total FROM produit")[0]->total;

// Calcul des limites
$totalPages = ceil($totalProducts / $itemsPerPage);
$offset = ($currentPage - 1) * $itemsPerPage;

// Modification de votre requête principale
$Y_Produits .= " LIMIT $itemsPerPage OFFSET $offset";

// Passez ces variables à la vue
$paginationData = [
    'totalProducts' => $totalProducts,
    'itemsPerPage' => $itemsPerPage,
    'currentPage' => $currentPage,
    'totalPages' => $totalPages
];

// MODIFIER PRODUIT
if (isset($_POST['modifierProduit'])) {
    extract($_POST);

    $Y_updateProduit = "UPDATE `produit` SET `nomProduit` = ?, `prix_vente` = ? WHERE `id_produit` = ?";
    $Y_executeUpdate = F_executeRequeteSql($Y_updateProduit, [$modif_nom_produit, $modif_quantite, $id_produit]);

    header('Location:produitController.php');
    exit();
}

require('../views/produit/produitsView.php');
?>