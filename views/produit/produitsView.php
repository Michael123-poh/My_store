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
                                <input type="text" class="form-control border-0 bg-light" placeholder="Rechercher un produit...">
                            </div>
                            
                            <div class="dropdown me-3">
                                <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
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

                <!-- Products Content -->
                <div class="container-fluid p-4">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">Gestion des Produits</h2>
                            <p class="text-muted mb-0">Gérez votre inventaire et vos produits</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" name="Y_ajouterProduit">
                                <i class="bi bi-plus-circle me-2"></i>Nouveau Produit
                            </button>
                        </div>
                    </div>

                    <!-- Categorie nombre Section -->
                    <div class="filter-section">
                        <form method="get" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Catégorie</label>
                                    <select name="Y_categorie" class="form-select">
                                        <option value="">Toutes les catégories</option>
                                        <?php foreach($Y_categories as $cat): ?>
                                        <option value="<?= $cat->id_categorie ?>" 
                                            <?= ($Y_categorieFilter ?? '') == $cat->id_categorie ? 'selected' : '' ?>>
                                            <?= $cat->nomCategorie ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="bi bi-funnel"></i> Appliquer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- View Controls -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <?php 
                                foreach($Y_nombreProduit as $nombreProduit) {
                                    $totalProduit = $nombreProduit->Total;
                                
                            ?>
                            <span class="text-muted"><?= $totalProduit;?> produits trouvés</span>
                            <?php } ?>
                            <form method="get" class="mb-0">
                                <select name="Y_sort" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                    <option value="name_asc" <?= ($Y_sort ?? '') == 'name_asc' ? 'selected' : '' ?>>Trier par: Nom A-Z</option>
                                    <option value="name_desc" <?= ($Y_sort ?? '') == 'name_desc' ? 'selected' : '' ?>>Trier par: Nom Z-A</option>
                                    <option value="price_asc" <?= ($Y_sort ?? '') == 'price_asc' ? 'selected' : '' ?>>Trier par: Prix croissant</option>
                                    <option value="price_desc" <?= ($Y_sort ?? '') == 'price_desc' ? 'selected' : '' ?>>Trier par: Prix décroissant</option>
                                </select>
                                <?php if(isset($Y_categorieFilter)): ?>
                                    <input type="hidden" name="Y_categorie" value="<?= $Y_categorieFilter ?>">
                                <?php endif; ?>
                            </form>
                        </div>
                        <div class="view-toggle">
                            <button class="btn active" data-view="grid">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </button>
                            <button class="btn" data-view="list">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Products Grid View -->
                    <div id="grid-view">
                        <div class="row">
                            <?php foreach($Y_listeProduits as $listeProd){ ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                <div class="card product-card h-100">
                                    <div class="position-relative">
                                        <img src="../views/images/download (1).jpeg" class="card-img-top product-image" alt="Product">
                                        <span class="badge status-badge in-stock position-absolute top-0 end-0 m-2">En Stock</span>
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <button class="btn btn-sm btn-light rounded-circle">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-primary"><?= $listeProd->id_produit ?></span>
                                            <small class="text-muted"><?= $listeProd->nomCategorie ?></small>
                                        </div>
                                        <h6 class="card-title"><?= $listeProd->nomProduit ?></h6>
                                        <p class="card-text text-muted small"><?= $listeProd->descriptions ?></p>
                                        <?php
                                            $qte = (int)$listeProd->quantiteProduit;
                                            $seuil = (int)$listeProd->seuile_minimum;
                                            if ($seuil <= 0) $seuil = 1;

                                            // Nouveau calcul du pourcentage en fonction du seuil
                                            $pourcentage = min(100, round(($qte / $seuil) * 100));

                                            if ($qte >= $seuil * 5) { // 10 * 4 = 40, donc 32 < 40, ça sera warning
                                                $color = 'bg-success';
                                            } elseif ($qte >= $seuil) {
                                                $color = 'bg-warning';
                                            } else {
                                                $color = 'bg-danger';
                                            }
                                        ?>

                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="h5 mb-0 text-primary"><?= $listeProd->prix_vente ?> xaf</span>
                                            <span class="badge <?= $color ?>"><?= $qte ?> unités</span>
                                        </div>
                                        <div class="progress mb-2" style="height: 4px;">
                                            <div class="progress-bar <?= $color ?>" style="width: <?= $pourcentage ?>%;"></div>
                                        </div>
                                        <small class="text-muted">Seuil minimum: <?= $seuil ?> unités</small>
                                    </div>
                                    <form method="post">
                                    <div class="card-footer bg-transparent">
                                        <div class="btn-group w-100">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-outline-warning btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalModifierProduit"
                                                    data-id="<?= $listeProd->id_produit ?>"
                                                    data-nom="<?= htmlspecialchars($listeProd->nomProduit) ?>"
                                                    data-prix="<?= $listeProd->prix_vente ?>"
                                                    onclick="remplirFormulaireProduit(this)">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="submit"  value="<?= $listeProd->id_produit ?>" name="supprimer" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- List View (Hidden by default) -->
                    <div id="list-view" style="display: none;">
                        <div class="card table-container">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">
                                                    <input type="checkbox" class="form-check-input">
                                                </th>
                                                <th>Produit</th>
                                                <th>Code</th>
                                                <th>Catégorie</th>
                                                <th>Prix</th>
                                                <th>Stock</th>
                                                <th>Statut</th>
                                                <th>Fournisseur</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($Y_listeProduits as $listeProd){ ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="../views/images/download (1).jpeg" class="rounded me-3" alt="Product">
                                                        <div>
                                                            <h6 class="mb-0"><?= $listeProd->nomProduit ?></h6>
                                                            <small class="text-muted"><?= $listeProd->descriptions ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><strong><?= $listeProd->id_produit ?></strong></td>
                                                <td><?= $listeProd->nomCategorie ?></td>
                                                <td><?= $listeProd->prix_vente ?> xaf</td>
                                                <td>
                                                    <?php
                                                        $qte = (int)$listeProd->quantiteProduit;
                                                        $seuil = (int)$listeProd->seuile_minimum;
                                                        if ($seuil <= 0) {
                                                            $seuil = 1; // éviter division par zéro
                                                        }
                                                        
                                                        $pourcentage = min(100, round(($qte / $seuil) * 100));
                                                        
                                                        if ($qte >= $seuil * 5) {
                                                            $color = 'bg-success';  // largement suffisant
                                                        } elseif ($qte >= $seuil) {
                                                            $color = 'bg-warning';  // juste au-dessus du seuil
                                                        } else {
                                                            $color = 'bg-danger';   // en dessous du seuil
                                                        }
                                                    ?>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= $pourcentage ?>%;">
                                                            <?= $qte ?> unités
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge status-badge in-stock">En Stock</span></td>
                                                <td><?= $listeProd->nom_fournisseur.'  '.$listeProd->raison_sociale ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-outline-warning btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalModifierProduit"
                                                            data-id="<?= $listeProd->id_produit ?>"
                                                            data-nom="<?= htmlspecialchars($listeProd->nomProduit) ?>"
                                                            data-prix="<?= $listeProd->prix_vente ?>"
                                                            onclick="remplirFormulaireProduit(this)">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <!-- More rows would go here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">Afficher</span>
                            <select class="form-select form-select-sm items-per-page" style="width: auto;">
                                <option value="12" <?= $paginationData['itemsPerPage'] == 12 ? 'selected' : '' ?>>12</option>
                                <option value="24" <?= $paginationData['itemsPerPage'] == 24 ? 'selected' : '' ?>>24</option>
                                <option value="48" <?= $paginationData['itemsPerPage'] == 48 ? 'selected' : '' ?>>48</option>
                                <option value="96" <?= $paginationData['itemsPerPage'] == 96 ? 'selected' : '' ?>>96</option>
                            </select>
                            <span class="text-muted">sur <?= $paginationData['totalProducts'] ?> produits</span>
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item <?= $paginationData['currentPage'] <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $paginationData['currentPage'] - 1 ?>&itemsPerPage=<?= $paginationData['itemsPerPage'] ?><?= isset($Y_categorieFilter) ? '&Y_categorie='.$Y_categorieFilter : '' ?>">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                                
                                <?php 
                                // Afficher jusqu'à 5 pages autour de la page courante
                                $startPage = max(1, $paginationData['currentPage'] - 2);
                                $endPage = min($paginationData['totalPages'], $paginationData['currentPage'] + 2);
                                
                                for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="page-item <?= $i == $paginationData['currentPage'] ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>&itemsPerPage=<?= $paginationData['itemsPerPage'] ?><?= isset($Y_categorieFilter) ? '&Y_categorie='.$Y_categorieFilter : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($paginationData['totalPages'] > $endPage): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $paginationData['totalPages'] ?>&itemsPerPage=<?= $paginationData['itemsPerPage'] ?><?= isset($Y_categorieFilter) ? '&Y_categorie='.$Y_categorieFilter : '' ?>">
                                            <?= $paginationData['totalPages'] ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <li class="page-item <?= $paginationData['currentPage'] >= $paginationData['totalPages'] ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $paginationData['currentPage'] + 1 ?>&itemsPerPage=<?= $paginationData['itemsPerPage'] ?><?= isset($Y_categorieFilter) ? '&Y_categorie='.$Y_categorieFilter : '' ?>">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
    <!-- Modal Nouveau Produit -->
    <div class="modal fade" id="produitModal" tabindex="-1" aria-labelledby="produitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="produitModalLabel">Nouveau Produit</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNouveauProduit" method="post">
                        <div class="row g-3">
                            <!-- Nom du produit -->
                            <div class="col-md-6">
                                <label for="nomProduit" class="form-label">Nom du produit <span class="text-danger">*</span></label>
                                <input type="text" name="nomProduit" class="form-control" id="nomProduit" required>
                            </div>
                            
                            <!-- Prix unitaire -->
                            <div class="col-md-6">
                                <label for="prixUnitaire" class="form-label">Prix unitaire (XAF) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="prixUnitaire" class="form-control" id="prixUnitaire" min="0" step="0.01" required>
                                    <span class="input-group-text">XAF</span>
                                </div>
                            </div>
                            
                            <!-- Quantité -->
                            <div class="col-md-4">
                                <label for="quantite" class="form-label">Quantité initiale <span class="text-danger">*</span></label>
                                <input type="number" name="quantite" class="form-control" id="quantite" min="0" required>
                            </div>
                            
                            <!-- Seuil minimum -->
                            <div class="col-md-4">
                                <label for="seuilMin" class="form-label">Seuil minimum</label>
                                <input type="number" name="seuilMinimum" class="form-control" id="seuilMin" min="0" value="10">
                            </div>
                            
                            <!-- Catégorie -->
                            <div class="col-md-4">
                                <label for="categorie" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                <select class="form-select" name="categorie" id="categorie" required>
                                    <option value="" selected disabled>Sélectionnez une catégorie</option>
                                    <?php foreach($Y_categories as $cat): ?>
                                    <option value="<?= $cat->id_categorie ?>"><?= $cat->nomCategorie ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Fournisseur -->
                            <div class="col-md-6">
                                <label for="fournisseur" class="form-label">Fournisseur</label>
                                <select class="form-select" name="fournisseur" id="fournisseur">
                                    <option value="" selected disabled>Sélectionnez un fournisseur</option>
                                    <?php foreach($Y_fournisseurs as $fourn): ?>
                                    <option value="<?= $fourn->id_fournisseur ?>"><?= $fourn->nom_fournisseur.' '.$fourn->raison_sociale ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Description -->
                            <div class="col-md-6">
                                <label for="description" class="form-label">Description <small class="text-muted">(max 150 caractères)</small></label>
                                <textarea class="form-control" name="description" id="description" maxlength="150" rows="2"></textarea>
                                <div class="form-text text-end"><span id="charCount">0</span>/150</div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="enregistrer" form="formNouveauProduit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Modifier Produit -->
<div class="modal fade" id="modalModifierProduit" tabindex="-1" aria-labelledby="modalModifierProduitLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalModifierProduitLabel">
          <i class="bi bi-pencil me-2"></i>Modifier Produit
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <form method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nomProduitModif" class="form-label">Nom du produit</label>
            <input type="text" name="modif_nom_produit" class="form-control" id="nomProduitModif" required>
            <input type="hidden" name="id_produit" id="idProduitModif">
          </div>
          <div class="mb-3">
            <label for="quantiteModif" class="form-label">prix</label>
            <input type="number" name="modif_quantite" class="form-control" id="quantiteModif" min="0" required>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" name="modifierProduit" class="btn btn-warning btn-sm">
            <i class="bi bi-check-circle me-2"></i>Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la vue grid/list
            document.querySelectorAll('[data-view]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const view = this.dataset.view;
                    
                    // Update active button
                    document.querySelectorAll('[data-view]').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Toggle views
                    document.getElementById('grid-view').style.display = view === 'grid' ? 'block' : 'none';
                    document.getElementById('list-view').style.display = view === 'list' ? 'block' : 'none';
                });
            });
            
            // Gestion du modal nouveau produit
            const btnNouveauProduit = document.querySelector('button[name="Y_ajouterProduit"]');
            if (btnNouveauProduit) {
                const produitModal = new bootstrap.Modal(document.getElementById('produitModal'));
                
                btnNouveauProduit.addEventListener('click', function() {
                    produitModal.show();
                });
            }
            
            // Compteur de caractères pour la description
            const descriptionField = document.getElementById('description');
            if (descriptionField) {
                descriptionField.addEventListener('input', function() {
                    const charCount = this.value.length;
                    document.getElementById('charCount').textContent = charCount;
                });
            }
        });

        // Gestion du changement d'éléments par page
        document.querySelectorAll('.items-per-page').forEach(select => {
            select.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('itemsPerPage', this.value);
                url.searchParams.set('page', 1); // Retour à la première page
                window.location.href = url.toString();
            });
        });

        document.getElementById('newFournisseur').addEventListener('hidden.bs.modal', function () {
            selectedProducts = [];
            renderProductsList();
            updateTotals();
            document.getElementById('productSelector').selectedIndex = 0;
        });

        function remplirFormulaireProduit(button) {
            const nomProduit = button.getAttribute('data-nom');
            const quantite = button.getAttribute('data-prix');

            document.getElementById('nomProduitModif').value = nomProduit;
            document.getElementById('quantiteModif').value = quantite;
            document.getElementById('idProduitModif').value = button.getAttribute('data-id');
        }
    </script>
</body>
</html>