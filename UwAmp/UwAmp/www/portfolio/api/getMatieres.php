<?php
header('Content-Type: application/json');

// Connexion à la base UWAMP
$host = '127.0.0.1';       // localhost
$db   = 'portfolio_db';    // nom de la base
$user = 'root';             // utilisateur par défaut UWAMP
$pass = '';                 // mot de passe par défaut UWAMP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// Requête pour récupérer les matières et leurs notes
$matieres = $pdo->query("
    SELECT m.nom_module AS nom, n.note, n.sujet
    FROM t_modules m
    LEFT JOIN t_notes n ON n.module_id = m.module_id
    ORDER BY m.module_id, n.note_id
")->fetchAll();

// Réorganisation des données
$result = [];
foreach ($matieres as $m) {
    $nom = $m['nom'];
    if (!isset($result[$nom])) {
        $result[$nom] = [
            'nom' => $nom,
            'notes' => [],
            'sujets' => []
        ];
    }
    if ($m['note']) $result[$nom]['notes'][] = floatval($m['note']);
    if ($m['sujet']) $result[$nom]['sujets'][] = $m['sujet'];
}

// Renvoie JSON
echo json_encode(array_values($result));