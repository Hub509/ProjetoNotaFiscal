<?php
$pdo = new PDO("mysql:host=localhost;dbname=sistema_gestao;charset=utf8mb4", 'root', '');
$stmt = $pdo->query("SELECT id, nome, email, cpf, data_cadastro FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container container-lista">
        <h1>Usuários Cadastrados</h1>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Data Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['id']) ?></td>
                        <td><?= htmlspecialchars($u['nome']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['cpf']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($u['data_cadastro'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="actions-bar">
            <a href="cadastro_usuario.html" class="btn">Novo Usuário</a>
            <a href="home.html" class="btn btn-secondary">Voltar para Home</a>
        </div>
    </div>
</body>
</html>
