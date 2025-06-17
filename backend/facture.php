<?php
session_start();

try {
    // Connexion BDD
    $pdo = new PDO('mysql:host=localhost;dbname=ma_base;charset=utf8', 'root', '');

    // Vérifier que l'id_rdv est envoyé en POST
    if (empty($_POST['id_rdv'])) {
        throw new Exception("ID rendez-vous manquant.");
    }
    $idRdv = (int) $_POST['id_rdv'];

    // Récupérer infos rendez-vous
    $stmt = $pdo->prepare("SELECT soignant, service, prix, nom_client, prenom_client FROM rendezvous WHERE id = ?");
    $stmt->execute([$idRdv]);
    $rdv = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$rdv) {
        throw new Exception("Rendez-vous introuvable.");
    }

    // Récupérer infos paiement
    $stmt2 = $pdo->prepare("SELECT type_carte, nom_carte, numero_carte, expiration, date_paiement FROM paiements WHERE id_rendezvous = ? ORDER BY date_paiement DESC LIMIT 1");
    $stmt2->execute([$idRdv]);
    $paiement = $stmt2->fetch(PDO::FETCH_ASSOC);

    if (!$paiement) {
        throw new Exception("Paiement non trouvé pour ce rendez-vous.");
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture Médicale</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
        }

        .invoice-box {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            background-color: white;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #28a745;
        }

        h3 {
            margin-top: 20px;
            color: #333;
        }

        p {
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-style: italic;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <h2>Facture</h2>
        <p>Date d’émission : <strong><?= date('d/m/Y H:i') ?></strong></p>
        <hr>

        <h3>Informations du client</h3>
        <p><strong>Nom :</strong> <?= htmlspecialchars($rdv['nom_client']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($rdv['prenom_client']) ?></p>

        <h3>Détails de la consultation</h3>
        <p><strong>Soignant :</strong> <?= htmlspecialchars($rdv['soignant']) ?></p>
        <p><strong>Service :</strong> <?= htmlspecialchars($rdv['service']) ?></p>
        <p><strong>Montant payé :</strong> <?= number_format($rdv['prix'], 2, ',', ' ') ?> MAD</p>

        <h3>Détails du paiement</h3>
        <p><strong>Type de carte :</strong> <?= htmlspecialchars($paiement['type_carte']) ?></p>
        <p><strong>Nom sur la carte :</strong> <?= htmlspecialchars($paiement['nom_carte']) ?></p>
        <p><strong>Numéro de carte :</strong> <?= htmlspecialchars($paiement['numero_carte']) ?></p>
        <p><strong>Date d'expiration :</strong> <?= htmlspecialchars($paiement['expiration']) ?></p>
        <p><strong>Date du paiement :</strong> <?= date('d/m/Y H:i', strtotime($paiement['date_paiement'])) ?></p>

        <hr>
        <p class="footer">Merci pour votre confiance !</p>
    </div>
</body>

</html>