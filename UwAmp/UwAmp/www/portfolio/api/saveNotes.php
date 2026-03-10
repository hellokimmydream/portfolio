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

if (!$data || !isset($data['matiere_id'])) {
    echo json_encode(['success'=>false,'error'=>'Matière introuvable']);
    exit;
}

$matiere_id = $data['matiere_id'];
$notes = isset($data['notes']) ? $data['notes'] : [];

$etudiant_id = 1;

try {
    // supprimer les anciennes notes
    $stmt = $pdo->prepare("DELETE FROM t_notes_tests WHERE etudiant_id = :etudiant_id AND test_id IN (SELECT test_id FROM t_tests WHERE matiere_theorie_id = :matiere_id)");
    $stmt->execute([
        ':etudiant_id' => $etudiant_id,
        ':matiere_id' => $matiere_id
    ]);

    // add les nouvelles notes
    $stmt_test = $pdo->prepare("INSERT INTO t_tests (matiere_theorie_id, coefficient, date_test) VALUES (:matiere_id, 1, NOW())");
    $stmt_note = $pdo->prepare("INSERT INTO t_notes_tests (test_id, etudiant_id, note) VALUES (:test_id, :etudiant_id, :note)");

    foreach ($notes as $note) {
        $stmt_test->execute([':matiere_id' => $matiere_id]);
        $test_id = $pdo->lastInsertId();
        $stmt_note->execute([
            ':test_id' => $test_id,
            ':etudiant_id' => $etudiant_id,
            ':note' => $note
        ]);
    }

    echo json_encode(['success'=>true]);
} catch(PDOException $e) {
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}