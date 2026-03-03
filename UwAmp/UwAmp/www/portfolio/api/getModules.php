<?php
header('Content-Type: application/json');

// Connexion MySQL
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=portfolio_db;charset=utf8', 
        'root',  // user
        ''       // mot de passe
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// Exemple : récupérer les matières
$stmt = $pdo->query("SELECT * FROM t_modules");
$matieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retour JSON
echo json_encode($matieres);