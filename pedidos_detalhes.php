<?php
session_start(); 
include 'config.php';
if (!$_SESSION['admin']) header('Location: admin.php');

$id = (int)$_GET['id'];
$pedido = mysqli_fetch_assoc(mysqli_query($conn, "SELECT p.*, u.nome as cliente FROM pedidos p LEFT JOIN usuarios u ON p.user_id = u.id WHERE p.id = $id"));
$itens = mysqli_query($conn, "SELECT ip.*, pr.nome, pr.imagem FROM itens_pedido ip JOIN produtos pr ON ip.produto_id = pr.id WHERE ip.pedido_id = $id");
?>
<!DOCTYPE html><html><head><title>Pedido #<?=$id?></title></head>
<body style="background:#222;color:#fff;padding:20px;">
<a href="admin.php#pedidos">← Voltar</a>
<h1>Pedido #<?=$id?> - R$<?=number_format($pedido['total'],2)?></h1>
<p><strong>Cliente:</strong> <?=htmlspecialchars($pedido['cliente'] ?? 'Convidado')?></p>
<p><strong>Data:</strong> <?=date('d/m/Y H:i', strtotime($pedido['data']))?></p>
<p><strong>Status:</strong> <span class="status-<?=$pedido['status']?>"><?=$pedido['status']?></span></p>

<h3>Itens do Pedido:</h3>
<table style="width:100%;">
<?php while($item = mysqli_fetch_assoc($itens)): ?>
<tr><td><img src="img/<?=$item['imagem']?>" width="50"></td>
<td><?=$item['nome']?> x<?=$item['quantidade']?></td>
<td>R$<?=number_format($item['preco_unit'] * $item['quantidade'],2)?></td></tr>
<?php endwhile; ?>
</table>
</body></html>