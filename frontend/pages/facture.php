<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['card_number'])) {

    $cardNumber = $_POST['card_number'];

    // Connexion à la base de données
    $mysqli = new mysqli("localhost", "root", "", "ma_base");

    if ($mysqli->connect_error) {
        die("Erreur de connexion : " . $mysqli->connect_error);
    }

    // Prépare et exécute la requête pour récupérer la dernière facture avec ce numéro de carte
    $stmt = $mysqli->prepare("SELECT * FROM paiement WHERE numero = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $cardNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si on a trouvé une facture
    if ($row = $result->fetch_assoc()) {
        $name = htmlspecialchars($row['nom']);
        $cardType = htmlspecialchars($row['type_carte']);
        $expiry = htmlspecialchars($row['expiration']);
        $amount = htmlspecialchars($row['montant']);
        $service = htmlspecialchars($row['service']);
        $soignant = htmlspecialchars($row['soignant']);
        $date = htmlspecialchars($row['date_paiement']);
    } else {
        echo "Aucune facture trouvée pour ce numéro de carte.";
        exit;
    }

    $stmt->close();
    $mysqli->close();

} else {
    // Si on arrive sur la page sans POST avec le numéro de carte, on redirige
    header("Location: page1.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Facture - Confirmation de Paiement</title>
    <link rel="stylesheet" href="facture.css" />
</head>

<body>
    <div class="facture-container">
        <div class="facture-header">
            <h1>Facture de paiement</h1>
        </div>
        <div class="facture-details">
            <p><strong>Nom du client :</strong> <?= $name ?></p>
            <p><strong>Type de carte :</strong> <?= $cardType ?></p>
            <p><strong>Montant payé :</strong> <?= $amount ?> €</p>
            <!-- ajoute ici les autres infos à afficher -->
        </div>
    </div>
</body>

</html>