<?php
$pdo = new PDO("mysql:host=localhost;dbname=sistema_gestao;charset=utf8mb4", 'root', '');
$stmt = $pdo->query("SELECT * FROM notas ORDER BY id DESC");
$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Notas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container container-lista">
        <h1>Notas Fiscais Cadastradas</h1>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número</th>
                        <th>Série</th>
                        <th>Data Emissão</th>
                        <th>Cliente</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notas as $n): ?>
                    <tr>
                        <td><?= htmlspecialchars($n['id']) ?></td>
                        <td><?= htmlspecialchars($n['numero_nota']) ?></td>
                        <td><?= htmlspecialchars($n['serie']) ?></td>
                        <td><?= date('d/m/Y', strtotime($n['data_emissao'])) ?></td>
                        <td><?= htmlspecialchars($n['cliente']) ?></td>
                        <td>R$ <?= number_format($n['valor_total'], 2, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="actions-bar">
            <a href="cadastro_nota.html" class="btn">Nova Nota</a>
            <a href="home.html" class="btn btn-secondary">Voltar para Home</a>
        </div>
    </div>
</body>
</html>
