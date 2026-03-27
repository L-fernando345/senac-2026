<?php
session_start(); include 'config.php';
if (!$_SESSION['admin']) die('Acesso negado!');
$pedidos = mysqli_query($conn, "SELECT p.*, COUNT(ip.id) as itens FROM pedidos p LEFT JOIN itens_pedido ip ON p.id=ip.pedido_id GROUP BY p.id ORDER BY p.data DESC");
?>
<!DOCTYPE html><html><body style="background:#222;color:#fff;padding:20px;">
<h1>📊 Relatório Completo Pedidos</h1>
<table style="width:100%;border-collapse:collapse;">
<tr style="background:#ff4500;"><th>ID</th><th>Cliente</th><th>Total</th><th>Itens</th><th>Data</th></tr>
<?php while($p = mysqli_fetch_assoc($pedidos)): ?>
<tr style="border:1px solid #666;">
    <td><?=$p['id']?></td><td><?=$p['nome_cliente']?></td><td>R$ <?=number_format($ped['total'],2)?></td>
    <td><?=$p['itens']?></td><td><?=date('d/m/Y H:i', strtotime($p['data']))?></td>
</tr>
<?php endwhile; ?>
</table>
<a href="admin.php">← Voltar Admin</a>
</body></html>
