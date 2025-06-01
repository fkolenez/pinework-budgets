<?php
include_once("header.php");
require_once '../model/Entity.class.php';

$entity = new Entity();
$clientName = isset($_GET['client']) ? trim($_GET['client']) : '';

$dados = !empty($clientName) ? $entity->listFiltered("budgets", $clientName) : $entity->list("budgets");
?>
<!-- Conteúdo principal -->
<?php
include_once("header.php");
require_once '../model/Entity.class.php';

$entity = new Entity();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client = $_POST['client'];
    $status = 'draft';
    $budget = 0;
    $costs = 0;

    $data = [
        'client' => $client,
        'budget' => $budget,
        'costs' => $costs,
        'status' => $status
    ];

    $newId = $entity->insert("budgets", $data);

    // Redireciona para a etapa de adicionar películas
    header("Location: addFilms.php?budget_id=" . $newId);
    exit;
}
?>
    <style>
    body, html {
        height: 100%;
        margin: 0;
        background-color: #ebebeb;
    }

    .full-center {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
</style>


<div class="container full-center">
            <h2 class="mb-4 text-center">Novo Orçamento</h2>


    <div class="bg-white p-5 rounded shadow" style="max-width: 600px; width: 100%;">

        <form method="post" class="d-flex flex-column gap-3">
            <div>
                <label for="client" class="form-label">Nome do Cliente</label>
                <input type="text" class="form-control" id="client" name="client" required placeholder="Digite o nome do cliente">
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="submit" class="btn btn-primary ">Iniciar orçamento</button>
                <a href="home.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>

    <div class="progress-boxes mt-5">
        <div class="box filled"></div>
        <div class="box"></div>
        <div class="box"></div>
    </div>


</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>