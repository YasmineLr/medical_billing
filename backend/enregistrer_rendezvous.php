<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ma_base;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $soignant = $_POST['soignant'] ?? '';
    $service = $_POST['service'] ?? '';

    if (empty($soignant) || empty($service)) {
        throw new Exception('Veuillez sélectionner un soignant et un service.');
    }

    $prixServices = [
        "consultation générale" => 300.00,
        "consultation en ligne" => 250.00,
        "Visite à domicile" => 400.00,
        "Echographie" => 200.00,
        "Electrocardiogramme" => 100.00,
    ];

    if (!isset($prixServices[$service])) {
        throw new Exception('Service invalide.');
    }

    $prix = $prixServices[$service];

    // Enregistrer dans la base de données
    $stmt = $pdo->prepare("INSERT INTO rendez-vous (soignant, service, prix) VALUES (?, ?, ?)");
    $stmt->execute([$soignant, $service, $prix]);

    $idRdv = $pdo->lastInsertId();

    // Stocker les données dans la session pour les réutiliser
    $_SESSION['soignant'] = $soignant;
    $_SESSION['service'] = $service;
    $_SESSION['prix'] = $prix;
    $_SESSION['id_rdv'] = $idRdv;

    // Redirection vers la page de paiement HTML (paiement1.html)
    header("Location: ../../frontend/pages/paiement.html");
    exit;

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>