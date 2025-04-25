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

# TODO
# Fazer um modal para exclusão
# Chamar as funçoes de delete e update na tabela

?>

<style>
    .shadow_main {
        box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
    }

    .border-radius-lupa {
        border-radius: 0 .25rem .25rem 0 !important;
    }

    .form-control:focus {
        border-color: black;
        box-shadow: none;
        outline: 0;
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    <nav class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px; height: 100vh;">
        <h3 class="text-center mb-md-0 me-md-auto text-dark text-decoration-none">
            PineWork
        </h3>
        <ul class="nav nav-pills flex-column mb-auto mt-3">
            <li class="nav-item">
                <a href="./home.php" class="nav-link active" aria-current="page">
                    Home
                </a>
            </li>
            <li>
                <a href="./newBudget.php" class="nav-link text-dark">
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

    <div class="container-fluid m-5">
        <h1>Olá, Gabriel</h1>

        <hr>

        <div class="form-group mb-4">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-4 d-flex pr-0 pl-0">
                    <form method="GET" class="d-flex align-items-center w-100">
                        <div class="input-group mt-2 shadow_main">
                            <input type="text" class="form-control " placeholder="Digite o nome do cliente" name="client"
                                value="<?= htmlspecialchars($clientName) ?>">

                            <button type="submit" class="p-0 clean-button">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text border-radius-lupa w-100 d-flex justify-content-center align-items-center span-important"
                                        id="basic-addon1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                            class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                        </svg>
                                    </span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>

                <a href="<?= strtok($_SERVER["REQUEST_URI"], token: '?') ?>">
                    <button class="btn btn-sm mt-2 shadow_main">
                        Reiniciar tabela
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-counterclockwise align-middle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                            <path
                                d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466" />
                        </svg>

                    </button>
                </a>
            </div>
        </div>

        <hr>

        <div class="row d-flex justify-content-center pt-3">
            <table class="table table-striped shadow_main">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Orçamento total</th>
                        <th class="text-center">Custos</th>
                        <th class="text-center">Pago</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dados)): ?>
                        <?php foreach ($dados as $key): ?>
                            <tr class=" text-dark">
                                <td class="text-center"> <?= $key["id"] ?> </td>
                                <td class="text-center">
                                    <a href="client.php?id=<?= $key['id'] ?>"
                                        class="d-block w-100 h-100 text-dark text-decoration-none p-2">
                                        <?= htmlspecialchars($key["client"]) ?>
                                    </a>
                                </td>
                                <td class="text-center"> R$ <?= number_format($key['budget'], 2, ',', '.') ?> </td>
                                <td class="text-center"> R$ <?= number_format($key['budget'], 2, ',', '.') ?> </td>
                                <td class="text-center"> <?= $key["payed"] === "s" ? "Sim" : "Não" ?> </td>
                                <td class="d-flex justify-content-around">
                                    <a href="insert.php?id=<?= $key['id'] ?>" class="btn  btn-outline-secondary  btn-sm">
                                        Editar
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-square align-middle" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </a>

                                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal" onclick="setDeleteId(<?= $key['id'] ?>)">
                                        Excluir
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-x-lg align-middle" viewBox="0 0 16 16">
                                            <path
                                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                        </svg>
                                    </button>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhum dado encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal exclusão -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"> <svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-lg align-middle" viewBox="0 0 16 16">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja excluir este orçamento?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Excluir <svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-lg align-middle" viewBox="0 0 16 16">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <ul>
            <li>Pagina de cada cliente</li>
            <li>Data na tabela</li>
            <li>Filtro por data</li>
            <li>Controle de estoque</li>
            <li>Acertar oque foi pedido para Adicionar orçamento</li>
            <li>Select dinamico pra add orçamento</li>
            <li>Graficos</li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    include_once("footer.php");
    ?>