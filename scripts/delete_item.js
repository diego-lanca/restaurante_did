document.addEventListener('DOMContentLoaded', () => {
    // Excluir item
    document.querySelectorAll('.btn-excluir').forEach(button => {
        button.addEventListener('click', () => {
            const itemNome = button.getAttribute('data-item');

            fetch('../scripts/delete_item.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ item_nome: itemNome })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Recarrega a página
                    } else {
                        alert('Erro ao remover o item.');
                    }
                });
        });
    });
});