<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPro - Gestion des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .stat-card {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }
        .stat-card.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stat-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card.info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 4px 8px;
        }
        .pending {
            background-color: #ffc107;
            color: #000;
        }
        .shipped {
            background-color: #28a745;
            color: white;
        }
        .preparing {
            background-color: #17a2b8;
            color: white;
        }
        .cancelled {
            background-color: #dc3545;
            color: white;
        }
        .delivered {
            background-color: #6f42c1;
            color: white;
        }
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }
        .quick-exit {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .picking-list {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .priority-high {
            border-left: 4px solid #dc3545;
        }
        .priority-medium {
            border-left: 4px solid #ffc107;
        }
        .priority-low {
            border-left: 4px solid #28a745;
        }
        .barcode-scanner {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }
        .shipping-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 15px;
        }
        .tracking-timeline {
            position: relative;
            padding-left: 30px;
        }
        .tracking-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }
        .tracking-item {
            position: relative;
            margin-bottom: 20px;
        }
        .tracking-item::before {
            content: '';
            position: absolute;
            left: -23px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #28a745;
            border: 2px solid white;
            box-shadow: 0 0 0 2px #28a745;
        }
        .tracking-item.current::before {
            background: #ffc107;
            box-shadow: 0 0 0 2px #ffc107;
        }
        .tracking-item.pending::before {
            background: #dee2e6;
            box-shadow: 0 0 0 2px #dee2e6;
        }
        .order-card {
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }
        .order-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .nav-tabs-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px 12px 0 0;
            padding: 10px;
        }
        .nav-tabs-custom .nav-link {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 8px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        .nav-tabs-custom .nav-link.active {
            background: white;
            color: #667eea;
            font-weight: bold;
        }
        .client-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            border-left: 4px solid #667eea;
        }
        .client-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .client-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }
        .client-status-active {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .client-status-inactive {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .client-status-pending {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .product-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
        }
        .product-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h4 class="text-white mb-4">
                        <i class="bi bi-boxes me-2"></i>M&YSTORE
                    </h4>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="#">
                            <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                        </a>
                        <a class="nav-link active" href="../controller/produitController.php">
                            <i class="bi bi-box-seam me-2"></i>Produits
                        </a>
                        <a class="nav-link" href="../controller/entreeController.php">
                            <i class="bi bi-arrow-down-circle me-2"></i>Entrées
                        </a>
                        <a class="nav-link" href="../controller/sortieController.php">
                            <i class="bi bi-arrow-up-circle me-2"></i>Client
                        </a>
                        <a class="nav-link" href="#">
                            <i class="bi bi-people me-2"></i>Fournisseurs
                        </a>
                        <a class="nav-link" href="#">
                            <i class="bi bi-graph-up me-2"></i>Rapports
                        </a>
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear me-2"></i>Paramètres
                        </a>
                    </nav>
                </div>
            </div>

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
                                            <button class="btn barcode-scanner">
                                                <i class="bi bi-upc-scan me-2"></i>Scanner
                                            </button>
                                            <button class="btn btn-outline-info">
                                                <i class="bi bi-truck me-2"></i>Suivi Livraisons
                                            </button>
                                            <button class="btn btn-outline-primary">
                                                <i class="bi bi-download me-2"></i>Exporter
                                            </button>
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newExitModal">
                                                <i class="bi bi-plus-circle me-2"></i>Nouvelle Sortie
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
                                                            <h2 class="mb-0">32</h2>
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
                                                            <h2 class="mb-0">24</h2>
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
                                                            <h6 class="card-title text-uppercase mb-1">Dette</h6>
                                                            <h2 class="mb-0">8</h2>
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
                                                            <h2 class="mb-0">18,750xaf</h2>
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
                                                    <span class="badge bg-warning">8 commandes</span>
                                                </div>
                                                <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                                                    <div class="picking-list priority-high">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h6 class="mb-1">CMD-2024-045</h6>
                                                                <small class="text-muted">Client: TechCorp SARL</small>
                                                            </div>
                                                            <span class="badge bg-danger">Urgent</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">5 articles • 2,450xaf</small>
                                                            <button class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-play-circle"></i> Préparer
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="picking-list priority-medium">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h6 class="mb-1">CMD-2024-046</h6>
                                                                <small class="text-muted">Client: Digital Solutions</small>
                                                            </div>
                                                            <span class="badge bg-warning">Normal</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">3 articles • 1,200xaf</small>
                                                            <button class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-play-circle"></i> Préparer
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="picking-list priority-low">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h6 class="mb-1">CMD-2024-047</h6>
                                                                <small class="text-muted">Client: StartUp Inc.</small>
                                                            </div>
                                                            <span class="badge bg-success">Standard</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">8 articles • 3,800xaf</small>
                                                            <button class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-play-circle"></i> Préparer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Recent Exits Table -->
                                        <div class="col-lg-8">
                                            <div class="card table-container">
                                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title mb-0">Sorties Récentes</h5>
                                                    <div class="d-flex gap-2">
                                                        <select class="form-select form-select-sm" style="width: auto;">
                                                            <option>Tous les statuts</option>
                                                            <option>En préparation</option>
                                                            <option>Expédié</option>
                                                            <option>Livré</option>
                                                            <option>Annulé</option>
                                                        </select>
                                                        <select class="form-select form-select-sm" style="width: auto;">
                                                            <option>Trier par: Date récente</option>
                                                            <option>Trier par: Client</option>
                                                            <option>Trier par: Valeur</option>
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
                                                                    <th>Client/Destination</th>
                                                                    <th>Articles</th>
                                                                    <th>Quantité</th>
                                                                    <th>Valeur</th>
                                                                    <th>Statut</th>
                                                                    <th>Suivi</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- Vos données PHP ici -->
                                                                <tr>
                                                                    <td><strong>SOR-2024-001</strong></td>
                                                                    <td>15/01/2024 16:30</td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="bi bi-building me-2 text-primary"></i>
                                                                            <span>TechCorp SARL</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>5</td>
                                                                    <td>12</td>
                                                                    <td>2,450xaf</td>
                                                                    <td><span class="badge status-badge shipped">Expédié</span></td>
                                                                    <td>
                                                                        <a href="#" class="text-decoration-none">
                                                                            <i class="bi bi-truck me-1"></i>TRK123456
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group btn-group-sm">
                                                                            <!-- Vous pouvez passer l'ID de la sortie directement dans l'onclick -->
                                                                            <button class="btn btn-outline-primary" title="Voir détails" onclick="showExitDetails('SOR-2024-001')">
                                                                                <i class="bi bi-eye"></i>
                                                                            </button>
                                                                            <button class="btn btn-outline-success" title="Bon de livraison">
                                                                                <i class="bi bi-printer"></i>
                                                                            </button>
                                                                            <button class="btn btn-outline-info" title="Suivi">
                                                                                <i class="bi bi-geo-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <!-- Répétez pour les autres lignes avec vos données PHP -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-white">
                                                    <nav>
                                                        <ul class="pagination pagination-sm mb-0 justify-content-center">
                                                            <li class="page-item disabled">
                                                                <a class="page-link" href="#">Précédent</a>
                                                            </li>
                                                            <li class="page-item active">
                                                                <a class="page-link" href="#">1</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a class="page-link" href="#">2</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a class="page-link" href="#">3</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a class="page-link" href="#">Suivant</a>
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

                                    <!-- Clients Grid - Vous remplirez avec vos données PHP -->
                                    <div class="row">
                                        <!-- Exemple de carte client - à répéter avec vos données -->
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="card client-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="client-avatar client-status-active me-3">
                                                            TC
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">TechCorp SARL</h6>
                                                            <small class="text-muted">Entreprise</small>
                                                        </div>
                                                        <span class="badge bg-success">Actif</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">
                                                            <i class="bi bi-envelope me-1"></i>contact@techcorp.cm
                                                        </small>
                                                        <small class="text-muted d-block">
                                                            <i class="bi bi-telephone me-1"></i>+237 6XX XXX XXX
                                                        </small>
                                                        <small class="text-muted d-block">
                                                            <i class="bi bi-geo-alt me-1"></i>Douala, Cameroun
                                                        </small>
                                                    </div>
                                                    <div class="row text-center mb-3">
                                                        <div class="col-4">
                                                            <small class="text-muted d-block">Commandes</small>
                                                            <strong>12</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block">Total</small>
                                                            <strong>45,200 XAF</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block">Dette</small>
                                                            <strong class="text-warning">2,450 XAF</strong>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-outline-primary btn-sm flex-fill">
                                                            <i class="bi bi-eye me-1"></i>Détails
                                                        </button>
                                                        <button class="btn btn-outline-success btn-sm flex-fill">
                                                            <i class="bi bi-plus me-1"></i>Commande
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exit Details Modal - Structure vide pour vos données -->
    <div class="modal fade" id="exitDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-eye me-2"></i>Détails de la Sortie
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Informations Générales</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>N° Sortie:</strong></td>
                                    <td id="exitNumber">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td id="exitDate">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Client:</strong></td>
                                    <td id="exitClient">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Statut:</strong></td>
                                    <td id="exitStatus">-</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Résumé Financier</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Sous-total:</strong></td>
                                    <td id="exitSubtotal">-</td>
                                </tr>
                                <tr>
                                    <td><strong>TVA (19.25%):</strong></td>
                                    <td id="exitTax">-</td>
                                </tr>
                                <tr>
                                    <td><strong>Total:</strong></td>
                                    <td><strong id="exitTotal">-</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Suivi:</strong></td>
                                    <td id="exitTracking">-</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h6 class="text-muted mb-3">
                        <i class="bi bi-box-seam me-2"></i>Produits de cette sortie
                    </h6>
                    <div id="productsList">
                        <!-- Ici vous ajouterez vos produits avec PHP -->
                        <!-- Exemple de structure pour un produit : -->
                        <!--
                        <div class="product-item">
                            <div class="d-flex align-items-center">
                                <img src="image_produit.jpg" alt="Nom Produit" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Nom du Produit</h6>
                                    <small class="text-muted">Code: PROD-001</small>
                                </div>
                                <div class="text-end">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="badge bg-primary me-2">Qté: 2</span>
                                        <small class="text-muted">× 850.00 XAF</small>
                                    </div>
                                    <strong class="text-primary">1,700.00 XAF</strong>
                                </div>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary">
                        <i class="bi bi-printer me-2"></i>Imprimer Bon
                    </button>
                    <button type="button" class="btn btn-outline-info">
                        <i class="bi bi-truck me-2"></i>Suivi Livraison
                    </button>
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
                                    <!-- Vos options clients PHP ici -->
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
                                                <!-- Vos options produits PHP ici -->
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
                        <strong>Total: <span id="modalTotal">0 XAF</span></strong>
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
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom/Raison Sociale *</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type de Client *</label>
                                <select class="form-select" required>
                                    <option value="">Sélectionner le type</option>
                                    <option>Entreprise</option>
                                    <option>Particulier</option>
                                    <option>Gouvernement</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone *</label>
                                <input type="tel" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Limite de Crédit (XAF)</label>
                                <input type="number" class="form-control" step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Conditions de Paiement</label>
                                <select class="form-select">
                                    <option>Comptant</option>
                                    <option>30 jours</option>
                                    <option>60 jours</option>
                                    <option>90 jours</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="2" placeholder="Informations supplémentaires..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer Client
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fonction simple pour ouvrir le modal - vous gérerez le contenu avec PHP
        function showExitDetails(exitId) {
            // Ici vous pouvez faire un appel AJAX vers votre PHP pour récupérer les détails
            // ou rediriger vers une page de détails
            
            // Pour l'instant, on ouvre juste le modal vide
            const modal = new bootstrap.Modal(document.getElementById('exitDetailsModal'));
            modal.show();
            
            // Vous pouvez ajouter ici votre logique pour charger les données via AJAX
            // Exemple :
            /*
            fetch('get_exit_details.php?id=' + exitId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('exitNumber').textContent = data.number;
                    document.getElementById('exitDate').textContent = data.date;
                    // etc...
                });
            */
        }
    </script>
</body>
</html>