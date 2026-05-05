<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$dbname = "portfolio_db";
$user = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['nom_module']) || trim($data['nom_module'])=='') {
    echo json_encode(['success'=>false,'error'=>'Nom du module obligatoire']);
    exit;
}

try {
    if (!empty($data['module_id'])) {
        // UPDATE existant
        $stmt = $pdo->prepare("
            UPDATE t_modules SET
                nom_module = :nom_module,
                description_module = :description
            WHERE module_id = :module_id
        ");
        $stmt->execute([
            ':nom_module' => $data['nom_module'],
            ':description' => isset($data['description_module']) ? $data['description_module'] : null,
            ':module_id' => $data['module_id']
        ]);
    } else {
        // INSERT nouveau module
        $stmt = $pdo->prepare("
            INSERT INTO t_modules(nom_module, description_module)
            VALUES(:nom_module, :description)
        ");
        $stmt->execute([
            ':nom_module' => $data['nom_module'],
            ':description' => isset($data['description_module']) ? $data['description_module'] : null,
        ]);
    }

    echo json_encode(['success'=>true]);
} catch(PDOException $e) {
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}