<?php
include_once("header.php");
require_once '../model/Entity.class.php'; 

$entity = new Entity();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Cliente não encontrado.");
}

$id = intval($_GET['id']); // Evita injeção de SQL
$cliente = $entity->getInfoByID("budgets", $id);

if (!$cliente) {
    die("Cliente não encontrado.");
}

    // Array dentro de um array
    $cliente = $cliente[0];
?>


<div class="container pt-5">
    <h1>Detalhes do Cliente: <?= htmlspecialchars($cliente['client']) ?></h1>

    <p><strong>ID:</strong> <?= $cliente['id'] ?></p>
    <p><strong>Orçamento Total:</strong> R$ <?= number_format($cliente['budgets'], 2, ',', '.') ?></p>
    <p><strong>Custos:</strong> R$ <?= number_format($cliente['costs'], 2, ',', '.') ?></p>
    <p><strong>Pago:</strong> <?= $cliente['payed'] == 1 ? "Sim" : "Não" ?></p>

    <a href="edit.php?id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
    <a href="delete.php?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" 
       onclick="return confirm('Tem certeza que deseja excluir este cliente?');">Excluir</a>

    <a href="../index.php" class="btn btn-secondary btn-sm">Voltar</a>
</div>

<?php include_once("footer.php"); ?>
