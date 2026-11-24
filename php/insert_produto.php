<?php
// Configurações de conexão com o banco de dados MySQL
$host = 'localhost';
$dbname = 'sistema_gestao'; // Mesmo banco usado em insert_cliente.php
$username = 'root';         // Usuário padrão do XAMPP/WAMP
$password = '';             // Senha padrão do XAMPP/WAMP

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe os dados enviados pelos campos 'name' do cadastro_produto.html
    $codigo    = $_POST['codigo_produto'] ?? '';
    $nome      = $_POST['nome_produto'] ?? '';
    $descricao = $_POST['descricao_produto'] ?? '';
    $preco     = $_POST['preco_produto'] ?? 0;
    $estoque   = $_POST['estoque_produto'] ?? 0;

    try {
        // Cria a conexão com o banco usando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a query SQL de inserção
        $sql = "INSERT INTO produtos (codigo, nome, descricao, preco, estoque) 
                VALUES (:codigo, :nome, :descricao, :preco, :estoque)";
        
        $stmt = $pdo->prepare($sql);

        // Executa a query vinculando os parâmetros com segurança
        $stmt->execute([
            ':codigo'    => $codigo,
            ':nome'      => $nome,
            ':descricao' => $descricao,
            ':preco'     => $preco,
            ':estoque'   => $estoque
        ]);

        // Exibe alerta de sucesso e redireciona de volta para a tela de cadastro
        echo "<script>
                alert('Produto cadastrado com sucesso!');
                window.location.href = 'cadastro_produto.html';
              </script>";

    } catch (PDOException $e) {
        // Em caso de erro na conexão ou inserção
        echo "<script>
                alert('Erro ao cadastrar produto: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
} else {
    // Caso alguém tente acessar o arquivo insert_produto.php diretamente pela URL
    header("Location: cadastro_produto.html");
    exit;
}
?>
