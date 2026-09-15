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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $email = $dados['email'] ?? '';
    $senha = $dados['senha'] ?? '';

    try {
        $db = new DBConnection();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
        $stmt->execute([$email, $senha]);
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$usuario) {
            http_response_code(401);
            echo json_encode(['message' => 'Credenciais inválidas'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['idUsuario'] = $usuario['id'];
        $_SESSION['admin'] = ($usuario['tipo'] === 'admin');

        echo json_encode(['message' => 'Login realizado com sucesso', 'usuario' => $usuario], JSON_UNESCAPED_UNICODE);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}
exit;