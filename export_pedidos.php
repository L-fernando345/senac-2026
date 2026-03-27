<?php
include 'config.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="pedidos_' . date('Y-m-d') . '.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Cliente', 'Total', 'Status', 'Data']);

$pedidos = mysqli_query($conn, "SELECT p.id, u.nome, p.total, p.status, p.data FROM pedidos p LEFT JOIN usuarios u ON p.user_id = u.id ORDER BY p.data DESC");
while($p = mysqli_fetch_assoc($pedidos)) {
    fputcsv($output, [$p['id'], $p['nome'], $p['total'], $p['status'], $p['data']]);
}
?>