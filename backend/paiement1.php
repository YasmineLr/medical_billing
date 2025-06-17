<?php
session_start();

try {
    if (
        empty($_POST['card_type']) ||
        empty($_POST['card_name']) ||
        empty($_POST['card_number']) ||
        empty($_POST['card_expiry']) ||
        empty($_POST['id_rdv']) // <- récupère l'ID du rendez-vous
    ) {
        throw new Exception("Champs de paiement manquants.");
    }

    $idRdv = (int) $_POST['id_rdv'];
    $typeCarte = htmlspecialchars($_POST['card_type']);
    $nomCarte = htmlspecialchars($_POST['card_name']);
    $numeroCarte = htmlspecialchars($_POST['card_number']);
    $expiration = htmlspecialchars($_POST['card_expiry']);

    // Connexion à la base
    $pdo = new PDO('mysql:host=localhost;dbname=ma_base;charset=utf8', 'root', '');

    // Insertion dans la table paiements
    $stmt = $pdo->prepare("INSERT INTO paiement (id_rendezvous, type_carte, nom_carte, numero_carte, expiration) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$idRdv, $typeCarte, $nomCarte, $numeroCarte, $expiration]);

    // Stocker en session (si tu veux)
    $_SESSION['paiement'] = [
        'type_carte' => $typeCarte,
        'nom_carte' => $nomCarte,
        'numero_carte' => $numeroCarte,
        'expiration' => $expiration
    ];

    $_SESSION['paiement_success'] = true;

    // Redirection vers paiement.html
    header("Location: ../frontend/pages/paiement.html");
    exit;

} catch (Exception $e) {
    echo "Erreur de paiement : " . $e->getMessage();
}
?>