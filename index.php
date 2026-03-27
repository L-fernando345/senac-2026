<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="utf-8">
<head>
    <title>NewAge Loja Gamer</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<span class='bg-danger text-white'>Olá, {$_SESSION['user_nome']}! </span>";
    // echo "<a href='logout.php'>Sair</a>";
// } else {
//     echo "<a href='login.php'>Login?Cadastro</a>";
}
?>
</head>
        <body class="bg-dark">
            <header class="bg-danger text-white">
                <h1 class="text-color ">Loja Gamer Pro Max</h1>
                <nav class="navbar navbar-lg">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    

<div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="carrinho.php">Carrinho</a>
        </li>
        <?php if(isset($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link active" href="logout.php" class="btn-sair">Sair</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="login.php">Login</a></li>
        <?php endif; ?>
      </ul>
</div>
</nav>
            </header>
            <br>
            <section id="produtos">
                <div class='container-xxl bg-dark fade-in'>
                <div class='row justify-content-center gap-1'>
                <?php
        include 'config.php';
        $result = mysqli_query($conn, "SELECT * FROM produtos");
        while($row = mysqli_fetch_assoc($result)) {
        echo "
            
            
            <div class='card col-4'>
                    <img class='card-img-top' src='img/{$row['imagem']}'
                    alt='{$row['nome']}'>
                    <h1 class=' card-text text-center '>{$row['nome']}</h1>
                    <h2><strong><p class='card-text text-center'>R$ {$row['preco']}</p></strong></h2>
                    <button class='btn btn-primary mb-4 w-100' onclick='addCarrinho({$row['id']})'>
                    <h2>Adicionar</h2></buttons>
                    </div>";
                }
                ?>
            </section>
            <script src="script.js"></script>
        </body>
    
</html>