<?php
header('Content-Type: application/json');
// évite les problèmes CORS
header("Access-Control-Allow-Origin: *");

// Paramètres de connexion
$host = "localhost";
$db   = "portfolio_db"; 
$user = "root"; 
$pass = "root"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récup tous les projets
    $stmt = $pdo->query("SELECT * FROM t_projets");
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récup les skills associés
    $stmt = $pdo->query("
        SELECT p.projet_id, s.nom_skills
        FROM t_projets p
        LEFT JOIN t_skills s ON s.projet_id = p.projet_id
    ");

    $skills = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['nom_skills']) { // évite les null
            $skills[$row['projet_id']][] = $row['nom_skills'];
        }
    }

    // tout mis dans un seul objet JSON
    $result = [
        "projets" => $projets,
        "skills"  => $skills
    ];

    echo json_encode($result, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>