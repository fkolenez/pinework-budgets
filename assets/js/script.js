let deleteId = null; // Variável para armazenar o ID do orçamento

// Função para definir o ID do orçamento que será excluído
function setDeleteId(id) {
    deleteId = id;
}

// Função para excluir o orçamento
function confirmDelete() {
    if (deleteId) {
        window.location.href = "../controller/delete.php?id=" + deleteId;
    }
}

// Evento para ativar a exclusão quando o botão do modal for clicado
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("confirmDeleteBtn").addEventListener("click", confirmDelete);
});
