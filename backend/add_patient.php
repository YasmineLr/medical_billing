<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

try {
    $pdo = new PDO('mysql:host=localhost;port=3307;dbname=medical_billing;charset=utf8', 'root', '');
    $role = strtolower(trim($_POST['role'] ?? 'patient'));

    $nom = strtolower(trim($_POST['nom'] ?? ''));
    $prenom = strtolower(trim($_POST['prenom'] ?? ''));
    $age = strtolower(trim($_POST['age'] ?? ''));
    $tel = strtolower(trim($_POST['tel'] ?? ''));
    $adresse = strtolower(trim($_POST['adresse'] ?? ''));
    $email = strtolower(trim($_POST['email'] ?? ''));
    $mot_de_passe = strtolower(trim($_POST['mot_de_passe'] ?? ''));
    $langues = strtolower(trim($_POST['langues'] ?? ''));
    $competences = strtolower(trim($_POST['competences'] ?? ''));

    if ($nom && $prenom && $age && $tel && $adresse && $email && $mot_de_passe) {

        if ($role === 'medecin') {
            $stmt = $pdo->prepare("INSERT INTO medecins (nom, prenom, age, tel, adresse, email, mot_de_passe, langues, competences) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $success = $stmt->execute([$nom, $prenom, $age, $tel, $adresse, $email, $mot_de_passe, $langues, $competences]);

        } else {
            $stmt = $pdo->prepare("INSERT INTO patients (nom, prenom, age, tel, adresse, email, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $success = $stmt->execute([$nom, $prenom, $age, $tel, $adresse, $email, $mot_de_passe]);
        }

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
