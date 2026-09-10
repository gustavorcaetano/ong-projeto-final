<?php
use core\database\DBConnection;

header('Content-Type: application/json; charset=utf-8');

try {
    $db = new DBConnection();
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        $acoes = $db->query("SELECT * FROM acoes");
        echo json_encode($acoes, JSON_UNESCAPED_UNICODE);
    } 
    elseif ($method === 'POST') {
        $dados = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("INSERT INTO acoes (titulo, descricao, imagem_url, data_acao) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $dados['titulo'] ?? '',
            $dados['descricao'] ?? '',
            $dados['imagem_url'] ?? '',
            $dados['data_acao'] ?? date('Y-m-d')
        ]);
        
        echo json_encode(['id' => $conn->lastInsertId(), ...$dados], JSON_UNESCAPED_UNICODE);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
exit;