    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h4 class="text-white mb-4">
                        <i class="bi bi-boxes me-2"></i>M&YSTORE
                    </h4>
                    <nav class="nav flex-column">
                        <a class="nav-link <?= $currentPage === 'dashboardController.php' ? 'active' : '' ?>" href="../controller/dashboardController.php">
                            <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                        </a>
                        <a class="nav-link <?= $currentPage === 'produitController.php' ? 'active' : '' ?>" href="../controller/produitController.php">
                            <i class="bi bi-box-seam me-2"></i>Produits
                        </a>
                        <a class="nav-link <?= $currentPage === 'entreeController.php' ? 'active' : '' ?>" href="../controller/entreeController.php">
                            <i class="bi bi-arrow-down-circle me-2"></i>Entrées
                        </a>
                        <a class="nav-link <?= $currentPage === 'sortieController.php' ? 'active' : '' ?>" href="../controller/sortieController.php">
                            <i class="bi bi-arrow-up-circle me-2"></i>Client
                        </a>
                        <a class="nav-link <?= $currentPage === 'caisseController.php' ? 'active' : '' ?>" href="../controller/caisseController.php">
                            <i class="bi bi-credit-card"></i></i> Caisse
                        </a>
                        <a class="nav-link <?= $currentPage === 'rapportController.php' ? 'active' : '' ?>" href="../controller/rapportController.php">
                            <i class="bi bi-graph-up me-2"></i>Fournisseurs
                        </a>
                    </nav>
                </div>
            </div>