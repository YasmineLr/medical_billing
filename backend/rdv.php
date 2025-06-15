<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3307;dbname=medical_billing;charset=utf8", "root", "");

    // Requête pour récupérer rendez-vous avec infos patient (adapter selon ta base)
    $sql = "SELECT 
                r.id AS rdv_id,
                r.date_rdv,
                r.heure_rdv,
                p.nom AS nom_patient,
                r.service,
                r.statut
            FROM rendez_vous r
            JOIN patient p ON r.patient_id = p.id
            ORDER BY r.date_rdv, r.heure_rdv";

    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Classe CSS selon statut (exemple)
        $classe_statut = '';
        if ($row['statut'] === 'Terminé') $classe_statut = 'termine';
        elseif ($row['statut'] === 'Confirmé') $classe_statut = 'confirme';
        elseif ($row['statut'] === 'En attente') $classe_statut = 'attente';

        echo "<tr>
                <td>{$row['date_rdv']}</td>
                <td>{$row['heure_rdv']}</td>
                <td>{$row['nom_patient']}</td>
                <td>{$row['service']}</td>
                <td class='{$classe_statut}'>{$row['statut']}</td>
                <td>
                  <a href='modifier_rdv.php?id={$row['rdv_id']}'>Modifier</a> |
                  <a href='supprimer_rdv.php?id={$row['rdv_id']}' onclick='return confirm(\"Confirmer la suppression ?\")'>Supprimer</a>
                </td>
              </tr>";
    }

} catch (PDOException $e) {
    echo "<tr><td colspan='6'>Erreur : " . htmlspecialchars($e->getMessage()) . "</td></tr>";
}
?>