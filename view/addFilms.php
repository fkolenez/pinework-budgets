<?php
include_once("header.php");
require_once '../model/Entity.class.php';

$entity = new Entity();
$budget_id = isset($_GET['budget_id']) ? (int) $_GET['budget_id'] : 0;

if ($budget_id <= 0) {
    die("Orçamento inválido.");
}

// Deletar película se vier o GET correto
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['film_id'])) {
    $entity->delete('films', (int)$_GET['film_id']);
    header("Location: addFilms.php?budget_id=$budget_id");
    exit;
}

// Inserção de nova película
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film = [
        'budget_id' => $budget_id,
        'name' => $_POST['name'],
        'width' => $_POST['width'],
        'height' => $_POST['height'],
        'cost' => $_POST['cost']
    ];
    $entity->insert('films', $film);
    header("Location: addFilms.php?budget_id=$budget_id");
    exit;
}

// Lista todas as películas já inseridas
$films = $entity->listByCondition('films', "budget_id = $budget_id");
?>

<div class="container mt-4">
    <div class="row d-flex justify-content-center">
        <div class="progress-boxes">
            <div class="box filled"></div>
            <div class="box filled"></div>
            <div class="box"></div>
        </div>
    </div>

    <div class="row d-flex justify-content-center mb-3">
        <h2>Adicionar Películas</h2>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
              <form method="post" class="mb-4">
        <div class="mb-2">
            <label class="form-label">Nome da película</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Largura (cm)</label>
            <input type="number" step="0.01" class="form-control" name="width" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Altura (cm)</label>
            <input type="number" step="0.01" class="form-control" name="height" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Custo (R$)</label>
            <input type="number" step="0.01" class="form-control" name="cost" required>
        </div>

        <div class="row d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-primary">Adicionar película</button>
        </div>
    </form>
            
        </div>
    </div>

    <h4>Películas adicionadas</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Largura</th>
                <th>Altura</th>
                <th>Custo</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film): ?>
            <tr>
                <td><?= htmlspecialchars($film['name']) ?></td>
                <td><?= $film['width'] ?> cm</td>
                <td><?= $film['height'] ?> cm</td>
                <td>R$ <?= number_format($film['cost'], 2, ',', '.') ?></td>
                <td>
                    <a href="addFilms.php?budget_id=<?= $budget_id ?>&action=delete&film_id=<?= $film['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta película?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4 d-flex gap-3">
        <a href="newBudget.php" class="btn btn-secondary">Cancelar</a>
        <a href="addAdditionalCosts.php?budget_id=<?= $budget_id ?>" class="btn btn-primary">Próxima etapa: Custos adicionais</a>
    </div>
</div>
