<?php
require('../views/template/header.php');
require('../views/template/sidebar.php');
?>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-0">
                <!-- Top Navigation -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="d-flex align-items-center ms-auto">
                            <div class="input-group me-3" style="width: 300px;">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" placeholder="Rechercher un produit...">
                            </div>
                            
                            <div class="dropdown me-3">
                                <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Stock faible: Produit A</a></li>
                                    <li><a class="dropdown-item" href="#">Nouvelle commande</a></li>
                                    <li><a class="dropdown-item" href="#">Rupture de stock: Produit B</a></li>
                                </ul>
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn btn-light d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="/placeholder.svg?height=32&width=32" class="rounded-circle me-2" alt="Avatar">
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

                <!-- Cashier Dashboard Content -->
                <div class="container-fluid p-4">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1 fw-bold text-dark">Aperçu des Mouvements de Stock</h2>
                            <p class="text-muted mb-0">Statistiques et historique des entrées/sorties de produits</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary-gradient d-flex align-items-center">
                                <i class="bi bi-arrow-up-circle me-2"></i>Nouvelle Sortie
                            </button>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-4">
                        <div class="col">
                            <div class="card h-100 statistic-card">
                                <div class="card-body">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-graph-up text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title text-uppercase text-muted mb-1">Total Entrées</h6>
                                        <div class="d-flex align-items-baseline">
                                            <span class="value"><?= number_format($sommeSortie, 0, '', ' ') ?>xaf</span>
                                            <span class="unit"></span>
                                        </div>
                                        <p class="description">Montant entree par les vente de produit</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 statistic-card">
                                <div class="card-body">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-graph-down text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title text-uppercase text-muted mb-1">Total Sorties</h6>
                                        <div class="d-flex align-items-baseline">
                                            <span class="value"><?= number_format($sommeEntree, 0, '', ' ') ?>xaf</span>
                                            <span class="unit"></span>
                                        </div>
                                        <p class="description">Montant sortie par l'achat de produit</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 statistic-card">
                                <div class="card-body">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-balance-fill text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title text-uppercase text-muted mb-1">Solde Dette</h6>
                                        <div class="d-flex align-items-baseline">
                                            <span class="value"><?= number_format($sommeDette, 0, '', ' ') ?>xaf</span>
                                            <span class="unit"></span>
                                        </div>
                                        <p class="description">Valeur des Entrees</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 statistic-card">
                                <div class="card-body">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-currency-dollar text-purple"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title text-uppercase text-muted mb-1">Movement Caisse</h6>
                                        <div class="d-flex align-items-baseline">
                                            <span class="value"><?= number_format($sommeEntree1, 0, '', ' ') ?>xaf</span>
                                            <span class="unit"></span>
                                        </div>
                                        <p class="description">Valeur des depence</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions Table -->
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Mouvements Récents</h5>
                                <p class="card-subtitle text-muted">Les dernières transactions d'entrée et de sortie de stock.</p>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                <i class="bi bi-download me-2"></i>Exporter
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Fournisseur/Client</th>
                                            <th>Type</th>
                                            <th class="text-center">Quantité</th>
                                            <th>Valeur (XAF)</th>
                                            <th>Utilisateur</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($Y_executeTransaction3 as $transaction){
                                            $type = $transaction->id_type_transaction;
                                            switch ($type) {
                                                case "TPT00002":
                                                    $logo ='<span class="badge badge-entry">Entrée</span>';
                                                break;
                                                case "TPT00001":
                                                    $logo ='<span class="badge badge-exit">Sortie</span>';
                                                break;
                                            } 
                                        ?>
                                        <tr>
                                            <td><?= $transaction->date_formatee ?></td>
                                            <td class="fw-medium"><?= $transaction->nomComplet ?></td>
                                            <td><?= $logo ?></td>
                                            <td class="text-center"><?= $transaction->nombre_articles_distincts ?></td>
                                            <td class="text-value"><?= number_format($transaction->montant_total, 0, '', ' ') ?> xaf</td>
                                            <td>Admin</td>
                                            <td class="text-center table-actions">
                                                <div class="btn-group">
                                                    <button class="btn btn-outline-primary"><i class="bi bi-eye"></i></button>
                                                    <button class="btn btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
