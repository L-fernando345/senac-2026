<?php
session_start();



include 'config.php';

$id = (int)$_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id"));
$pedidos = mysqli_query($conn, "SELECT * FROM pedidos WHERE id = $id ORDER BY data DESC");
?>
<!DOCTYPE html>
<html><head><title>Detalhes: <?=htmlspecialchars($user['nome'])?></title></head>
<body style="background:#222;color:#fff;padding:20px;">
    <a href="admin.php#usuarios">← Voltar</a>
    <h2>👤 <?=htmlspecialchars($user['nome'])?></h2>
    <p><strong>Email:</strong> <?=htmlspecialchars($user['email'])?></p>
    <p><strong>Status:</strong> <?=($user['ativo'] ? '✅ Ativo' : '❌ Inativo')?></p>
    <p><strong>Criado:</strong> <?=date('d/m/Y H:i', strtotime($user['criado_em']))?></p>
    
    <h3>📋 Pedidos (<?=mysqli_num_rows($pedidos)?>)</h3>
    <table style="width:100%;border-collapse:collapse;">
        <tr style="background:#ff4500;"><th>ID</th><th>Total</th><th>Data</th><th>Status</th></tr>
        <?php while($p = mysqli_fetch_assoc($pedidos)): ?>
        <tr style="border:1px solid #666;"><td><?=$p['id']?></td><td>R$<?=number_format($p['total'],2)?></td><td><?=date('d/m H:i', strtotime($p['data']))?></td><td><?=$p['status']?></td></tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
