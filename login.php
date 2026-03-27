<?php
session_start();
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha'];
    
    $query = "SELECT id, nome, email, senha FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Senha incorreta!';
        }
    } else {
        $erro = 'Email não encontrado!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Login - Loja Gamer</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
body {
    background-image: url('img/aaa.webp');

}
        .form-login { max-width: 400px; margin: 50px auto; padding: 30px; background: #ffff; border-radius: 10px; color: #140707;}
        input[type="email"], input[type="password"] { width: 96%; padding: 7px; margin: 10px 0; background: #ffff; color: #140707; border: 1px solid #666; border-radius: 5px; }
        .btn { background: #ff4500; width: 100%; padding: 12px; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .erro { color: #ff4444; text-align: center; margin: 10px 0; }
        .cadastro-link { text-align: center; margin-top: 20px; color: #ccc; }
    </style>
</head>
<body>
    <div class="form-login">
        <h2>🔐 Entrar na Conta</h2>
        <?php if ($erro): ?><div class="erro"><?php echo $erro; ?></div><?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit" name="login" class="btn">Entrar</button>
        </form>
        <div class="cadastro-link">
            <a href="cadastro.php">Não tem conta? Cadastre-se grátis!</a>
        </div>
        <hr>
        <a href="index.php">← Voltar à Loja</a>
    </div>
</body>
</html>
