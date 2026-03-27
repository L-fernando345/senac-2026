let carrinho = [];
function addCarrinho(id) {
    carrinho.push(id);
    alert('Adicionado ao carrinho!');
    // Envie para PHP via AJAX para sessões
    fetch('add_carrinho.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id
    });
}

function removerItem(id) {
    fetch('carrinho.php?action=remove&id=' + id)
        .then(() => location.reload());
}
function esvaziarCarrinho() {
    fetch('carrinho.php?action=empty')
        .then(() => location.reload());
}