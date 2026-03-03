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

// Exemple de structure : matieres avec notes et sujets
$sql = "SELECT m.nom_matiere, n.note, s.nom_sujet
        FROM matieres m
        LEFT JOIN notes n ON m.matiere_id = n.matiere_id
        LEFT JOIN sujets s ON m.matiere_id = s.matiere_id
        ORDER BY m.nom_matiere";

$result = $conn->query($sql);

$matieres = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $nom = $row['nom_matiere'];
        if (!isset($matieres[$nom])) {
            $matieres[$nom] = [
                "nom" => $nom,
                "notes" => [],
                "sujets" => []
            ];
        }
        if ($row['note'] !== null) $matieres[$nom]["notes"][] = (float)$row['note'];
        if ($row['nom_sujet'] !== null) $matieres[$nom]["sujets"][] = $row['nom_sujet'];
    }
}

echo json_encode(array_values($matieres));
$conn->close();