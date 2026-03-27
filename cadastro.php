<?php
session_start();
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$erro = $sucesso = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
    // Verifica email duplicado
    $check = mysqli_query($conn, "SELECT id FROM usuarios WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $erro = 'Email já cadastrado!';
    } else {
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if (mysqli_query($conn, $query)) {
            $sucesso = 'Cadastro realizado! Faça login.';
        } else {
            $erro = 'Erro ao cadastrar. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro - Loja Gamer</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-image: url(img/aaa.webp);
        }
    .form-login {
     color: #ff4500; max-width: 400px; margin: 50px auto; padding: 30px; background: #ffffff; border-radius: 10px; }
        input[type="email"], input[type="password"] { width: 96%; padding: 7px; margin: 10px 0; background: #444; color: #fff; border: 1px solid #666; border-radius: 5px; } .sucesso { color: #44ff44; text-align: center; } 
         input[type="email"], input[type="password"], [type="text"] { width: 96%; padding: 7px; margin: 10px 0; background: #444; color: #fff; border: 1px solid #666; border-radius: 5px; }
         .btn { background: #ff4500; width: 100%; padding: 12px; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
    </style>
</head>
<body>
    <div class="form-login">
        <h2>👤 Criar Conta</h2>
        <?php if ($erro): ?><div class="erro"><?php echo $erro; ?></div><?php endif; ?>
        <?php if ($sucesso): ?><div class="sucesso"><?php echo $sucesso; ?></div><?php endif; ?>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha (mín. 6 chars)" minlength="6" required>
            <button type="submit" class="btn">Cadastrar</button>
        </form>
        <div class="cadastro-link">
            <a href="login.php">Já tem conta? Faça login!</a>
        </div>
        <hr>
        <a href="index.php">← Voltar à Loja</a>
    </div>
</body>
</html>
