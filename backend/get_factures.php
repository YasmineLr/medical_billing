<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3307;dbname=medical_billing;charset=utf8", "root", "");

    $sql = "SELECT 
                p.id AS patient_id,
                f.id AS facture_id,
                f.date_facture,
                f.total,
                f.montant_paye
            FROM facture f
            JOIN patient p ON f.patient_id = p.id";

    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $reste = $row['total'] - $row['montant_paye'];
        $statut = 'unpaid';
        if ($reste == 0) {
            $statut = 'paid';
        } elseif ($row['montant_paye'] > 0) {
            $statut = 'partial';
        }

        echo "<tr>
                <td>N°{$row['patient_id']}</td>
                <td>N°{$row['facture_id']}</td>
                <td>{$row['date_facture']}</td>
                <td>{$row['total']} MAD</td>
                <td>{$row['montant_paye']} MAD</td>
                <td>{$reste} MAD</td>
                <td>
                  <span class='status {$statut}' data-bs-toggle='tooltip' title='" . ucfirst($statut) . "'></span>
                </td>
                <td><a href='#'>Télécharger</a></td>
              </tr>";
    }

} catch (PDOException $e) {
    echo "<tr><td colspan='8'>Erreur : " . $e->getMessage() . "</td></tr>";
}
?>