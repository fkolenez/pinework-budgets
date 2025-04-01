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
<div class="container pt-5">
    <h1>Olá, Gabriel</h1>
    
    <div class="form-group pt-3">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-md-4 d-flex pr-0 pl-0">
                <form method="GET" class="d-flex align-items-center w-100">
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" placeholder="Digite o nome do cliente" name="client"
                            value="<?= htmlspecialchars($clientName) ?>">

                        <button type="submit" class="p-0 clean-button">
                            <div class="input-group-prepend">
                                <span class="input-group-text w-100 d-flex justify-content-center align-items-center span-important"
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
            <a href="<?= strtok($_SERVER["REQUEST_URI"], token: '?') ?>" class="btn btn-secondary mt-2">Reiniciar tabela</a>
        </div>
    </div>

    <div class="row d-flex justify-content-center pt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Orçamento total</th>
                    <th>Pago</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dados)): ?>
                    <?php foreach ($dados as $key): ?>
                        <tr class=" text-dark ">
                            <td> <?= $key["id"] ?> </td>
                            <td> <?= $key["client"] ?> </td>
                            <td> <?= $key["costs"] ?> </td>
                            <td> R$: <?= $key["budgets"] ?> </td>
                            <td> <?= $key["payed"] ?> </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Nenhum dado encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include_once("footer.php");
?>