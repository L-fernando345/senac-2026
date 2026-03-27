<?php
session_start();
include 'config.php';

if (!isset($_SESSION['carrinho'])) $_SESSION['carrinho'] = [];

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'add':
            $id = $_POST['id'];
            $produto = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produtos WHERE id=$id"));
            if (isset($_SESSION['carrinho'][$id])) {
                $_SESSION['carrinho'][$id]['qtd'] += 1;
            } else {
                $_SESSION['carrinho'][$id] = ['nome' => $produto['nome'], 'preco' => $produto['preco'], 'qtd' => 1, 'imagem' => $produto['imagem']];
            }
            break;
        case 'remove':
            unset($_SESSION['carrinho'][$_GET['id']]);
            break;
        case 'empty':
            $_SESSION['carrinho'] = [];
            break;
    }
    header('Location: carrinho.php');
    exit;
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Carrinho</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
    <header class="bg-danger text-white"><nav class="navbar navbar-lg">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarNav" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
      <ul class="navbar-nav">
        <li class="nav-item">
          <h3><a class="nav-link active" aria-current="page" href="index.php">Produtos</a></h3>
        </li>
        <li class="nav-item">
          <h3><a class="nav-link" href="login.php">Login</a></h3>
        </li>
      </ul>
</div>
</nav>
</header>
    <h2 class="text-white">Carrinho de Compras</h2>
    <?php if (empty($_SESSION['carrinho'])): ?>
        <p class="text-white">Carrinho vazio!</p>
    <?php else: ?>
        <table>
            <tr><th>Imagem</th><th>Produto</th><th>Preço</th><th>Qtde</th><th>Total</th><th>Ações</th></tr>
            <div class="container text-center bg-dark fade-in ">
              <div class="row gap-1">
            <?php foreach ($_SESSION['carrinho'] as $id => $item): 
                $subtotal = $item['preco'] * $item['qtd']; $total += $subtotal;
            ?>
                    <div class=" card col-3">
                    <img class="card-img" src="img/<?php echo $item['imagem']; ?>" width="50"></div>
                    <!-- <div class="col-7"> -->
                    <div class="card col-7">
                    <h5 class="card-title text-center"><?php echo $item['nome']; ?></h5>
                    <p class="card-text">
                    <h4><strong class="">R$ <?php echo $item['preco']; ?></strong></h4>
                    <h5 class="text-center">Encomendado:<?php echo $item['qtd']; ?></h5>
                    <h2 class="">R$ <?php echo number_format($subtotal, 2); ?></h2>
                    <button class="btn btn-danger mb-3" onclick="removerItem(<?php echo $id; ?>)">Remover</button>
            </div>
            <?php endforeach; ?>
            <div class="row justify-content-center fade-in">
            <div class="card col-4 text-center" colspan="4"><strong>Total: R$ <?php echo number_format($total, 2); ?></strong>
            <div colspan="2"><button class="btn btn-danger" onclick="esvaziarCarrinho()">Esvaziar</button>
            </div>
        </table>
    <?php endif; ?>
    <?php if (!empty($_SESSION['carrinho']) && isset($_POST['checkout'])): 
    // Processa pedido
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    
    mysqli_query($conn, "INSERT INTO pedidos (nome_cliente, email, endereco, total) VALUES ('$nome', '$email', '$endereco', $total)");
    $pedido_id = mysqli_insert_id($conn);
    
    foreach ($_SESSION['carrinho'] as $id => $item) {
        mysqli_query($conn, "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unit) VALUES ($pedido_id, $id, {$item['qtd']}, {$item['preco']})");
    }
    
    unset($_SESSION['carrinho']);
    $msg = "Pedido #$pedido_id confirmado! Total: R$ " . number_format($total, 2);
endif;
?>
<div class="container text-center">
<div class="row justify-content-center fade-in">
<div class="card col-7 text-center" colspan="4" >
<form method="POST">
    <h3 class="card-title">Checkout</h3>
    <div class="card body">
    <input class="" type="text" name="nome" placeholder="Nome completo" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <textarea name="endereco" placeholder="Endereço completo" required></textarea><br>
    <button class="btn btn-primary" type="submit" name="checkout">Finalizar Compra (Simulado)</button>
</form>
</div>
<?php if (isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
    <script src="script.js"></script>
</body>
</html>