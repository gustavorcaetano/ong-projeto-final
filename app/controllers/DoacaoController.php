<?php
use core\database\DBConnection;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    
    try {
        $db = new DBConnection();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("INSERT INTO doacoes (nome, email, valor, metodo, status) VALUES (?, ?, ?, ?, 'Pendente')");
        $stmt->execute([
            $dados['nome'] ?? 'Anônimo',
            $dados['email'] ?? '',
            $dados['valor'] ?? 0.00,
            $dados['metodo'] ?? 'Pix'
        ]);
        
        echo json_encode(['id' => $conn->lastInsertId(), 'message' => 'Doação registrada com sucesso'], JSON_UNESCAPED_UNICODE);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}
exit;