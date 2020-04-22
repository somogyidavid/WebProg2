<?php
require_once DATABASE_CONTROLLER;
function insertAdvertisement($userid, $title, $licencePlate, $brand, $model, $vintage, $type, $condition, $price, $kilometer, $fuel, $engineCapacity, $color, $description, $contact){
    $connection = getConnection();
    $query = "INSERT INTO advertisements (userid, title) VALUES (:userid, :title)";
    $params= [
        ':userid' => $userid,
        ':title' => $title
    ];
    $statement = $connection->prepare($query);
    $success = $statement->execute($params);

    if($success){
        $adID = $connection->lastInsertId();
        $query = "INSERT INTO advertisementDetails(advertisementId,licencePlate,brand,model,vintage,type,`condition`,price,kilometer,fuel,engineCapacity,color,description,contact) 
            VALUES (:advertisement_id, :licence_plate, :brand, :model, :vintage, :type, :condition, :price, :kilometer, :fuel, :engine_capacity, :color, :description, :contact)";
        $params = [
            ':advertisement_id' => $adID,
            ':licence_plate' => $licencePlate,
            ':brand' => $brand,
            ':model' => $model,
            ':vintage' => $vintage,
            ':type' => $type,
            ':condition' => $condition,
            ':price' => $price,
            ':kilometer' => $kilometer,
            ':fuel' => $fuel,
            ':engine_capacity' => $engineCapacity,
            ':color' => $color,
            ':description' => $description,
            ':contact' => $contact
        ];

        $statement = $connection->prepare($query);
        $success = $statement->execute($params);
        if($success){
            // KÉSZ
        }else{
            var_dump($adID);
            var_dump($statement->errorInfo());
        }
    }
    

}
?>