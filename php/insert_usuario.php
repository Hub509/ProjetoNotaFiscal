<?php
// Configurações de conexão com o banco de dados MySQL
$host = 'localhost';
$dbname = 'sistema_gestao'; // Mesmo banco usado nos outros scripts
$username = 'root';         // Usuário padrão do XAMPP/WAMP
$password = '';             // Senha padrão do XAMPP/WAMP

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe os dados enviados pelos campos 'name' do cadastro_usuario.html
    $nome            = $_POST['nome_usuario'] ?? '';
    $email           = $_POST['email_usuario'] ?? '';
    $cpf             = $_POST['cpf_usuario'] ?? '';
    $senha           = $_POST['senha_usuario'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // Verifica se a senha e a confirmação são iguais
    if ($senha !== $confirmar_senha) {
        echo "<script>
                alert('As senhas não conferem! Tente novamente.');
                window.history.back();
              </script>";
        exit;
    }

    // Criptografa a senha por segurança antes de salvar no banco
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        // Cria a conexão com o banco usando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a query SQL de inserção
        $sql = "INSERT INTO usuarios (nome, email, cpf, senha) 
                VALUES (:nome, :email, :cpf, :senha)";
        
        $stmt = $pdo->prepare($sql);

        // Executa a query vinculando os parâmetros com segurança
        $stmt->execute([
            ':nome'  => $nome,
            ':email' => $email,
            ':cpf'   => $cpf,
            ':senha' => $senha_hash
        ]);

        // Exibe alerta de sucesso e redireciona para a tela de login
        echo "<script>
                alert('Usuário cadastrado com sucesso! Faça login para continuar.');
                window.location.href = 'login.html';
              </script>";

    } catch (PDOException $e) {
        // Em caso de erro na conexão ou inserção (ex: e-mail ou CPF duplicado)
        echo "<script>
                alert('Erro ao cadastrar usuário: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
} else {
    // Caso alguém tente acessar o arquivo insert_usuario.php diretamente pela URL
    header("Location: cadastro_usuario.html");
    exit;
}
?>
