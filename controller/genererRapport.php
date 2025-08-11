<?php
ob_start();

require('../models/pdf/fpdf.php');
require('../models/H_databaseConnection.php');
require('../models/H_functionsModels.php');

$H_dbConnect = F_databaseConnection("localhost", "m&ystore", "root", "");

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Paramètres manquants");
}

$type = $_GET['type'];
$id = $_GET['id'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

function getStatutTexte($status)
{
    switch ($status) {
        case 0:
            return ['Payee', [0, 150, 0]];
        case 1:
            return ['Non payee', [220, 0, 0]];
        case 2:
            return ['Annulee', [255, 140, 0]];
        default:
            return ['Inconnu', [100, 100, 100]];
    }
}

function forceToArray($data)
{
    if (is_array($data)) return $data;
    if (is_object($data)) return [$data];
    return [];
}

if ($type === 'client') {
    $client = F_executeRequeteSql("SELECT nomComplet FROM client WHERE idClient = ?", [$id]);
    $nomClient = is_array($client) ? ($client[0]->nomComplet ?? 'Inconnu') : ($client->nomComplet ?? 'Inconnu');

    $resumeClient = F_executeRequeteSql("
        SELECT 
            COUNT(DISTINCT t.id_transaction) AS nombre_commandes,
            COALESCE(SUM(CASE WHEN t.status_transaction = 1 THEN tp.quantite_recue * tp.prix_unitaire ELSE 0 END), 0) AS total_dette,
            COALESCE(SUM(CASE WHEN t.status_transaction = 0 THEN tp.quantite_recue * tp.prix_unitaire ELSE 0 END), 0) AS total_verse
        FROM transaction t
        LEFT JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction
        WHERE t.idClient = ? AND t.id_type_transaction = 'TPT00002'
    ", [$id]);

    $resume = is_array($resumeClient) ? $resumeClient[0] : $resumeClient;

    $pdf->Cell(0, 10, "Rapport du client : " . utf8_decode($nomClient), 0, 1, 'C');
    $pdf->Ln(3);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, "Nombre de commandes : " . ($resume->nombre_commandes ?? 0), 0, 1);
    $pdf->Cell(0, 8, "Total verse : " . number_format($resume->total_verse ?? 0, 0, '', ' ') . " XAF", 0, 1);
    $pdf->Cell(0, 8, "Total dette : " . number_format($resume->total_dette ?? 0, 0, '', ' ') . " XAF", 0, 1);

    $transactions = forceToArray(F_executeRequeteSql("
        SELECT t.id_transaction, DATE_FORMAT(t.date_reception, '%d/%m/%Y') AS date_trx, t.status_transaction
        FROM transaction t
        WHERE t.idClient = ? AND t.id_type_transaction = 'TPT00002'
        ORDER BY t.date_reception DESC
    ", [$id]));

    if (empty($transactions)) {
        $pdf->Ln(10);
        $pdf->Cell(0, 10, "Aucune transaction trouvee pour ce client.", 0, 1);
    } else {
        foreach ($transactions as $trx) {
            if (!is_object($trx)) continue;

            [$statut, $couleur] = getStatutTexte($trx->status_transaction);
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor($couleur[0], $couleur[1], $couleur[2]);
            $pdf->Cell(0, 8, "Transaction : {$trx->id_transaction} | Date : {$trx->date_trx} | Statut : " . $statut, 0, 1);
            $pdf->SetTextColor(0, 0, 0);

            $produits = forceToArray(F_executeRequeteSql("
                SELECT p.nomProduit, tp.quantite_recue, tp.prix_unitaire
                FROM transaction_produit tp
                JOIN produit p ON tp.id_produit = p.id_produit
                WHERE tp.id_transaction = ?
            ", [$trx->id_transaction]));

            $pdf->SetFont('Arial', '', 11);
            $pdf->SetFillColor(230, 230, 230);
            $pdf->Cell(90, 8, 'Produit', 1, 0, 'L', true);
            $pdf->Cell(30, 8, 'Quantite', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'Prix unitaire', 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Total', 1, 1, 'C', true);

            $totalTransaction = 0;
            foreach ($produits as $p) {
                if (!is_object($p)) continue;

                $sousTotal = $p->quantite_recue * $p->prix_unitaire;
                $totalTransaction += $sousTotal;

                $pdf->Cell(90, 8, utf8_decode($p->nomProduit), 1);
                $pdf->Cell(30, 8, $p->quantite_recue, 1, 0, 'C');
                $pdf->Cell(40, 8, number_format($p->prix_unitaire, 0, '', ' ') . " XAF", 1, 0, 'R');
                $pdf->Cell(30, 8, number_format($sousTotal, 0, '', ' ') . " XAF", 1, 1, 'R');
            }

            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(160, 8, "Total Transaction", 1, 0, 'R');
            $pdf->Cell(30, 8, number_format($totalTransaction, 0, '', ' ') . " XAF", 1, 1, 'R');
        }
    }

}  elseif ($type === 'fournisseur') {
    $fourn = F_executeRequeteSql("SELECT nom_fournisseur FROM fournisseur WHERE id_fournisseur = ?", [$id]);
    $nomFournisseur = is_array($fourn) ? ($fourn[0]->nom_fournisseur ?? 'Inconnu') : ($fourn->nom_fournisseur ?? 'Inconnu');

    // Résumé fournisseur comme client (commandes, dette, versement)
    $resumeFournisseur = F_executeRequeteSql("
        SELECT 
            COUNT(DISTINCT t.id_transaction) AS nombre_commandes,
            COALESCE(SUM(CASE WHEN t.status_transaction = 0 THEN tp.quantite_recue * tp.prix_unitaire ELSE 0 END), 0) AS total_verse,
            COALESCE(SUM(CASE WHEN t.status_transaction = 1 THEN tp.quantite_recue * tp.prix_unitaire ELSE 0 END), 0) AS total_dette
        FROM transaction t
        LEFT JOIN transaction_produit tp ON t.id_transaction = tp.id_transaction
        WHERE t.id_fournisseur = ? AND t.id_type_transaction = 'TPT00001'
    ", [$id]);

    $resume = is_array($resumeFournisseur) ? $resumeFournisseur[0] : $resumeFournisseur;

    $pdf->Cell(0, 10, "Rapport du fournisseur : " . utf8_decode($nomFournisseur), 0, 1, 'C');
    $pdf->Ln(3);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, "Nombre de livraisons : " . ($resume->nombre_commandes ?? 0), 0, 1);
    $pdf->Cell(0, 8, "Total versé : " . number_format($resume->total_verse ?? 0, 0, '', ' ') . " XAF", 0, 1);
    $pdf->Cell(0, 8, "Total dette : " . number_format($resume->total_dette ?? 0, 0, '', ' ') . " XAF", 0, 1);

    $transactions = forceToArray(F_executeRequeteSql("
        SELECT t.id_transaction, DATE_FORMAT(t.date_reception, '%d/%m/%Y') AS date_trx, t.status_transaction
        FROM transaction t
        WHERE t.id_fournisseur = ? AND t.id_type_transaction = 'TPT00001'
        ORDER BY t.date_reception DESC
    ", [$id]));

    if (empty($transactions)) {
        $pdf->Ln(10);
        $pdf->Cell(0, 10, "Aucune transaction trouvée pour ce fournisseur.", 0, 1);
    } else {
        foreach ($transactions as $trx) {
            if (!is_object($trx)) continue;

            [$statut, $couleur] = getStatutTexte($trx->status_transaction);
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor($couleur[0], $couleur[1], $couleur[2]);
            $pdf->Cell(0, 8, "Transaction : {$trx->id_transaction} | Date : {$trx->date_trx} | Statut : " . $statut, 0, 1);
            $pdf->SetTextColor(0, 0, 0);

            $produits = forceToArray(F_executeRequeteSql("
                SELECT p.nomProduit, tp.quantite_recue, tp.prix_unitaire
                FROM transaction_produit tp
                JOIN produit p ON tp.id_produit = p.id_produit
                WHERE tp.id_transaction = ?
            ", [$trx->id_transaction]));

            $pdf->SetFont('Arial', '', 11);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->Cell(90, 8, 'Produit', 1, 0, 'L', true);
            $pdf->Cell(30, 8, 'Quantité', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'Prix unitaire', 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Total', 1, 1, 'C', true);

            $totalTransaction = 0;
            foreach ($produits as $p) {
                if (!is_object($p)) continue;

                $sousTotal = $p->quantite_recue * $p->prix_unitaire;
                $totalTransaction += $sousTotal;

                $pdf->Cell(90, 8, utf8_decode($p->nomProduit), 1);
                $pdf->Cell(30, 8, $p->quantite_recue, 1, 0, 'C');
                $pdf->Cell(40, 8, number_format($p->prix_unitaire, 0, '', ' ') . " XAF", 1, 0, 'R');
                $pdf->Cell(30, 8, number_format($sousTotal, 0, '', ' ') . " XAF", 1, 1, 'R');
            }

            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(160, 8, "Total Transaction", 1, 0, 'R');
            $pdf->Cell(30, 8, number_format($totalTransaction, 0, '', ' ') . " XAF", 1, 1, 'R');
        }
    }
} else {
    die("Type inconnu");
}

ob_end_clean();
$pdf->Output();
?>
