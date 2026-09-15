<?php
use core\database\DBConnection;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Responde imediatamente a requisições prévias do navegador (Preflight OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = new DBConnection();
    $conn = $db->getConn();

    if ($method === 'GET') {
        $familias = $db->query("SELECT * FROM familias");
        echo json_encode($familias, JSON_UNESCAPED_UNICODE);
    } 
    elseif ($method === 'POST') {
        $dados = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $stmt = $conn->prepare("INSERT INTO familias (nome, dependentes, renda, totalEntregas) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $dados['nome'] ?? '',
            $dados['dependentes'] ?? 0,
            $dados['renda'] ?? 0.00,
            $dados['totalEntregas'] ?? 0
        ]);
        echo json_encode(['id' => $conn->lastInsertId(), ...$dados], JSON_UNESCAPED_UNICODE);
    }
    elseif ($method === 'PUT') {
        $urlParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $id = end($urlParts);
        $dados = json_decode(file_get_contents('php://input'), true) ?? $_POST;

        $stmt = $conn->prepare("UPDATE familias SET nome = ?, dependentes = ?, renda = ?, totalEntregas = ? WHERE id = ?");
        $stmt->execute([
            $dados['nome'] ?? '',
            $dados['dependentes'] ?? 0,
            $dados['renda'] ?? 0.00,
            $dados['totalEntregas'] ?? 0,
            $id
        ]);
        echo json_encode(['message' => 'Família atualizada com sucesso'], JSON_UNESCAPED_UNICODE);
    }
    elseif ($method === 'DELETE') {
        $urlParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $id = end($urlParts);

        $stmt = $conn->prepare("DELETE FROM familias WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Família removida com sucesso'], JSON_UNESCAPED_UNICODE);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
exit;