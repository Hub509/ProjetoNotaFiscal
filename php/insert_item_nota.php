<?php
// Configurações de conexão com o banco de dados MySQL
$host = 'localhost';
$dbname = 'sistema_gestao'; // Mesmo banco usado nos outros scripts
$username = 'root';         // Usuário padrão do XAMPP/WAMP
$password = '';             // Senha padrão do XAMPP/WAMP

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe os dados enviados pelos campos 'name' do cadastro_item_nota.html
    $numero_nota    = $_POST['id_nota_item'] ?? '';
    $codigo_produto = $_POST['id_produto_item'] ?? '';
    $quantidade     = $_POST['quantidade_item'] ?? 1;
    $valor_unitario = $_POST['valor_unitario_item'] ?? 0;
    $subtotal       = $_POST['subtotal_item'] ?? 0;

    try {
        // Cria a conexão com o banco usando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a query SQL de inserção
        $sql = "INSERT INTO itens_nota (numero_nota, codigo_produto, quantidade, valor_unitario, subtotal) 
                VALUES (:numero_nota, :codigo_produto, :quantidade, :valor_unitario, :subtotal)";
        
        $stmt = $pdo->prepare($sql);

        // Executa a query vinculando os parâmetros com segurança
        $stmt->execute([
            ':numero_nota'    => $numero_nota,
            ':codigo_produto' => $codigo_produto,
            ':quantidade'     => $quantidade,
            ':valor_unitario' => $valor_unitario,
            ':subtotal'       => $subtotal
        ]);

        // Exibe alerta de sucesso e redireciona de volta para a tela de cadastro de item
        echo "<script>
                alert('Item adicionado à nota com sucesso!');
                window.location.href = 'cadastro_item_nota.html';
              </script>";

    } catch (PDOException $e) {
        // Em caso de erro na conexão ou inserção
        echo "<script>
                alert('Erro ao adicionar item na nota: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
} else {
    // Caso alguém tente acessar o arquivo insert_item_nota.php diretamente pela URL
    header("Location: cadastro_item_nota.html");
    exit;
}
?>
