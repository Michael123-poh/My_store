<?php
require('../views/template/header.php');
require('../views/template/sidebar.php');
?>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-0">
                <!-- Top Navigation -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="d-flex align-items-center ms-auto">
                            <div class="input-group me-3" style="width: 300px;">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" placeholder="Rechercher une entrée...">
                            </div>
                            
                            <div class="dropdown me-3">
                                <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Nouvelle livraison attendue</a></li>
                                    <li><a class="dropdown-item" href="#">Retard de livraison</a></li>
                                    <li><a class="dropdown-item" href="#">Réception partielle</a></li>
                                </ul>
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn btn-light d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                    <img src="https://via.placeholder.com/32x32" class="rounded-circle me-2" alt="Avatar">
                                    <span>Admin</span>
                                    <i class="bi bi-chevron-down ms-2"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Profil</a></li>
                                    <li><a class="dropdown-item" href="#">Paramètres</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Entries Content -->
                <div class="container-fluid p-4">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">Entrées de Stock</h2>
                            <p class="text-muted mb-0">Gérez les réceptions et les entrées de marchandises</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn barcode-scanner">
                                <i class="bi bi-upc-scan me-2"></i>Scanner
                            </button>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newFournisseur">
                                <i class="bi bi-graph-up me-2"></i>Nouveau Fournisseur
                            </button>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newEntryModal">
                                <i class="bi bi-plus-circle me-2"></i>Nouvelle Entrée
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-uppercase mb-1">Entrées Aujourd'hui</h6>
                                            <h2 class="mb-0"><?= $nombre ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-arrow-down-circle fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card stat-card success">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-uppercase mb-1">Paiement jour</h6>
                                            <h2 class="mb-0"><?= number_format($somme, 0, '', ' ') ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-cash-coin me-2"></i>  XAF 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card stat-card warning">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-uppercase mb-1">Dette Jour</h6>
                                            <h2 class="mb-0"><?= number_format($somme2, 0, '', ' ') ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-cash-coin me-2"></i>  XAF 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card stat-card info">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-uppercase mb-1">Nombre Produit</h6>
                                            <h2 class="mb-0"><?= $nombreProduitStockDistinct ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-box-seam me-2"></i> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Entry Form -->
                    <div class="quick-entry">
                        <h5 class="mb-3">
                            <i class="bi bi-lightning-charge me-2"></i>Entrée Rapide
                        </h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0">
                                        <i class="bi bi-upc"></i>
                                    </span>
                                    <input type="text" class="form-control border-0" placeholder="Code produit ou scan">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control border-0" placeholder="Quantité">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select border-0">
                                    <option>Sélectionner fournisseur</option>
                                    <option>HP Inc.</option>
                                    <option>Dell Technologies</option>
                                    <option>Logitech</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control border-0" placeholder="N° Bon livraison">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-light w-100">
                                    <i class="bi bi-plus-circle me-2"></i>Ajouter
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Filters and Controls -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <form method="GET" class="row">
                                            <div class="col-md-6">
                                                <select class="form-select form-select-sm" id="filter-status">
                                                    <option value="">Tous les statuts</option>
                                                    <option value="0">Payé</option>
                                                    <option value="1">Non Payé</option>
                                                    <option value="2">Annulé</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-select form-select-sm" id="filter-fournisseur">
                                                    <option value="">Tous les fournisseurs</option>
                                                    <?php foreach($Y_fournisseurs as $f) { ?>
                                                        <option value="<?= $f->nom_fournisseur ?>"><?= $f->nom_fournisseur ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="entry-summary">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Entrées du Mois</h6>
                                        <h4 class="mb-0"><?= $nombreMois ?></h4>
                                    </div>
                                    <i class="bi bi-graph-up-arrow fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Entries Table -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card table-container">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Entrées Récentes</h5>
                                    <div class="d-flex gap-2">
                                        <select name="sort" class="form-select form-select-sm">
                                            <option value="date_desc">Date récente</option>
                                            <option value="date_asc">Date ancienne</option>
                                            <option value="fournisseur">Fournisseur</option>
                                            <option value="montant">Valeur</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>N° Entrée</th>
                                                    <th>Date</th>
                                                    <th>Fournisseur</th>
                                                    <th>Article</th>
                                                    <th>Valeur</th>
                                                    <th>Statut</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($Y_executeTransaction as $transaction){
                                                        $type = $transaction->status_transaction;

                                                        switch ($type) {
                                                            case "0":
                                                                $logo ='<span class="badge status-badge received">Payé</span>';
                                                            break;
                                                            case "1":
                                                                $logo ='<span class="badge bg-danger">Non Payé</span>';
                                                            break;
                                                            case "2":
                                                                $logo ='<span class="badge bg-warning">Annulé</span>';
                                                            break;
                                                        }  
                                                ?>
                                                <tr 
                                                    data-status="<?= $transaction->status_transaction ?>" 
                                                    data-fournisseur="<?= strtolower($transaction->nom_fournisseur) ?>"
                                                >
                                                    <td><strong><?= $transaction->id_transaction ?></strong></td>
                                                    <td><?= $transaction->date_formatee ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <!-- <img src="../views/images/download (2).jpeg" class="rounded me-2" alt="Supplier" style="width: 100px; height: 100"> -->
                                                            <span><?= $transaction->nom_fournisseur ?></span>
                                                        </div>
                                                    </td>
                                                    <td><?= $transaction->nombre_articles_distincts ?></td>
                                                    <td><?= number_format($transaction->montant_total, 0, '', ' ') ?> xaf</td>
                                                    <td><?= $logo ?></td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <button 
                                                                class="btn btn-outline-primary btn-view-entry"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#entryDetailsModal"
                                                                data-id="<?= $transaction->id_transaction ?>"
                                                                title="Voir détails">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            <?php if($type == '1') {?>
                                                            <form method="post">
                                                                <button class="btn btn-outline-success" name="payer"  value="<?= $transaction->id_transaction ?>" title="payer" >
                                                                    <i class="bi bi-cash-stack"></i>
                                                                </button>
                                                            </form>
                                                            <form method="post">
                                                                <button class="btn btn-outline-danger" name="annuler" value="<?= $transaction->id_transaction ?>" title="Annulé">
                                                                    <i class="bi bi-x-circle"></i>
                                                                </button>
                                                            </form>
                                                            <?php }if($type == '0') {?>                                                       
                                                            <button class="btn btn-outline-success" title="payé">
                                                                <i class="bi bi-check2-circle"></i>
                                                            </button>
                                                            <?php }?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer bg-white">
                                    <nav>
                                        <ul class="pagination pagination-sm mb-0 justify-content-center">
                                            <!-- Bouton précédent -->
                                            <li class="page-item <?= $pageActuelle <= 1 ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?page=<?= max(1, $pageActuelle - 1) ?>">Précédent</a>
                                            </li>

                                            <!-- Liens de page -->
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?= $i == $pageActuelle ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- Bouton suivant -->
                                            <li class="page-item <?= $pageActuelle >= $totalPages ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?page=<?= min($totalPages, $pageActuelle + 1) ?>">Suivant</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Activity -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-clock-history me-2"></i>Activité Récente
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <?php foreach($Y_executeHistorique as $historique){
                                            $type = $historique->status_transaction;
                                            switch ($type) {
                                                case "0":
                                                    $logo ='received';
                                                    $logo2 = 'Réception complète';
                                                    $logo3 = 'bg-success';
                                                break;
                                                case "1":
                                                    $logo ='cancelled';
                                                    $logo2 = 'Entrée annulée';
                                                    $logo3 = 'bg-danger';
                                                break;
                                                case "2":
                                                    $logo ='partial';
                                                    $logo2 = 'En attente';
                                                    $logo3 = 'bg-warning';
                                                break;
                                            }      
                                        ?>
                                        <div class="timeline-item <?= $logo ?>">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1"><?= $logo2 ?></h6>
                                                    <p class="text-muted small mb-1"><?= $historique->id_transaction ?></p>
                                                    <small class="text-muted">Il y a <?= $historique->duree_depuis_transaction.' - '.$historique->nom_fournisseur ?></small>
                                                </div>
                                                <span class="badge <?=$logo3?>"><?= $historique->nombre_articles ?> articles</span>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Entry Modal - Version Optimisée -->
<div class="modal fade" id="newEntryModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Nouvelle Entrée de Stock
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <!-- Informations générales en 2 colonnes -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Fournisseur *</label>
                            <select class="form-select form-select-sm" name="fournisseur" required>
                                <option value="">Sélectionner</option>
                                <?php foreach($Y_fournisseurs as $fourn): ?>
                                    <option value="<?= $fourn->id_fournisseur ?>"><?= $fourn->nom_fournisseur.' '.$fourn->raison_sociale ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date Réception *</label>
                            <input type="datetime-local" class="form-control form-control-sm" name="date" required>
                        </div>
                    </div>

                    <!-- Section Sélection Produit -->
                    <div class="card mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">
                                <i class="bi bi-plus-circle me-2"></i>Ajouter des Produits
                            </h6>
                        </div>
                        <div class="card-body py-2">
                            <div class="row">
                                <div class="col-md-8">
                                    <select class="form-select form-select-sm" id="productSelector">
                                        <option value="">Sélectionner un produit à ajouter...</option>
                                        <?php foreach($Y_produitss as $prod): ?>
                                            <option value="<?= $prod->id_produit ?>" data-name="<?= $prod->nomProduit ?>" data-code="<?= $prod->id_produit ?>" data-price="<?= $prod->prix_Achat ?>"><?= $prod->nomProduit ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary btn-sm w-100" onclick="addProduct()">
                                        <i class="bi bi-plus me-1"></i>Ajouter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liste des Produits Sélectionnés -->
                    <div class="card mb-3">
                        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="bi bi-box-seam me-2"></i>Produits à recevoir
                            </h6>
                            <span class="badge bg-primary" id="productCount">0 produit(s)</span>
                        </div>
                        <div class="card-body p-0">
                            <div id="selectedProductsList">
                                <!-- Message quand aucun produit -->
                                <div class="text-center py-4 text-muted" id="emptyMessage">
                                    <i class="bi bi-box fs-1 mb-2"></i>
                                    <p class="mb-0">Aucun produit sélectionné</p>
                                    <small>Utilisez le sélecteur ci-dessus pour ajouter des produits</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control form-control-sm" rows="2" name="note" placeholder="Commentaires sur la livraison..."></textarea>
                    </div>

                    <!-- Résumé Financier -->
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Sous-total:</small>
                                        <small><strong id="subtotalAmount">0 XAF</strong></small>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <strong class="text-primary" id="totalAmount">0 XAF</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="enregistrer" class="btn btn-primary btn-sm">
                            <i class="bi bi-check-circle me-2"></i>Enregistrer Entrée
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- New Entry Modal Fournisseur - Version Optimisée -->
<div class="modal fade" id="newFournisseur" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Nouveau Fournisseur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom Fournisseur</label>
                            <input type="name" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Telephone</label>
                            <input type="tel" name="telephone" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="enregistrerFournisseur" class="btn btn-primary btn-sm">
                            <i class="bi bi-check-circle me-2"></i>Enregistrer Entrée
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Voir Détails Entrée -->
<div class="modal fade" id="entryDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye me-2"></i>Détails de l'Entrée
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Informations Générales -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Informations Générales</h6>
                        <table class="table table-sm table-borderless">
                            <tr><td><strong>N° Entrée:</strong></td><td id="entryNumber">-</td></tr>
                            <tr><td><strong>Date:</strong></td><td id="entryDate">-</td></tr>
                            <tr><td><strong>Fournisseur:</strong></td><td id="entrySupplier">-</td></tr>
                            
                            <tr><td><strong>Statut:</strong></td><td id="entryStatus">-</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Résumé Financier</h6>
                        <table class="table table-sm table-borderless">
                            <tr><td><strong>Sous-total:</strong></td><td id="entrySubtotal">-</td></tr>
                            <tr><td><strong>Total:</strong></td><td><strong id="entryTotal">-</strong></td></tr>
                            
                        </table>
                    </div>
                </div>

                <!-- Liste des produits -->
                <h6 class="text-muted mb-3">
                    <i class="bi bi-box-seam me-2"></i>Produits de cette entrée
                </h6>
                <div id="entryProductsList"></div>

                <!-- Notes -->
                <div class="mt-3">
                    <h6 class="text-muted">Notes</h6>
                    <p id="entryNotes" class="text-muted">-</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary"><i class="bi bi-printer me-2"></i>Imprimer Bon</button>
                <button type="button" class="btn btn-outline-warning"><i class="bi bi-pencil me-2"></i>Modifier</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifier Entrée -->
<div class="modal fade" id="editEntryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Modifier l'Entrée
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editEntryForm">
                    <input type="hidden" id="editEntryId" name="entryId">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">N° Entrée</label>
                            <input type="text" class="form-control" id="editEntryNumber" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date d'Entrée *</label>
                            <input type="datetime-local" class="form-control" id="editEntryDate" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Fournisseur *</label>
                            <select class="form-select" id="editEntrySupplier" required>
                                <option value="">Sélectionner le fournisseur</option>
                                <!-- Vos options fournisseurs PHP ici -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type d'Entrée *</label>
                            <select class="form-select" id="editEntryType" required>
                                <option value="">Sélectionner le type</option>
                                <option value="achat">Achat</option>
                                <option value="retour_client">Retour Client</option>
                                <option value="transfert">Transfert</option>
                                <option value="ajustement">Ajustement</option>
                                <option value="don">Don</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">N° Facture/Référence</label>
                            <input type="text" class="form-control" id="editEntryReference" placeholder="REF-2024-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Statut</label>
                            <select class="form-select" id="editEntryStatus">
                                <option value="en_attente">En Attente</option>
                                <option value="recu">Reçu</option>
                                <option value="valide">Validé</option>
                                <option value="annule">Annulé</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="editEntryNotes" rows="3" placeholder="Notes sur cette entrée..."></textarea>
                    </div>
                    
                    <hr>
                    
                    <h6 class="mb-3">Produits</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix Unitaire</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="editProductsTable">
                                <!-- Les produits seront chargés ici dynamiquement -->
                                <tr>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option>Sélectionner produit</option>
                                            <!-- Vos options produits PHP ici -->
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control form-control-sm" value="1" min="1"></td>
                                    <td><input type="number" class="form-control form-control-sm" step="0.01" value="0.00"></td>
                                    <td><span class="fw-bold">0.00 XAF</span></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <button type="button" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-plus me-2"></i>Ajouter Produit
                    </button>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Sous-total:</strong></td>
                                    <td class="text-end" id="editSubtotal">0.00 XAF</td>
                                </tr>
                                <tr class="table-primary">
                                    <td><strong>Total:</strong></td>
                                    <td class="text-end"><strong id="editTotalAmount">0.00 XAF</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Enregistrer Modifications
                </button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let selectedProducts = [];
let productCounter = 0;

function addProduct() {
    const selector = document.getElementById('productSelector');
    const selectedOption = selector.options[selector.selectedIndex];
    
    if (!selectedOption.value) {
        alert('Veuillez sélectionner un produit');
        return;
    }
    
    // Vérifier si le produit n'est pas déjà ajouté
    if (selectedProducts.find(p => p.id === selectedOption.value)) {
        alert('Ce produit est déjà dans la liste');
        return;
    }
    
    const product = {
        id: selectedOption.value,
        name: selectedOption.dataset.name,
        code: selectedOption.dataset.code,
        price: parseInt(selectedOption.dataset.price),
        expectedQty: 1,
        receivedQty: 1
    };
    
    selectedProducts.push(product);
    renderProductsList();
    updateTotals();
    
    // Reset selector
    selector.selectedIndex = 0;
}

function removeProduct(productId) {
    selectedProducts = selectedProducts.filter(p => p.id !== productId);
    renderProductsList();
    updateTotals();
}

function updateQuantity(productId, field, value) {
    const product = selectedProducts.find(p => p.id === productId);
    if (product) {
        product[field] = parseInt(value) || 0;
        updateTotals();
    }
}

function updatePrice(productId, value) {
    const product = selectedProducts.find(p => p.id === productId);
    if (product) {
        product.price = parseInt(value) || 0;
        updateTotals();
    }
}

function renderProductsList() {
    const container = document.getElementById('selectedProductsList');
    const emptyMessage = document.getElementById('emptyMessage');
    const productCount = document.getElementById('productCount');
    
    if (selectedProducts.length === 0) {
        container.innerHTML = `
            <div class="text-center py-4 text-muted" id="emptyMessage">
                <i class="bi bi-box fs-1 mb-2"></i>
                <p class="mb-0">Aucun produit sélectionné</p>
                <small>Utilisez le sélecteur ci-dessus pour ajouter des produits</small>
            </div>
        `;
        productCount.textContent = '0 produit(s)';
        return;
    }
    
    let html = '';
    selectedProducts.forEach((product, index) => {
        html += `
            <div class="border-bottom p-3" id="product-${product.id}">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-box"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1 small">${product.name}</h6>
                                <small class="text-muted">Code: ${product.code}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Qté Attendue</label>
                        <input type="number" class="form-control form-control-sm" 
                               value="${product.expectedQty}" min="1"
                               onchange="updateQuantity('${product.id}', 'expectedQty', this.value)"
                               name="products[${product.id}][expected_qty]">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Qté Reçue</label>
                        <input type="number" class="form-control form-control-sm" 
                               value="${product.receivedQty}" min="0"
                               onchange="updateQuantity('${product.id}', 'receivedQty', this.value)"
                               name="products[${product.id}][received_qty]">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Prix Unit.</label>
                        <input type="number" class="form-control form-control-sm" 
                               value="${product.price}" min="0"
                               onchange="updatePrice('${product.id}', this.value)"
                               name="products[${product.id}][price]">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label small">Total</label>
                        <div class="fw-bold small text-success" id="total-${product.id}">
                            ${formatNumber(product.price * product.receivedQty)} XAF
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                onclick="removeProduct('${product.id}')" title="Supprimer">
                            <i class="bi bi-trash"></i>
                        </button>
                        <input type="hidden" name="products[${product.id}][id]" value="${product.id}">
                        <input type="hidden" name="products[${product.id}][name]" value="${product.name}">
                        <input type="hidden" name="products[${product.id}][code]" value="${product.code}">
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    productCount.textContent = `${selectedProducts.length} produit(s)`;
}

function updateTotals() {
    let subtotal = 0;
    
    selectedProducts.forEach(product => {
        const productTotal = product.price * product.receivedQty;
        subtotal += productTotal;
        
        // Mettre à jour le total du produit
        const totalElement = document.getElementById(`total-${product.id}`);
        if (totalElement) {
            totalElement.textContent = formatNumber(productTotal) + ' XAF';
        }
    });
    
    const total = subtotal + tax;
    
    document.getElementById('subtotalAmount').textContent = formatNumber(subtotal) + ' XAF';
    document.getElementById('taxAmount').textContent = formatNumber(tax) + ' XAF';
    document.getElementById('totalAmount').textContent = formatNumber(total) + ' XAF';
}

function formatNumber(num) {
    return new Intl.NumberFormat('fr-FR').format(Math.round(num));
}

// Reset du modal quand il se ferme  
document.getElementById('newEntryModal').addEventListener('hidden.bs.modal', function () {
    selectedProducts = [];
    renderProductsList();
    updateTotals();
    document.getElementById('productSelector').selectedIndex = 0;
});

document.getElementById('newFournisseur').addEventListener('hidden.bs.modal', function () {
    selectedProducts = [];
    renderProductsList();
    updateTotals();
    document.getElementById('productSelector').selectedIndex = 0;
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const boutonsVoir = document.querySelectorAll(".btn-view-entry");

    boutonsVoir.forEach(button => {
        button.addEventListener("click", function () {
            const idTransaction = this.getAttribute("data-id");

            fetch("../controller/entreeController.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "id_transaction=" + encodeURIComponent(idTransaction)
            })
            .then(res => res.json())
            .then(data => {
                console.log("Données reçues :", data);
                let statusHtml = "";

                switch (data.infos.status_transaction) {
                    case 0:
                        statusHtml = '<span class="badge status-badge received">Payé</span>';
                        break;
                    case 1:
                        statusHtml = '<span class="badge bg-danger">Non Payé</span>';
                        break;
                    case 2:
                        statusHtml = '<span class="badge bg-warning">Annulé</span>';
                        break;
                    default:
                        statusHtml = '<span class="badge bg-secondary">Inconnu</span>';
                }

                const container = document.getElementById("entryProductsList");
                container.innerHTML = "";

                // Remplir les infos générales
                document.getElementById("entryNumber").textContent = data.infos.id_transaction;
                document.getElementById("entryDate").textContent = data.infos.date_formatee;
                document.getElementById("entrySupplier").textContent = data.infos.nom_fournisseur;
                document.getElementById("entryStatus").innerHTML = statusHtml;

                document.getElementById("entrySubtotal").textContent = (Number(data.infos.montant_total) * 0.9).toLocaleString() + " XAF"; // exemple 90% HT
                document.getElementById("entryTotal").textContent = Number(data.infos.montant_total).toLocaleString() + " XAF";

                // Produits
                if (data.produits && data.produits.length > 0) {
                    data.produits.forEach(p => {
                        container.innerHTML += `
                            <div class="product-item mb-3 p-3 border rounded">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">${p.nom}</h6>
                                        <small class="text-muted">Code: ${p.code}</small><br>
                                        <small class="text-muted">Note: ${p.note_transaction}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge bg-success me-2">Qté: ${p.quantite}</span>
                                            <small class="text-muted">× ${Number(p.prix_unitaire).toLocaleString()} XAF</small>
                                        </div>
                                        <strong class="text-success">${(p.quantite * p.prix_unitaire).toLocaleString()} XAF</strong>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = "<p class='text-muted'>Aucun produit trouvé pour cette transaction.</p>";
                }
            })
            .catch(err => {
                console.error("Erreur lors de la récupération :", err);
            });
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusFilter = document.getElementById('filter-status');
    const fournisseurFilter = document.getElementById('filter-fournisseur');
    const rows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const selectedStatus = statusFilter.value;
        const selectedFournisseur = fournisseurFilter.value.toLowerCase();

        rows.forEach(row => {
            const rowStatus = row.dataset.status;
            const rowFournisseur = row.dataset.fournisseur;

            const matchStatus = !selectedStatus || rowStatus === selectedStatus;
            const matchFournisseur = !selectedFournisseur || rowFournisseur === selectedFournisseur;

            if (matchStatus && matchFournisseur) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    statusFilter.addEventListener('change', filterTable);
    fournisseurFilter.addEventListener('change', filterTable);
});
</script>


</body>
</html>