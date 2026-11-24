<?php
// Configurações de conexão com o banco de dados MySQL
$host = 'localhost';
$dbname = 'sistema_gestao'; // Mesmo banco usado nos outros scripts
$username = 'root';         // Usuário padrão do XAMPP/WAMP
$password = '';             // Senha padrão do XAMPP/WAMP

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe os dados enviados pelos campos 'name' do cadastro_nota.html
    $numero_nota = $_POST['numero_nota'] ?? '';
    $serie_nota  = $_POST['serie_nota'] ?? '';
    $data_emissao = $_POST['data_emissao'] ?? '';
    $cliente     = $_POST['cliente_nota'] ?? '';
    $valor_total = $_POST['valor_total_nota'] ?? 0;

    try {
        // Cria a conexão com o banco usando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a query SQL de inserção
        $sql = "INSERT INTO notas (numero_nota, serie, data_emissao, cliente, valor_total) 
                VALUES (:numero_nota, :serie, :data_emissao, :cliente, :valor_total)";
        
        $stmt = $pdo->prepare($sql);

        // Executa a query vinculando os parâmetros com segurança
        $stmt->execute([
            ':numero_nota'  => $numero_nota,
            ':serie'        => $serie_nota,
            ':data_emissao' => $data_emissao,
            ':cliente'      => $cliente,
            ':valor_total'  => $valor_total
        ]);

        // Exibe alerta de sucesso e redireciona de volta para a tela de cadastro
        echo "<script>
                alert('Nota fiscal cadastrada com sucesso!');
                window.location.href = 'cadastro_nota.html';
              </script>";

    } catch (PDOException $e) {
        // Em caso de erro na conexão ou inserção
        echo "<script>
                alert('Erro ao cadastrar nota: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
} else {
    // Caso alguém tente acessar o arquivo insert_nota.php diretamente pela URL
    header("Location: cadastro_nota.html");
    exit;
}
?>
