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
    p.projet_id,
    p.nom_projet,
    p.description,
    p.date_projet_debut,
    p.date_fin_projet,
    m.nom_module,
    r.resultat,
    r.pourcentage_resultat

FROM t_projets p

LEFT JOIN t_modules m 
ON p.module_id = m.module_id

LEFT JOIN t_resultats_projets r 
ON p.projet_id = r.projet_id

ORDER BY p.date_projet_debut DESC
";

$stmt = $pdo->query($sql);

$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($projets);