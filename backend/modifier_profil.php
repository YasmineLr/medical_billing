<?php
session_start();

$host = 'localhost';
$db = 'ma_base';
$user = 'root';
$pass = '';

try {
    // Connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$email = $_SESSION['email'] ?? null;

if (!$email) {
    header("Location: login.php");
    exit;
}

// ✅ Mise à jour du profil si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $sexe = $_POST['sexe'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $emailForm = $_POST['email'];

    $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, age = ?, sexe = ?, telephone = ?, adresse = ? WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nom, $prenom, $age, $sexe, $telephone, $adresse, $emailForm])) {
        echo "✅ Profil mis à jour avec succès.";
    } else {
        echo "❌ Erreur lors de la mise à jour.";
    }
}

// ✅ Récupération des informations utilisateur
$sql = "SELECT nom, prenom, age, sexe, telephone, adresse, email FROM utilisateurs WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}
?>

<!-- ✅ Formulaire HTML -->
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