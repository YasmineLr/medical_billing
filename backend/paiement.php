<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cardType = $_POST['card_type'];
  $name = $_POST['card_name'];
  $number = $_POST['card_number'];
  $expiry = $_POST['card_expiry'];
  $service = $_POST['service'] ?? '';
  $soignant = $_POST['soignant'] ?? '';

  // Prix des services
  $prixServices = [
    "consultation générale" => 300,
    "consultation en ligne" => 250,
    "Visite à domile" => 400,
    "Echographie" => 200,
    "Electrocardiogramme" => 100,
  ];

  $amount = $prixServices[$service] ?? 0;

  // ✅ Connexion à la base MySQL
  $mysqli = new mysqli("localhost", "root", "", "ma_base");
  if ($mysqli->connect_error) {
    die("Erreur connexion : " . $mysqli->connect_error);
  }

  // ✅ Préparer et exécuter l'insertion SQL
  $stmt = $mysqli->prepare("INSERT INTO paiement (nom, numero, expiration, type_carte, montant, service, soignant) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssiss", $name, $number, $expiry, $cardType, $amount, $service, $soignant);
  $stmt->execute();
  $stmt->close();
  $mysqli->close();

  // ✅ Enregistrement dans un fichier texte (optionnel)
  $filename = strtolower($cardType) . "_payments.txt";
  $line = "Nom: $name | Numéro: $number | Expiration: $expiry | Montant: $amount\n";
  file_put_contents($filename, $line, FILE_APPEND);

  // ✅ Redirection vers facture
  echo '
    <form id="factureForm" action="facture.php" method="post">
      <input type="hidden" name="card_type" value="' . htmlspecialchars($cardType) . '"/>
      <input type="hidden" name="card_name" value="' . htmlspecialchars($name) . '"/>
      <input type="hidden" name="card_number" value="' . htmlspecialchars($number) . '"/>
      <input type="hidden" name="card_expiry" value="' . htmlspecialchars($expiry) . '"/>
      <input type="hidden" name="amount" value="' . htmlspecialchars($amount) . '"/>
      <input type="hidden" name="soignant" value="' . htmlspecialchars($soignant) . '"/>
      <input type="hidden" name="service" value="' . htmlspecialchars($service) . '"/>
    </form>
    <script>document.getElementById("factureForm").submit();</script>
  ';
} else {
  header("Location: page1.html");
  exit;
}
?>