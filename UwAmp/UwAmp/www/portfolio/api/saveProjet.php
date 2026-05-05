<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$dbname = "portfolio_db";
$user = "root";
$password = "root";

$data = json_decode(file_get_contents("php://input"), true);

// DEBUG
file_put_contents('php://stderr', print_r($data, true));

if (!$data || !isset($data['nom_projet']) || trim($data['nom_projet'])=='') {
    echo json_encode(['success'=>false,'error'=>'Nom du projet obligatoire']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['nom_projet']) || trim($data['nom_projet'])=='') {
    echo json_encode(['success'=>false,'error'=>'Nom du projet obligatoire']);
    exit;
}

// verif module_id si nom_module fourni
$module_id = null;
if (!empty($data['nom_module'])) {
    $stmt = $pdo->prepare("SELECT module_id FROM t_modules WHERE nom_module = :nom_module LIMIT 1");
    $stmt->execute([':nom_module'=>$data['nom_module']]);
    $module_id = $stmt->fetchColumn();
}

try {
    if (!empty($data['projet_id'])) {
        // un update du projet existant
        $stmt = $pdo->prepare("
            UPDATE t_projets SET
                nom_projet = :nom_projet,
                description = :description,
                date_projet_debut = :date_debut,
                date_fin_projet = :date_fin,
                module_id = :module_id
            WHERE projet_id = :projet_id
        ");
        $stmt->execute([
            ':nom_projet' => $data['nom_projet'],
            ':description' => isset($data['description']) ? $data['description'] : null,
            ':date_debut' => isset($data['date_projet_debut']) ? $data['date_projet_debut'] : null,
            ':date_fin' => isset($data['date_fin_projet']) ? $data['date_fin_projet'] : null,
            ':module_id' => $module_id,
            ':projet_id' => $data['projet_id']
        ]);

        // resultat
        if (isset($data['resultat'])) {
            $stmt = $pdo->prepare("
                INSERT INTO t_resultats_projets(projet_id,resultat,pourcentage_resultat)
                VALUES(:projet_id,:resultat,NULL)
                ON DUPLICATE KEY UPDATE resultat=:resultat
            ");
            $stmt->execute([
                ':projet_id'=>$data['projet_id'],
                ':resultat'=>$data['resultat']
            ]);
        }
    } else {
        // insert nouveau projet
        $stmt = $pdo->prepare("
            INSERT INTO t_projets(nom_projet,description,date_projet_debut,date_fin_projet,module_id)
            VALUES(:nom_projet,:description,:date_debut,:date_fin,:module_id)
        ");
        $stmt->execute([
            ':nom_projet' => $data['nom_projet'],
            ':description' => isset($data['description']) ? $data['description'] : null,
            ':date_debut' => isset($data['date_projet_debut']) ? $data['date_projet_debut'] : null,
            ':date_fin' => isset($data['date_fin_projet']) ? $data['date_fin_projet'] : null,
            ':module_id' => $module_id
        ]);

        $projet_id = $pdo->lastInsertId();

        if (isset($data['resultat']) && $data['resultat']!='') {
            $stmt = $pdo->prepare("
                INSERT INTO t_resultats_projets(projet_id,resultat,pourcentage_resultat)
                VALUES(:projet_id,:resultat,NULL)
            ");
            $stmt->execute([
                ':projet_id'=>$projet_id,
                ':resultat'=>$data['resultat']
            ]);
        }
    }

    echo json_encode(['success'=>true]);
} catch(PDOException $e) {
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}