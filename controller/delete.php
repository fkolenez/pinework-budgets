<?php
    session_start();
    include_once '../model/Conexao.class.php';
    include_once '../model/Entity.class.php';

    $Entity = new Entity();
    $id = $_GET["id"];

    if (isset($id) && !empty($id)) {
        try {
            $Entity->delete("budgets", $id);
            $_SESSION["msg"] = "Deletado com sucesso";
        } catch (Exception $e) {
            $_SESSION["msg_error"] = "$e";
        }

        header('Location: ../view/inicio.php');
        exit(); // Garante que o redirecionamento funciona
    }
?>