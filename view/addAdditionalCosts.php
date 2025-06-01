<?php
include_once("header.php");
require_once '../model/Entity.class.php';

$entity = new Entity();
$budget_id = isset($_GET['budget_id']) ? (int) $_GET['budget_id'] : 0;

if ($budget_id <= 0) {
    die("Orçamento inválido.");
}

// Excluir custo adicional
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['cost_id'])) {
    $entity->delete('additional_costs', (int)$_GET['cost_id']);
    header("Location: addAdditionalCosts.php?budget_id=$budget_id");
    exit;
}

// Inserir novo custo adicional
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cost = [
        'budget_id' => $budget_id,
        'worked_hours' => $_POST['worked_hours'],
        'distance_km' => $_POST['distance_km'],
        'collaborators' => $_POST['collaborators']
    ];
    $entity->insert('additional_costs', $cost);
    header("Location: addAdditionalCosts.php?budget_id=$budget_id");
    exit;
}

// Lista custos adicionais já inseridos
$additionalCosts = $entity->listByCondition('additional_costs', "budget_id = $budget_id");
?>

<div class="container mt-4">
    <h2>Custos Adicionais</h2>

    <form method="post" class="mb-4">
        <div class="mb-2">
            <label class="form-label">Horas trabalhadas</label>
            <input type="number" step="0.01" class="form-control" name="worked_hours" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Distância (KM)</label>
            <input type="number" step="0.01" class="form-control" name="distance_km" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Colaboradores</label>
            <input type="number" class="form-control" name="collaborators" required>
        </div>

        <button type="submit" class="btn btn-success">Adicionar custo</button>
    </form>

    <h4>Custos adicionais registrados</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Horas</th>
                <th>Distância</th>
                <th>Custo deslocamento</th>
                <th>Colaboradores</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($additionalCosts as $cost): ?>
            <tr>
                <td><?= $cost['worked_hours'] ?> h</td>
                <td><?= $cost['distance_km'] ?> km</td>
                <td>R$ <?= number_format($cost['travel_cost'], 2, ',', '.') ?></td>
                <td><?= $cost['collaborators'] ?></td>
                <td>
                    <a href="addAdditionalCosts.php?budget_id=<?= $budget_id ?>&action=delete&cost_id=<?= $cost['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir este custo adicional?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4 d-flex gap-3">
        <a href="addFilms.php?budget_id=<?= $budget_id ?>" class="btn btn-secondary">Voltar</a>
        <a href="viewBudget.php?id=<?= $budget_id ?>" class="btn btn-primary">Finalizar orçamento</a>
    </div>
</div>
