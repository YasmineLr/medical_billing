<?php
session_start();

$host = 'localhost';
$db = 'ma_base';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$email = $_SESSION['email'] ?? null;

if (!$email) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $sexe = $_POST['sexe'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $emailForm = $_POST['email'];

    $sql = "UPDATE utilisateurs SET nom=?, prenom=?, age=?, sexe=?, telephone=?, adresse=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissss", $nom, $prenom, $age, $sexe, $telephone, $adresse, $emailForm);
    if ($stmt->execute()) {
        echo "Profil mis à jour avec succès.";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

$sql = "SELECT nom, prenom, age, sexe, telephone, adresse, email FROM utilisateurs WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "Utilisateur non trouvé";
    exit;
}

$conn->close();
?>

<form method="post" action="">
    Nom: <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" /><br>
    Prénom: <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" /><br>
    Age: <input type="number" name="age" value="<?= htmlspecialchars($user['age']) ?>" /><br>
    Sexe: <input type="text" name="sexe" value="<?= htmlspecialchars($user['sexe']) ?>" /><br>
    Téléphone: <input type="text" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>" /><br>
    Adresse: <input type="text" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?>" /><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly /><br>
    <button type="submit">Mettre à jour</button>
</form>