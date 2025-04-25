<?php
include_once("header.php");
require_once '../model/Entity.class.php'; // Certifique-se de que está incluindo a classe corretamente

$entity = new Entity(); // Instancia a classe
$dados = $entity->list("budgets"); // Obtém os dados do banco de dados]

$clientName = isset($_GET['client']) ? trim($_GET['client']) : '';

// Se um nome foi digitado, filtra no banco de dados
if (!empty($clientName)) {
    $dados = $entity->listFiltered("budgets", $clientName);
} else {
    $dados = $entity->list("budgets");
}
?>

<div class="d-flex">
    <!-- Sidebar -->
    <nav class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px; height: 100vh;">
        <h3 class="text-center mb-md-0 me-md-auto text-dark text-decoration-none">
            PineWork
        </h3>
        <ul class="nav nav-pills flex-column mb-auto mt-3">
            <li class="nav-item">
                <a href="./home.php" class="nav-link text-dark"  aria-current="page">
                    Home
                </a>
            </li>
            <li>
                <a href="./newBudget.php" class="nav-link active">
                    Adicionar orçamento
                </a>
            </li>
            <li>
                <a href="./budgetControl" class="nav-link text-dark">
                    Controle de estoque
                </a>
            </li>
            <li>
                <a href="./budgetControl" class="nav-link text-dark">
                    Gráficos
                </a>
            </li>
        </ul>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container">
        <h1 class="mb-4">Novo Orçamento</h1>

        <form action="../controller/insert.php" method="post">
            <!-- Cliente -->
            <div class="mb-3">
                <label for="client" class="form-label fs-6">Cliente</label>
                <input type="text" class="form-control" id="client" name="client" placeholder="Digite o nome do cliente">
            </div>

            <!-- Orçamento -->
            <div class="mb-3">
                <label for="budget" class="form-label fs-6">Orçamento</label>
                <input type="number" class="form-control" id="budget" name="budget" placeholder="R$ 0,00">
            </div>

            <!-- Custos -->
            <div class="mb-3">
                <!-- Campo oculto para garantir que envie "n" se o checkbox não for marcado -->
                <input type="hidden" name="payed" value="n">

                <label for="costs" class="form-label fs-6">Custos</label>
                <input type="number" class="form-control" id="costs" name="costs" placeholder="R$ 0,00">
            </div>

            <!-- Pago -->
            <div class="mb-3">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="payed" name="payed">
                    <label class="form-check-label fs-6" for="pago">Pago</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="./home.php" class="btn btn-sm btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
            </div>
        </form>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>