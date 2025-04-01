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

?>

<style>
    
.shadow_main{
    box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
}

</style>

<div class="container pt-5">
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
                                    class="input-group-text w-100 d-flex justify-content-center align-items-center span-important"
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

            <button class="btn btn-sm btn-secondary shadow_main mt-2">
                Adicionar orçamento

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-plus-lg align-middle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                </svg>
            </button>

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
                            <td class="text-center"> R$: <?= number_format($key['budgets'], 2, ',', '.') ?> </td>
                            <td class="text-center"> R$: <?= number_format($key['budgets'], 2, ',', '.') ?> </td>
                            <td class="text-center"> <?= $key["payed"] ?> </td>
                            <td class="d-flex justify-content-around">

                                <!--
                                   Chamar as funçoes de delete e update 
                                -->

                                <a href="edit.php?id=<?= $key['id'] ?>" class="btn  btn-outline-secondary  btn-sm">
                                    Editar
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pencil-square align-middle" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                </a>
                                <a href="delete.php?id=<?= $key['id'] ?>" class="btn btn-outline-secondary btn-sm"
                                    onclick="return confirm('Tem certeza que deseja excluir este registro?');">
                                    Excluir
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-x-lg align-middle" viewBox="0 0 16 16">
                                        <path
                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                    </svg>
                                </a>
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
</div>

<?php
include_once("footer.php");
?>