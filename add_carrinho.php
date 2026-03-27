<?php
session_start();
include 'config.php';
$id = $_POST['id'];
header('Content-Type: application/json');
if (isset($_SESSION['carrinho'][$id])) {
    $_SESSION['carrinho'][$id]['qtd'] += 1;
} else {
    $produto = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produtos WHERE id=$id"));
    $_SESSION['carrinho'][$id] = ['nome' => $produto['nome'], 'preco' => $produto['preco'], 'qtd' => 1, 'imagem' => $produto['imagem']];
}
echo json_encode(['status' => 'ok', 'total_itens' => count($_SESSION['carrinho'])]);
?>