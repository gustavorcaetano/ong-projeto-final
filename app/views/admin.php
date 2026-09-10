<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo - ONG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #0f172a; color: #f8fafc; min-height: 100vh;">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Painel Administrativo</h2>
            <a href="home" class="btn btn-outline-light btn-sm">Voltar ao Início</a>
        </div>
        <div class="card bg-dark border-secondary p-4 rounded-4 shadow">
            <h4 class="mb-3 text-info">Famílias Cadastradas</h4>
            <div id="tabela-familias">
                <p class="text-muted">Carregando dados...</p>
            </div>
        </div>
    </div>
    <script>
        fetch('api/familias')
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById('tabela-familias');
                if (!Array.isArray(data) || data.length === 0) {
                    container.innerHTML = '<p class="text-muted">Nenhuma família encontrada.</p>';
                    return;
                }
                container.innerHTML = `
                    <table class="table table-dark table-striped align-middle">
                        <thead><tr><th>Nome</th><th>Dependentes</th><th>Renda</th><th>Entregas</th></tr></thead>
                        <tbody>
                            ${data.map(f => `<tr><td>${f.nome}</td><td>${f.dependentes}</td><td>R$ ${f.renda}</td><td>${f.totalEntregas}</td></tr>`).join('')}
                        </tbody>
                    </table>`;
            })
            .catch(err => console.error("Erro:", err));
    </script>
</body>
</html>