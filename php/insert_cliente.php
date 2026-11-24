<?php
// Configurações de conexão com o banco de dados MySQL
$host = 'localhost';
$dbname = 'sistema_gestao'; // Altere para o nome do seu banco de dados
$username = 'root';         // Usuário padrão do XAMPP/WAMP
$password = '';             // Senha padrão do XAMPP/WAMP (geralmente vazia)

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe os dados enviados pelos campos 'name' do cadastro_cliente.html
    $nome      = $_POST['nome_cliente'] ?? '';
    $documento = $_POST['documento_cliente'] ?? '';
    $telefone  = $_POST['telefone_cliente'] ?? '';
    $email     = $_POST['email_cliente'] ?? '';
    $endereco  = $_POST['endereco_cliente'] ?? '';

    try {
        // Cria a conexão com o banco usando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a query SQL de inserção
        $sql = "INSERT INTO clientes (nome, documento, telefone, email, endereco) 
                VALUES (:nome, :documento, :telefone, :email, :endereco)";
        
        $stmt = $pdo->prepare($sql);

        // Executa a query vinculando os parâmetros com segurança
        $stmt->execute([
            ':nome'      => $nome,
            ':documento' => $documento,
            ':telefone'  => $telefone,
            ':email'     => $email,
            ':endereco'  => $endereco
        ]);

        // Exibe alerta de sucesso e redireciona de volta para a tela de cadastro ou home
        echo "<script>
                alert('Cliente cadastrado com sucesso!');
                window.location.href = 'cadastro_cliente.html';
              </script>";

    } catch (PDOException $e) {
        // Em caso de erro na conexão ou inserção
        echo "<script>
                alert('Erro ao cadastrar cliente: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
} else {
    // Caso alguém tente acessar o arquivo insert_cliente.php diretamente pela URL
    header("Location: cadastro_cliente.html");
    exit;
}
?>
