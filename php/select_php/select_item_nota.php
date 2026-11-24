<?php
$pdo = new PDO("mysql:host=localhost;dbname=sistema_gestao;charset=utf8mb4", 'root', '');
$stmt = $pdo->query("SELECT * FROM itens_nota ORDER BY id DESC");
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Itens da Nota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container container-lista">
        <h1>Itens das Notas Cadastrados</h1>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nº Nota</th>
                        <th>Cód. Produto</th>
                        <th>Qtd</th>
                        <th>Valor Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $i): ?>
                    <tr>
                        <td><?= htmlspecialchars($i['id']) ?></td>
                        <td><?= htmlspecialchars($i['numero_nota']) ?></td>
                        <td><?= htmlspecialchars($i['codigo_produto']) ?></td>
                        <td><?= htmlspecialchars($i['quantidade']) ?></td>
                        <td>R$ <?= number_format($i['valor_unitario'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($i['subtotal'], 2, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="actions-bar">
            <a href="cadastro_item_nota.html" class="btn">Novo Item</a>
            <a href="home.html" class="btn btn-secondary">Voltar para Home</a>
        </div>
    </div>
</body>
</html>
