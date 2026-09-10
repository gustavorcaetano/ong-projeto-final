<?php
use core\database\DBConnection;

header('Content-Type: application/json; charset=utf-8');
$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = new DBConnection();
    $conn = $db->getConn();

    if ($method === 'GET') {
        $doacoes = $db->query("SELECT * FROM doacoes");
        echo json_encode($doacoes, JSON_UNESCAPED_UNICODE);
    } 
    elseif ($method === 'PUT') {
        $urlParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $id = end($urlParts);
        $dados = json_decode(file_get_contents('php://input'), true) ?? $_POST;

        $stmt = $conn->prepare("UPDATE doacoes SET status = ? WHERE id = ?");
        $stmt->execute([$dados['status'] ?? 'Pendente', $id]);
        echo json_encode(['message' => 'Status da doação atualizado com sucesso'], JSON_UNESCAPED_UNICODE);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
exit;