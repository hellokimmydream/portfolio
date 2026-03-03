<?php
header('Content-Type: application/json');
$host = "localhost";
$db   = "portfolio_db";
$user = "root";
$pass = "root";

// Connexion à la base de données
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["error" => "Connexion échouée: " . $conn->connect_error]);
    exit();
}

// Requête pour récupérer les projets
$sql = "SELECT projet_id, nom_projet, description, date_debut, date_fin, technologies FROM projets ORDER BY date_debut DESC";
$result = $conn->query($sql);

$projets = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $projets[] = $row;
    }
}

echo json_encode($projets);
$conn->close();