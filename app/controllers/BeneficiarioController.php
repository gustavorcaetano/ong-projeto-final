<?php
use core\database\DBConnection;

header('Content-Type: application/json; charset=utf-8');
$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = new DBConnection();
    $conn = $db->getConn();

    if ($method === 'GET' && strpos($_SERVER['REQUEST_URI'], 'buscar') !== false) {
        $nome = $_GET['nome'] ?? '';
        $stmt = $conn->prepare("SELECT * FROM familias WHERE nome LIKE ? LIMIT 1");
        $stmt->execute(["%$nome%"]);
        $familia = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$familia) {
            http_response_code(404);
            echo json_encode(['message' => 'Cadastro não encontrado'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode($familia, JSON_UNESCAPED_UNICODE);
    } 
    elseif ($method === 'POST' && strpos($_SERVER['REQUEST_URI'], 'solicitacao') !== false) {
        $dados = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        
        $stmt = $conn->prepare("INSERT INTO solicitacoes (nomeFamilia, mensagem, status) VALUES (?, ?, 'Pendente')");
        $stmt->execute([
            $dados['nomeFamilia'] ?? '',
            $dados['mensagem'] ?? ''
        ]);

        echo json_encode(['message' => 'Solicitação enviada com sucesso'], JSON_UNESCAPED_UNICODE);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
exit;