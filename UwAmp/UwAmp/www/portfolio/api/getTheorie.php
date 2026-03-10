<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$dbname = "portfolio_db";
$user = "root";
$password = "root";

$etudiant_id = 1;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch(PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

// Récupérer matières avec notes et tests
$sql = "
SELECT 
    m.matiere_theorie_id,
    m.nom_matiere,
    t.test_id,
    t.coefficient,
    t.date_test,
    n.note
FROM t_matiere_theorie m
LEFT JOIN t_tests t 
    ON m.matiere_theorie_id = t.matiere_theorie_id
LEFT JOIN t_notes_tests n 
    ON t.test_id = n.test_id AND n.etudiant_id = :etudiant_id
ORDER BY m.nom_matiere, t.date_test
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['etudiant_id' => $etudiant_id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$matieres = [];
foreach ($rows as $row) {
    $id = $row['matiere_theorie_id'];
    if (!isset($matieres[$id])) {
        $matieres[$id] = [
            'matiere_theorie_id' => $id,
            'nom' => $row['nom_matiere'],
            'notes' => [],
            'sujets' => [], // si tu veux ajouter des sujets plus tard
        ];
    }
    if ($row['note'] !== null) {
        $matieres[$id]['notes'][] = $row['note'];
    }
}

echo json_encode(array_values($matieres));