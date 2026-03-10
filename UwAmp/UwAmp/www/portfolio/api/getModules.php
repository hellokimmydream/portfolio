<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$dbname = "portfolio_db";
$user = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch(PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

$sql = "
SELECT 
    m.module_id,
    m.nom_module,
    m.description_module,
    MIN(t.test_id) as date_debut_module,
    MAX(t.test_id) as date_fin_module,
    AVG(n.note) as note_finale
FROM t_modules m
LEFT JOIN t_notes_modules n ON n.test_id = m.module_id
LEFT JOIN t_notes_modules t ON t.test_id = m.module_id
GROUP BY m.module_id
";

$stmt = $pdo->query($sql);

$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($modules);