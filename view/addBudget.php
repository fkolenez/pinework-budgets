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

    // Excluir custo adicional
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['cost_id'])) {
        $entity->delete('additional_costs', (int) $_GET['cost_id']);
        header("Location: addAdditionalCosts.php?budget_id=$budget_id");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verifica se já existe um custo adicional para esse orçamento
        $existingCost = $entity->findOneByCondition('additional_costs', "budget_id = $budget_id");

        if (!$existingCost) {
            $cost = [
                'budget_id' => $budget_id,
                'worked_hours' => $_POST['worked_hours'],
                'distance_km' => $_POST['distance_km'],
                'collaborators' => $_POST['collaborators']
            ];
            $entity->insert('additional_costs', $cost);
        }

        header("Location: addAdditionalCosts.php?budget_id=$budget_id");
        exit;
    }

    // Lista custos adicionais já inseridos
    $additionalCosts = $entity->listByCondition('additional_costs', "budget_id = $budget_id");
?>

<div class="container mt-4">

    <div class="row d-flex justify-content-center mb-3">
        <h2>Adicionar Películas</h2>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
    <form method="post" class="mb-4">
        <div class="mb-2">
            <label class="form-label">Nome da película</label>
            <input type="text" class="form-control" name="name" required placeholder="Digite o nome da película">
        </div>
        <div class="mb-2">
            <label class="form-label">Largura (M²)</label>
            <input type="number" step="0.01" class="form-control" name="width" required placeholder="Digite a largura da película">
        </div>
        <div class="mb-2">
            <label class="form-label">Altura (M²)</label>
            <input type="number" step="0.01" class="form-control" name="height" required  placeholder="Digite a Altura da película">
        </div>

        <div class="mb-2">
            <label class="form-label">Quantidade</label>
            <input type="number" step="0.01" class="form-control" name="height" required  placeholder="Digite a quantidade películas">
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
                <th>Quantidade</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film): ?>
            <tr>
                <td><?= htmlspecialchars($film['name']) ?></td>
                <td><?= $film['width'] ?></td>
                <td><?= $film['height'] ?></td>
                <td><?= $film['quantity'] ?> </td>
                <td>
                    <a href="addFilms.php?budget_id=<?= $budget_id ?>&action=delete&film_id=<?= $film['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta película?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Custos Adicionais</h2>

    <?php if (count($additionalCosts) === 0): ?>
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

    <?php else: ?>
    
    <?php endif; ?>

    <h4>Custos adicionais registrados</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Horas</th>
                <th>Distância</th>
                <th>Custo deslocamento</th>
                <th>Colaboradores</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($additionalCosts as $cost): ?>
                <tr>
                    <td><?= $cost['worked_hours'] ?> h</td>
                    <td><?= $cost['distance_km'] ?> km</td>
                    <td>R$ <?= number_format($cost['travel_cost'], 2, ',', '.') ?></td>
                    <td><?= $cost['collaborators'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4 d-flex gap-3"> 
        <a href="home.php" class="btn btn-secondary">Finalizar orçamento</a>
    </div> 
</div>
