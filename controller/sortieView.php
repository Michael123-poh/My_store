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
                                <input type="text" class="form-control border-0 bg-light" placeholder="Rechercher une sortie...">
                            </div>
                            
                            <div class="dropdown me-3">
                                <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        5
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Commande urgente à préparer</a></li>
                                    <li><a class="dropdown-item" href="#">Retard d'expédition</a></li>
                                    <li><a class="dropdown-item" href="#">Stock insuffisant</a></li>
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

                <!-- Content -->
                <div class="container-fluid p-4">
                    <!-- Navigation Tabs -->
                    <div class="card mb-4">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs border-0" id="mainTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="sorties-tab" data-bs-toggle="tab" data-bs-target="#sorties" type="button" role="tab">
                                        <i class="bi bi-arrow-up-circle me-2"></i>Sorties de Stock
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="clients-tab" data-bs-toggle="tab" data-bs-target="#clients" type="button" role="tab">
                                        <i class="bi bi-people me-2"></i>Gestion Clients
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="mainTabsContent">
                            <!-- Sorties Tab -->
                            <div class="tab-pane fade show active" id="sorties" role="tabpanel">
                                <div class="p-4">
                                    <!-- Page Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <h2 class="mb-1">Sorties de Stock</h2>
                                            <p class="text-muted mb-0">Gérez les expéditions et les sorties de marchandises</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSortieModal">
                                                <i class="bi bi-box-arrow-up me-2"></i>Nouvelle Sortie
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
                                                            <h6 class="card-title text-uppercase mb-1">Sorties Aujourd'hui</h6>
                                                            <h2 class="mb-0"><?= $nombre ?></h2>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i class="bi bi-arrow-up-circle fs-1"></i>
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
                                                            <h6 class="card-title text-uppercase mb-1">Total Clients</h6>
                                                            <h2 class="mb-0"><?= $totals ?></h2>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i class="bi bi-person fs-1"></i>
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
                                                            <h6 class="card-title text-uppercase mb-1">Dette aujourd'hui</h6>
                                                            <h2 class="mb-0"><?= number_format($DetteSomme, 0, '', ' ') ?></h2>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i class="bi bi-cash-coin me-2"></i> XAF
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
                                                            <h6 class="card-title text-uppercase mb-1">Versement Total</h6>
                                                            <h2 class="mb-0"><?= number_format($EncaisserSomme, 0, '', ' ') ?></h2>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i class="bi bi-cash-coin me-2"></i> XAF
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Exit Form -->
                                    <div class="quick-exit">
                                        <h5 class="mb-3">
                                            <i class="bi bi-lightning-charge me-2"></i>Sortie Rapide
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select class="form-select border-0">
                                                    <option>Sélectionner client</option>
                                                    <option>TechCorp SARL</option>
                                                    <option>Digital Solutions</option>
                                                    <option>StartUp Inc.</option>
                                                    <option>Office Pro</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-0">
                                                        <i class="bi bi-upc"></i>
                                                    </span>
                                                    <input type="text" class="form-control border-0" placeholder="Code produit">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control border-0" placeholder="Quantité">
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-select border-0">
                                                    <option>Type de sortie</option>
                                                    <option>Vente</option>
                                                    <option>Transfert</option>
                                                    <option>Retour</option>
                                                    <option>Perte/Casse</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-light w-100">
                                                    <i class="bi bi-arrow-up-circle me-2"></i>Sortir
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Main Content Row -->
                                    <div class="row">
                                        <!-- Orders to Prepare -->
                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title mb-0">
                                                        <i class="bi bi-list-check me-2"></i>À Préparer
                                                    </h5>
                                                </div>
                                                <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                                                    <?php foreach($Y_executeHistorique as $historique){
                                                        $type = $historique->status_transaction;
                                                        switch ($type) {
                                                            case "0":
                                                                $logo ='bg-success';
                                                                $logo2 = 'Réception complète';
                                                                $logo3 = 'priority-low';
                                                            break;
                                                            case "1":
                                                                $logo ='bg-danger';
                                                                $logo2 = 'Entrée annulée';
                                                                $logo3 = 'priority-high';
                                                            break;
                                                            case "2":
                                                                $logo ='bg-warning';
                                                                $logo2 = 'En attente';
                                                                $logo3 = 'priority-medium';
                                                            break;
                                                        }      
                                                    ?>
                                                    <div class="picking-list <?= $logo3 ?>">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h6 class="mb-1"><?= $historique->id_transaction ?></h6>
                                                                <small class="text-muted">Client: <?= $historique->nomComplet ?></small>
                                                            </div>
                                                            <span class="badge <?= $logo ?>"><?= $logo2 ?></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <small class="text-muted"><?= $historique->nombre_articles ?> articles • <?= number_format($historique->montant_total, 0, '', ' ') ?> xaf</small>
                                                            <button class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-play-circle"></i> <?= $historique->duree_depuis_transaction ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Recent Exits Table -->
                                        <div class="col-lg-8">
                                            <div class="card table-container">
                                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title mb-0">Sorties Récentes</h5>
                                                    <div class="d-flex gap-2">
                                                        <select class="form-select form-select-sm" id="filter-status" style="width: auto;">
                                                            <option value="">Tous les statuts</option>
                                                            <option value="0">Payé</option>
                                                            <option value="1">Non Payé</option>
                                                            <option value="2">Annulé</option> 
                                                        </select>

                                                        <select class="form-select form-select-sm" id="filter-client" style="width: auto;">
                                                            <option value="">Tous les clients</option>
                                                            <?php foreach($Y_clients as $cli) { ?>
                                                                <option value="<?= $cli->idClient ?>"><?= $cli->nomComplet ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>N° Sortie</th>
                                                                    <th>Date</th>
                                                                    <th>Client</th>
                                                                    <th>Articles</th>
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
                                                                    data-client="<?= $transaction->idClient ?>"
                                                                >
                                                                    <td><strong><?= $transaction->id_transaction ?></strong></td>
                                                                    <td><?= $transaction->date_formatee ?></td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="bi bi-building me-2 text-primary"></i>
                                                                            <span><?= $transaction->nomComplet ?></span>
                                                                        </div>
                                                                    </td>
                                                                    <td><?= $transaction->nombre_articles_distincts ?></td>
                                                                    <td><?= number_format($transaction->montant_total, 0, '', ' ') ?> xaf</td>
                                                                    <td><?= $logo ?></td>
                                                                    <td>
                                                                        <div class="btn-group btn-group-sm">
                                                                            <button 
                                                                                class="btn btn-outline-primary btn-view-exit"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#exitDetailsModal"
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
                                    </div>
                                </div>
                            </div>

                            <!-- Clients Tab -->
                            <div class="tab-pane fade" id="clients" role="tabpanel">
                                <div class="p-4">
                                    <!-- Clients Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <h2 class="mb-1">Gestion des Clients</h2>
                                            <p class="text-muted mb-0">Gérez vos clients et leurs informations</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-primary">
                                                <i class="bi bi-download me-2"></i>Exporter
                                            </button>
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newClientModal">
                                                <i class="bi bi-plus-circle me-2"></i>Nouveau Client
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Search and Filters -->
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Rechercher un client...">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select">
                                                <option>Tous les statuts</option>
                                                <option>Actif</option>
                                                <option>Inactif</option>
                                                <option>En attente</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select">
                                                <option>Tous les types</option>
                                                <option>Entreprise</option>
                                                <option>Particulier</option>
                                                <option>Gouvernement</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Clients Grid -->
                                    <div class="row">
                                        <?php
                                            foreach($Y_executeClients as $client){
                                                $types = $client->Type_client;
                                                $types2 = $client->total_dette;

                                            if ($types2 <= 10000) {
                                                $logo2 = 'text-success';
                                            } elseif ($types2 <= 70000) {
                                                $logo2 =  'text-warning';
                                            } else {
                                                $logo2 =  'text-danger';
                                            }

                                            switch ($type) {
                                                case "0":
                                                    $logo ='Personnel';
                                                break;
                                                case "1":
                                                    $logo ='Entreprise';
                                                break;
                                            } 
                                        ?>
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="card client-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="client-avatar client-status-active me-3">
                                                            <?= getInitialesClient($client->nomComplet) ?>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1"><?= $client->nomComplet ?></h6>
                                                            <small class="text-muted"><?= $logo ?></small>
                                                        </div>
                                                        <span class="badge bg-success">Actif</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">
                                                            <i class="bi bi-envelope me-1"></i>contact@stock.cm
                                                        </small>
                                                        <small class="text-muted d-block">
                                                            <i class="bi bi-telephone me-1"></i>+237 <?= implode(' ', str_split($client->telephone_client, 3)); ?>
                                                        </small>
                                                        <small class="text-muted d-block">
                                                            <i class="bi bi-geo-alt me-1"></i><?= $client->adresse ?>
                                                        </small>
                                                    </div>
                                                    <div class="row text-center mb-3">
                                                        <div class="col-4">
                                                            <small class="text-muted d-block">Commandes</small>
                                                            <strong><?= $client->nombre_commandes ?></strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block">Total</small>
                                                            <strong><?= number_format($client->total_verse, 0, '', ' ') ?> XAF</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block">Dette</small>
                                                            <strong class="<?= $logo2 ?>"><?= number_format($client->total_dette, 0, '', ' ') ?> XAF</strong>
                                                        </div>
                                                    </div>
                                                </div>
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

    
    <!-- Modal Voir Détails Sortie -->
<div class="modal fade" id="exitDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye me-2"></i>Détails de la Sortie
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Informations Générales -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Informations Générales</h6>
                        <table class="table table-sm table-borderless">
                            <tr><td><strong>N° Sortie:</strong></td><td id="exitNumber">-</td></tr>
                            <tr><td><strong>Date:</strong></td><td id="exitDate">-</td></tr>
                            <tr><td><strong>Client:</strong></td><td id="exitClient">-</td></tr>
                            <tr><td><strong>Statut:</strong></td><td id="exitStatus">-</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Résumé Financier</h6>
                        <table class="table table-sm table-borderless">
                            <tr><td><strong>Sous-total:</strong></td><td id="exitSubtotal">-</td></tr>
                            <tr><td><strong>TVA:</strong></td><td id="exitTax">-</td></tr>
                            <tr><td><strong>Total:</strong></td><td><strong id="exitTotal">-</strong></td></tr>
                            <tr><td><strong>Suivi:</strong></td><td id="exitTracking">-</td></tr>
                        </table>
                    </div>
                </div>

                <!-- Liste des produits -->
                <h6 class="text-muted mb-3">
                    <i class="bi bi-box-seam me-2"></i>Produits de cette sortie
                </h6>
                <div id="exitProductsList"></div>

                <!-- Notes -->
                <div class="mt-3">
                    <h6 class="text-muted">Notes</h6>
                    <p id="exitNotes" class="text-muted">-</p>
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

    <!-- New Exit Modal -->
    <div class="modal fade" id="newExitModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-arrow-up-circle me-2"></i>Nouvelle Sortie de Stock
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Client *</label>
                                <select class="form-select" required>
                                    <option value="">Sélectionner le client</option>
                                    <?php
                                        foreach($Y_executeNombreClient2 as $clientelle){
                                    ?>
                                    <option value="<?= $clientelle->idClient ?>" ><?= $clientelle->nomComplet?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type de Sortie *</label>
                                <select class="form-select" required>
                                    <option value="">Sélectionner le type</option>
                                    <option>Vente</option>
                                    <option>Transfert interne</option>
                                    <option>Retour fournisseur</option>
                                    <option>Perte/Casse</option>
                                    <option>Échantillon</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Date de Sortie *</label>
                                <input type="datetime-local" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">N° Commande/Référence</label>
                                <input type="text" class="form-control" placeholder="CMD-2024-001">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Transporteur</label>
                                <select class="form-select">
                                    <option>Sélectionner transporteur</option>
                                    <option>DHL Express</option>
                                    <option>UPS</option>
                                    <option>FedEx</option>
                                    <option>Chronopost</option>
                                    <option>Transport interne</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Priorité</label>
                                <select class="form-select">
                                    <option>Standard</option>
                                    <option>Normal</option>
                                    <option>Urgent</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Instructions spéciales, adresse de livraison..."></textarea>
                        </div>
                        
                        <hr>
                        
                        <h6 class="mb-3">Produits à sortir</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Stock Disponible</th>
                                        <th>Quantité à Sortir</th>
                                        <th>Prix Unitaire</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-select form-select-sm">
                                                <option>Sélectionner produit</option>
                                                <option>Ordinateur Portable HP (45 en stock)</option>
                                                <option>Souris Logitech (8 en stock)</option>
                                                <option>Écran Samsung (23 en stock)</option>
                                            </select>
                                        </td>
                                        <td><span class="badge bg-success">45</span></td>
                                        <td><input type="number" class="form-control form-control-sm" value="2" max="45"></td>
                                        <td><input type="number" class="form-control form-control-sm" step="0.01" value="899.00"></td>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="me-auto">
                        <strong>Total: 1,798xaf</strong>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer Sortie
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Client Modal -->
    <div class="modal fade" id="newClientModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus me-2"></i>Nouveau Client
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom/Raison Sociale *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone *</label>
                                <input type="tel" name="tel" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="adresse" class="form-control" rows="3"></textarea>
                        </div>                      
                     
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="2" placeholder="Informations supplémentaires..."></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="EnregistreClient" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer Client
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- ✅ MODAL NOUVELLE SORTIE DE STOCK -->
<div class="modal fade" id="newSortieModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-box-arrow-up me-2"></i>Nouvelle Sortie de Stock
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="post" onsubmit="prepareJsonProduits()">
          <!-- Infos générales -->
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Client *</label>
              <select name="client" class="form-select form-select-sm" required>
                <option value="">Sélectionner un client</option>
                <?php foreach($Y_clients as $client): ?>
                  <option value="<?= $client->idClient ?>"><?= $client->nomComplet ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Date de sortie *</label>
              <input type="datetime-local" class="form-control form-control-sm" name="date" required>
            </div>
          </div>

          <!-- Sélection Produits -->
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
                    <option value="">Sélectionner un produit...</option>
                    <?php foreach($Y_produitss as $prod): ?>
                      <option value="<?= $prod->id_produit ?>" 
                              data-name="<?= $prod->nomProduit ?>"
                              data-code="<?= $prod->id_produit ?>"
                              data-price="<?= $prod->prix_vente ?>">
                        <?= $prod->nomProduit ?>
                      </option>
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

          <!-- Liste des produits sélectionnés -->
          <div class="card mb-3">
            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
              <h6 class="mb-0">
                <i class="bi bi-box me-2"></i>Produits à livrer
              </h6>
              <span class="badge bg-primary" id="productCount">0 produit(s)</span>
            </div>
            <div class="card-body p-0">
              <div id="selectedProductsList"></div>
            </div>
          </div>

          <input type="hidden" name="produits_json" id="produits_json">

          <div class="modal-footer py-2">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" name="enregistrerSortie" class="btn btn-primary btn-sm">
              <i class="bi bi-check-circle me-2"></i>Enregistrer Sortie
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const boutonsSortie = document.querySelectorAll(".btn-view-exit");

    boutonsSortie.forEach(button => {
        button.addEventListener("click", function () {
            const idTransaction = this.getAttribute("data-id");

            fetch("../controller/sortieController.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "id_transaction=" + encodeURIComponent(idTransaction)
            })
            .then(res => res.json())
            .then(data => {
                // 🔍 DEBUG
                console.log("Détails sortie :", data);

                // ✅ Infos générales
                document.getElementById("exitNumber").textContent = data.infos.id_transaction;
                document.getElementById("exitDate").textContent = data.infos.date_formatee;
                document.getElementById("exitClient").textContent = data.infos.nom_fournisseur; // client = fournisseur ici ?
                
                // Affichage badge de statut
                const statut = parseInt(data.infos.status_transaction);
                let badge = '';
                if (statut === 0) {
                    badge = '<span class="badge bg-success">Payé</span>';
                } else if (statut === 1) {
                    badge = '<span class="badge bg-danger">Non Payé</span>';
                } else if (statut === 2) {
                    badge = '<span class="badge bg-warning">Annulé</span>';
                } else {
                    badge = '<span class="badge bg-secondary">Inconnu</span>';
                }
                document.getElementById("exitStatus").innerHTML = badge;

                // ✅ Financier
                const total = Number(data.infos.montant_total);
                const tva = total * 0.1;
                const ht = total - tva;

                document.getElementById("exitSubtotal").textContent = ht.toLocaleString() + " XAF";
                document.getElementById("exitTax").textContent = tva.toLocaleString() + " XAF";
                document.getElementById("exitTotal").textContent = total.toLocaleString() + " XAF";

                document.getElementById("exitTracking").textContent = "En préparation"; // ou autre

                // ✅ Produits
                const container = document.getElementById("exitProductsList");
                container.innerHTML = "";

                if (data.produits && data.produits.length > 0) {
                    data.produits.forEach(p => {
                        container.innerHTML += `
                            <div class="product-item mb-3 p-3 border rounded">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">${p.nom}</h6>
                                        <small class="text-muted">Code: ${p.code}</small><br>
                                        <small class="text-muted">Note: ${p.note_transaction ?? '-'}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge bg-primary me-2">Qté: ${p.quantite}</span>
                                            <small class="text-muted">× ${Number(p.prix_unitaire).toLocaleString()} XAF</small>
                                        </div>
                                        <strong class="text-primary">${(p.quantite * p.prix_unitaire).toLocaleString()} XAF</strong>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = "<p class='text-muted'>Aucun produit trouvé pour cette sortie.</p>";
                }

            })
            .catch(error => {
                console.error("Erreur lors du chargement des détails sortie :", error);
            });
        });
    });
});
</script>
<script>
let selectedProducts = [];

function addProduct() {
  const selector = document.getElementById('productSelector');
  const option = selector.options[selector.selectedIndex];

  if (!option.value) {
    alert("Sélectionnez un produit valide");
    return;
  }

  if (selectedProducts.find(p => p.id === option.value)) {
    alert("Produit déjà ajouté");
    return;
  }

  const product = {
    id: option.value,
    name: option.dataset.name,
    code: option.dataset.code,
    price: parseInt(option.dataset.price),
    expectedQty: 1,
    receivedQty: 1
  };

  selectedProducts.push(product);
  renderProductsList();
  selector.selectedIndex = 0;
}

function removeProduct(id) {
  selectedProducts = selectedProducts.filter(p => p.id !== id);
  renderProductsList();
}

function updateQty(id, field, val) {
  const prod = selectedProducts.find(p => p.id === id);
  if (prod) {
    prod[field] = parseInt(val) || 0;
  }
}

function renderProductsList() {
  const container = document.getElementById('selectedProductsList');
  const badge = document.getElementById('productCount');

  if (selectedProducts.length === 0) {
    container.innerHTML = '<div class="text-center p-4 text-muted">Aucun produit sélectionné</div>';
    badge.textContent = '0 produit(s)';
    return;
  }

  let html = '';
  selectedProducts.forEach((p, i) => {
    html += `
    <div class="border-bottom p-3">
      <div class="row align-items-center">
        <div class="col-md-4">
          <strong>${p.name}</strong><br>
          <small class="text-muted">Code: ${p.code}</small>
        </div>
        <div class="col-md-2">
          <input type="number" class="form-control form-control-sm" value="${p.expectedQty}" min="1"
            onchange="updateQty('${p.id}', 'expectedQty', this.value)"
            name="products[${p.id}][expected_qty]">
        </div>
        <div class="col-md-2">
          <input type="number" class="form-control form-control-sm" value="${p.receivedQty}" min="1"
            onchange="updateQty('${p.id}', 'received_qty', this.value)"
            name="products[${p.id}][received_qty]">
        </div>
        <div class="col-md-2">
          <input type="number" class="form-control form-control-sm" value="${p.price}" min="0"
            onchange="updateQty('${p.id}', 'price', this.value)"
            name="products[${p.id}][price]">
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-danger btn-sm" type="button" onclick="removeProduct('${p.id}')">
            <i class="bi bi-trash"></i>
          </button>
          <input type="hidden" name="products[${p.id}][id]" value="${p.id}">
          <input type="hidden" name="products[${p.id}][name]" value="${p.name}">
          <input type="hidden" name="products[${p.id}][code]" value="${p.code}">
        </div>
      </div>
    </div>
    `;
  });

  container.innerHTML = html;
  badge.textContent = `${selectedProducts.length} produit(s)`;
}

// Réinitialiser à la fermeture
const sortieModal = document.getElementById('newSortieModal');
sortieModal?.addEventListener('hidden.bs.modal', () => {
  selectedProducts = [];
  renderProductsList();
});

function prepareJsonProduits() {
  document.getElementById('produits_json').value = JSON.stringify(selectedProducts);
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusFilter = document.getElementById('filter-status');
    const clientFilter = document.getElementById('filter-client');
    const rows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const selectedStatus = statusFilter.value;
        const selectedClient = clientFilter.value;

        rows.forEach(row => {
            const rowStatus = row.dataset.status;
            const rowClient = row.dataset.client;

            const matchStatus = !selectedStatus || rowStatus === selectedStatus;
            const matchClient = !selectedClient || rowClient === selectedClient;

            if (matchStatus && matchClient) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    statusFilter.addEventListener('change', filterTable);
    clientFilter.addEventListener('change', filterTable);
});
</script>


</body>
</html>