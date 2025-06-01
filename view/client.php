<?php
include_once("header.php");
require_once '../model/Entity.class.php';
$entity = new Entity();

$budget_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($budget_id <= 0) {
    die("ID inválido");
}

$budget = $entity->getInfoByID("budgets", $budget_id);
$films = $entity->listByCondition("films", "budget_id = $budget_id");
$costs = $entity->listByCondition("additional_costs", "budget_id = $budget_id");

$total_films = array_sum(array_column($films, 'cost'));
$total_costs = array_sum(array_column($costs, 'travel_cost'));
?>

<div class="d-flex">
    <!-- Sidebar -->
    <nav class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px; height: 100vh;">
        <h3 class="text-center mb-md-0 me-md-auto text-dark text-decoration-none">
            PineWork
        </h3>
        <ul class="nav nav-pills flex-column mb-auto mt-3">
            <li class="nav-item">
                <a href="./home.php" class="nav-link active" aria-current="page">Home</a>
            </li>
            <li>
                <a href="./newBudget.php" class="nav-link text-dark">Adicionar orçamento</a>
            </li>
            <li>
                <a href="./budgetControl" class="nav-link text-dark">Controle de estoque</a>
            </li>
            <li>
                <a href="./budgetControl" class="nav-link text-dark">Gráficos</a>
            </li>
        </ul>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container-fluid p-5">
        <h2 class="mb-4">Orçamento #<?= $budget['id'] ?> - <?= htmlspecialchars($budget['client']) ?></h2>
        <p><strong>Status:</strong> <?= $budget['status'] ?></p>
        <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($budget['data'])) ?></p>

        <!-- Películas -->
        <div class="mb-5">
            <h4>Películas</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Largura</th>
                        <th>Altura</th>
                        <th>Custo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($films as $film): ?>
                        <tr>
                            <td><?= htmlspecialchars($film['name']) ?></td>
                            <td><?= $film['width'] ?> cm</td>
                            <td><?= $film['height'] ?> cm</td>
                            <td>R$ <?= number_format($film['cost'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><strong>Total películas:</strong> R$ <?= number_format($total_films, 2, ',', '.') ?></p>
        </div>

        <!-- Custos adicionais -->
        <div class="mb-5">
            <h4>Custos adicionais</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Horas</th>
                        <th>Distância (km)</th>
                        <th>Colaboradores</th>
                        <th>Custo deslocamento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($costs as $cost): ?>
                        <tr>
                            <td><?= $cost['worked_hours'] ?> h</td>
                            <td><?= $cost['distance_km'] ?> km</td>
                            <td><?= $cost['collaborators'] ?></td>
                            <td>R$ <?= number_format($cost['travel_cost'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><strong>Total custos adicionais:</strong> R$ <?= number_format($total_costs, 2, ',', '.') ?></p>
        </div>

        <!-- Resumo -->
        <div>
            <h4>Resumo</h4>
            <p><strong>Orçamento total (películas + custos):</strong> <span class="fw-bold">R$ <?= number_format($total_films + $total_costs, 2, ',', '.') ?></span></p>
        </div>
    </div>
</div>

<?php
include_once("footer.php");
?>