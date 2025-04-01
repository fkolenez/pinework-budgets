<?php
    require_once("Conexao.class.php");

    class Entity extends Conexao{
        public function list($table){
            $pdo = parent::getInstance();
            $sql = "SELECT * FROM $table order by id ASC";
            $statement = $pdo->query($sql);
            $statement->execute();
            return $statement->fetchAll();
        }

        
        public function listFiltered($table, $clientName){
            $pdo = parent::getInstance();
            $sql = "SELECT * FROM $table WHERE LOWER(client) LIKE LOWER(:client)";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":client", "%$clientName%", PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        

        // função para inserir
        public function insert($table, $data){
            $pdo = parent::getInstance();

            $campos = implode(", ", array_keys($data));
            $valores = ":".implode(", :", array_keys($data));

            $sql = "INSERT INTO $table($campos) VALUES ($valores)";

            echo $sql;

            $statement = $pdo->prepare($sql);

            foreach($data as $key => $value) {
                $statement->bindValue(":$key", $value,PDO::PARAM_STR);
            }

            $statement->execute();
        }

        // função p deletar
        public function delete($table, $id){
            $pdo = parent::getInstance();
            $sql = "DELETE FROM $table WHERE id = :id";

            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
        }

        public function getInfoByID($table, $id)
        {
            $pdo = parent::getInstance();
            $sql = "SELECT * FROM $table WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->bindValue("id", $id);
            $statement->execute();
            return $statement->fetchAll(); //retorna em formato de array
        } 

        public function update($table, $data, $id){
            $pdo = parent::getInstance();
            $novosValores = "";

            foreach($data as $key => $value) {
                $novosValores .= "$key=:$key, ";
            }

            $novosValores = substr($novosValores,0,-2);
            $sql = "UPDATE $table SET $novosValores WHERE id = :id";
            
            $statement = $pdo->prepare($sql);

            foreach($data as $key => $value) {
                $statement->bindValue(":$key", $value,PDO::PARAM_STR);
            }
        
            $statement->bindValue(":id", $id);
            $statement->execute();
        }
    }
?>