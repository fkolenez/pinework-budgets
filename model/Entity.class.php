<?php
require_once("Conexao.class.php");

class Entity extends Conexao
{
    public function list($table)
    {
        $pdo = parent::getInstance();
        $sql = "SELECT * FROM $table ORDER BY id ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca por condição customizada, tipo: budget_id = 5
    public function listByCondition($table, $condition)
    {
        $pdo = parent::getInstance();
        $sql = "SELECT * FROM $table WHERE $condition ORDER BY id ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca por nome de cliente (como já estava)
    public function listFilteredByClient($table, $clientName)
    {
        $pdo = parent::getInstance();
        $sql = "SELECT * FROM $table WHERE LOWER(client) LIKE LOWER(:client)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":client", "%$clientName%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $pdo = parent::getInstance();
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $pdo->lastInsertId();
    }

    public function delete($table, $id)
    {
        $pdo = parent::getInstance();
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getInfoByID($table, $id)
    {
        $pdo = parent::getInstance();
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $id)
    {
        $pdo = parent::getInstance();
        $set = "";

        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }

        $set = rtrim($set, ", ");
        $sql = "UPDATE $table SET $set WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
