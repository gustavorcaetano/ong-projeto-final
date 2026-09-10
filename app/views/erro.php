<?php
// app/views/erro.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Erro de Acesso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #0f172a; color: white; height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="text-center">
        <h1 class="text-danger fw-bold display-3">Acesso Negado</h1>
        <p class="text-muted mt-2">Você precisa estar logado como administrador para acessar esta página.</p>
        <a href="home" class="btn btn-primary mt-3">Voltar para a Página Inicial</a>
    </div>
</body>
</html>