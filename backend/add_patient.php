<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

try {
    $pdo = new PDO('mysql:host=localhost;port=3307;dbname=medical_billing;charset=utf8', 'root', '');

    $nom = strtolower(trim($_POST['nom'] ?? ''));
    $prenom = strtolower(trim($_POST['prenom'] ?? ''));
    $age = strtolower(trim($_POST['age'] ?? ''));
    $tel = strtolower(trim($_POST['tel'] ?? ''));
    $adresse = strtolower(trim($_POST['adresse'] ?? ''));
    $email = strtolower(trim($_POST['email'] ?? ''));
    $mot_de_passe = strtolower(trim($_POST['mot_de_passe'] ?? ''));

    if ($nom && $prenom && $age && $tel && $adresse && $email && $mot_de_passe) {

        $stmt = $pdo->prepare("INSERT INTO patient (nom, prenom, age, tel, adresse, email, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([$nom, $prenom, $age, $tel, $adresse, $email, $mot_de_passe]);

        if ($success) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'insertion."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Champs manquants"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur : " . $e->getMessage()]);
}
?>