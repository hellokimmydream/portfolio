<?php
header('Content-Type: application/json');
$host = "localhost";
$db   = "portfolio_db";
$user = "root";
$pass = "root";

// Connexion
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["error" => "Connexion échouée: " . $conn->connect_error]);
    exit();
}

// Requête pour récupérer les modules
$sql = "SELECT module_id, nom_module, description_module, date_debut_module, date_fin_module, note_finale 
        FROM modules 
        ORDER BY date_debut_module DESC";
$result = $conn->query($sql);

$modules = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $modules[] = $row;
    }
}

echo json_encode($modules);
$conn->close();