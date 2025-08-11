<?php
require('../views/template/header.php');
require('../views/template/sidebar.php');
?>

<div class="col-md-9 col-lg-10 p-5">
    <h2 class="mb-4">Tableau de bord complet</h2>

    <!-- Cartes statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-md-2">
            <div class="card stat-card success text-center">
                <div class="card-body">
                    <h6>Produits</h6>
                    <h3><?= $totalProduits ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card warning text-center">
                <div class="card-body">
                    <h6>Alerte stock</h6>
                    <h3><?= count($produitsAlerte) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card info text-center">
                <div class="card-body">
                    <h6>Clients</h6>
                    <h3><?= $totalClients ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card success text-center">
                <div class="card-body">
                    <h6>Fournisseurs</h6>
                    <h3><?= $totalFournisseurs ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card warning text-center">
                <div class="card-body">
                    <h6>Entrées</h6>
                    <h3><?= $totalEntrees ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stat-card info text-center">
                <div class="card-body">
                    <h6>Sorties</h6>
                    <h3><?= $totalSorties ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card table-container">
                <div class="card-body">
                    <h5 class="mb-3">Mouvements de caisse (6 derniers mois)</h5>
                    <canvas id="chartCaisse"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card table-container">
                <div class="card-body">
                    <h5 class="mb-3">Top produits sortis</h5>
                    <canvas id="chartProduits"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits en alerte -->
    <div class="card table-container mb-4">
        <div class="card-body">
            <h5 class="mb-3">Produits en alerte (stock < seuil)</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Quantité</th>
                            <th>Seuil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($produitsAlerte as $prod): ?>
                            <tr>
                                <td><?= $prod->nomProduit ?></td>
                                <td><?= $prod->quantiteProduit ?></td>
                                <td><?= $prod->seuile_minimum ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Historique récent -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card table-container">
                <div class="card-body">
                    <h5>Dernières entrées</h5>
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Fournisseur</th>
                                <th>Date</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recentEntrees as $e): ?>
                            <tr>
                                <td><?= $e->id_transaction ?></td>
                                <td><?= $e->nom_fournisseur ?></td>
                                <td><?= date('d/m/Y', strtotime($e->date_reception)) ?></td>
                                <td><?= number_format($e->montant_total, 0, '', ' ') ?> XAF</td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card table-container">
                <div class="card-body">
                    <h5>Dernières sorties</h5>
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recentSorties as $s): ?>
                            <tr>
                                <td><?= $s->id_transaction ?></td>
                                <td><?= $s->nom_client ?></td>
                                <td><?= date('d/m/Y', strtotime($s->date_reception)) ?></td>
                                <td><?= number_format($s->montant_total, 0, '', ' ') ?> XAF</td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphe de caisse
const ctxCaisse = document.getElementById('chartCaisse').getContext('2d');
new Chart(ctxCaisse, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($caisseMois, 'mois')) ?>.reverse(),
        datasets: [
            {
                label: 'Entrées',
                data: <?= json_encode(array_column($caisseMois, 'sortie')) ?>.reverse(),
                backgroundColor: '#43e97b'
            },
            {
                label: 'Sorties',
                data: <?= json_encode(array_column($caisseMois, 'entree')) ?>.reverse(),
                backgroundColor: '#fa709a'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
        }
    }
});

// Graphe top produits
const ctxProduits = document.getElementById('chartProduits').getContext('2d');
new Chart(ctxProduits, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($topProduits, 'nomProduit')) ?>,
        datasets: [{
            label: 'Quantité sortie',
            data: <?= json_encode(array_column($topProduits, 'quantite_totale')) ?>,
            backgroundColor: '#667eea'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
