<?php
session_start();
header('Content-Type: application/json');

try {
    if (
        empty($_POST['card_type']) ||
        empty($_POST['card_name']) ||
        empty($_POST['card_number']) ||
        empty($_POST['card_expiry'])
    ) {
        throw new Exception("Champs manquants.");
    }

    $typeCarte = htmlspecialchars($_POST['card_type']);
    $nomCarte = htmlspecialchars($_POST['card_name']);
    $numeroCarte = htmlspecialchars($_POST['card_number']);
    $expiration = htmlspecialchars($_POST['card_expiry']);
    $idRdv = isset($_POST['id_rdv']) ? (int) $_POST['id_rdv'] : null;

    $pdo = new PDO('mysql:host=localhost;dbname=ma_base;charset=utf8', 'root', '');

    $stmt = $pdo->prepare("INSERT INTO paiement (id_rendezvous, type_carte, nom_carte, numero_carte, expiration) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$idRdv, $typeCarte, $nomCarte, $numeroCarte, $expiration]);

    $_SESSION['paiement'] = [
        'type_carte' => $typeCarte,
        'nom_carte' => $nomCarte,
        'numero_carte' => $numeroCarte,
        'expiration' => $expiration
    ];

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
