<?php
session_start();

$host = 'localhost';
$dbname = 'notafiscal';
$username = 'root';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email_login'] ?? '';
    $senha = $_POST['senha_login'] ?? '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Busca o usuário pelo e-mail
        $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha bate com o hash
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header("Location: home.html");
            exit;
        } else {
            echo "<script>
                    alert('E-mail ou senha inválidos!');
                    window.location.href = 'login.html';
                  </script>";
        }

    } catch (PDOException $e) {
        echo "<script>
                alert('Erro ao conectar ao banco: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
} else {
    header("Location: login.html");
    exit;
}
?>
