<?php
include_once '../model/Conexao.class.php';
include_once '../model/Entity.class.php';

$Entity = new Entity();
$data = $_POST; 

// Verifica se o campo "pago" foi enviado, se não, define como 0
$data["payed"] = isset($data["payed"]) && $data["payed"] === "on" ? "s" : "n";

// var_dump($_POST);
var_dump($data);


if (!empty($data)) {
    try {
        $Entity->insert("budgets", $data);
        $_SESSION["msg"] = "Inserido com sucesso";
    } catch (Exception $e) {
        $_SESSION["msg_error"] = "$e";
    }

    header('Location: ../view/inicio.php');
    exit(); // Garante que o redirecionamento funciona
}
?>