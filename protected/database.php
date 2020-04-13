<?php
    function getConnection(){
        $connection = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME.';',DB_USER,DB_PASS);
        $connection->exec("SET NAMES'".DB_CHARSET."'");
        return $connection;
    }

    function getRecord($queryString, $queryParams = []){
        $connection = getConnection();
        $statement = $connection->prepare($queryString);
        $success = $statement->execute($queryParams);
        $result = $success ? $statement->fetch(PDO::FETCH_ASSOC) : [];
        $statement->closeCursor();
        $connection = null;
        return $result;
    }

    function getList($queryString, $queryParams = []){
        $connection = getConnection();
        $statement = $connection->prepare($queryString);
        //die(var_dump($statement));
        $success = $statement->execute($queryParams);
        $result = $success ? $statement->fetchAll(PDO::FETCH_ASSOC) : die(print_r($statement->errorInfo(),true));
        $statement->closeCursor();
        $connection = null;
        return $result;
    }

    // UPDATE, DELETE, INSERT
    function executeDML($queryString, $queryParams = []){
        $connection = getConnection();
        $statement = $connection->prepare($queryString);
        $success = $statement->execute($queryParams);
        $statement->closeCursor();
        $connection = null;
        return $success;
    }

    // if(executeDML(...,...))

    // SELECT COUNT(id) FROM menu - Hány darab sor van? 1 rekordos táblát ad vissza 1 oszloppal
    function getField($queryString, $queryParams = []){
        $connection = getConnection();
        $statement = $connection->prepare($queryString);
        $success = $statement->execute($queryParams);
        $result = $success ? $statement->fetch()[0] : [];
        $statement->closeCursor();
        $connection = null;
        return $result;
    }
?>