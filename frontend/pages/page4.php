<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "medical_billing";

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
  die("Échec de la connexion : " . $conn->connect_error);
}

// Requête SQL pour récupérer les données de facture + patient + paiement
$sql = "
SELECT
    f.id_facture,
    f.date_emission,
    f.montant AS total,
    p.nom,
    p.prenom,
    pa.montant_paye,
    pa.montant_reste
FROM facture f
JOIN patient p ON f.id_patient = p.id_patient
LEFT JOIN paiement pa ON f.id_facture = pa.id_facture
ORDER BY f.date_emission DESC
";

$result = $conn->query($sql);
?>