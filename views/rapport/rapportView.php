<?php
require('../views/template/header.php');
require('../views/template/sidebar.php');
?>

<div class="col-md-9 col-lg-10 p-5" >
    <h2 class="mb-4">Rapports Clients et Fournisseurs</h2>

    <ul class="nav nav-tabs mb-3" id="rapportTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="clients-tab" data-bs-toggle="tab" data-bs-target="#clients" type="button" role="tab">Clients</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="fournisseurs-tab" data-bs-toggle="tab" data-bs-target="#fournisseurs" type="button" role="tab">Fournisseurs</button>
        </li>
    </ul>

    <div class="tab-content" id="rapportTabsContent">
        <!-- Onglet Clients -->
        <div class="tab-pane fade show active" id="clients" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="clientTable">
                        <?php foreach($Y_clients as $client): ?>
                            <tr>
                                <td><?= $client->nomComplet ?></td>
                                <td><?= $client->adresse ?></td>
                                <td><?= $client->telephone_client ?></td>
                                <td>
                                    <a href="../controller/genererRapport.php?type=client&id=<?= $client->idClient ?>" class="btn btn-sm btn-primary" target="_blank">
                                        Voir rapport
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination justify-content-center" id="paginationClients"></ul>
                </nav>
            </div>
        </div>

        <!-- Onglet Fournisseurs -->
        <div class="tab-pane fade" id="fournisseurs" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="fournisseurTable">
                        <?php foreach($Y_fournisseurs as $fourn): ?>
                            <tr>
                                <td><?= $fourn->nom_fournisseur ?></td>
                                <td><?= $fourn->adresse ?></td>
                                <td>
                                    <a href="../controller/genererRapport.php?type=fournisseur&id=<?= $fourn->id_fournisseur ?>" class="btn btn-sm btn-primary" target="_blank">
                                        Voir rapport
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination justify-content-center" id="paginationFournisseurs"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Bundle (inclut Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<!-- Pagination JS -->
<script>
function paginateTable(tableId, paginationId, itemsPerPage = 10) {
    const table = document.getElementById(tableId);
    const pagination = document.getElementById(paginationId);
    const rows = table.querySelectorAll("tr");
    const totalPages = Math.ceil(rows.length / itemsPerPage);

    function showPage(page) {
        rows.forEach((row, index) => {
            row.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? '' : 'none';
        });

        pagination.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.classList.add('page-item');
            if (i === page) li.classList.add('active');
            const a = document.createElement('a');
            a.classList.add('page-link');
            a.href = '#';
            a.textContent = i;
            a.addEventListener('click', (e) => {
                e.preventDefault();
                showPage(i);
            });
            li.appendChild(a);
            pagination.appendChild(li);
        }
    }

    showPage(1);
}

document.addEventListener('DOMContentLoaded', () => {
    paginateTable('clientTable', 'paginationClients', 10);
    paginateTable('fournisseurTable', 'paginationFournisseurs', 10);
});
</script>
