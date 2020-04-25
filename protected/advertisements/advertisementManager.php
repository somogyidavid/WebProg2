<?php
require_once DATABASE_CONTROLLER;
function insertAdvertisement($userid, $title, $licencePlate, $brand, $model, $vintage, $type, $condition, $price, $kilometer, $fuel, $engineCapacity, $color, $description, $contact,$image){
    $checkQuery = "SELECT id FROM advertisementDetails WHERE licencePlate = :licencePlate";
    $checkParams = [
        ':licencePlate' => $licencePlate
    ];
    $record = getRecord($checkQuery,$checkParams);

    if(empty($record)){
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
            $query = "INSERT INTO advertisementDetails(advertisementId,licencePlate,brand,model,vintage,type,`condition`,price,kilometer,fuel,engineCapacity,color,description,contact, image) 
                VALUES (:advertisement_id, :licence_plate, :brand, :model, :vintage, :type, :condition, :price, :kilometer, :fuel, :engine_capacity, :color, :description, :contact, :image)";
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
                ':contact' => $contact,
                ':image' => $image
            ];

            $statement = $connection->prepare($query);
            $success = $statement->execute($params);
            if($success){
                return true;
            }else{
                $query = "DELETE FROM advertisements WHERE id = :id";
                $$params = [ ':id' => $adID];
                return false;
            }
        }
    }
}

function updateAdvertisement($id, $userid, $title, $licencePlate, $brand, $model, $vintage, $type, $condition, $price, $kilometer, $fuel, $engineCapacity, $color, $description, $contact){
    $connection = getConnection();
    $checkQuery = "SELECT id FROM advertisementDetails WHERE licencePlate=:licencePlate";
    $checkParams = [
        ':licencePlate' => $licencePlate
    ];
    $record = getRecord($checkQuery,$checkParams);
    
    if(!empty($record)){
        $query = "UPDATE advertisementDetails SET licencePlate=:licencePlate, brand=:brand, model=:model, vintage=:vintage, type=:type, `condition`=:condition, price=:price, kilometer=:kilometer, fuel=:fuel, engineCapacity=:engineCapacity, color=:color, description=:description, contact=:contact WHERE advertisementId=:id";
        $params = [
            ':id' => $id,
            ':licencePlate' => $licencePlate,
            ':brand' => $brand,
            ':model' => $model,
            ':vintage' => $vintage,
            ':type' => $type,
            ':condition' => $condition,
            ':price' => $price,
            ':kilometer' => $kilometer,
            ':fuel' => $fuel,
            ':engineCapacity' => $engineCapacity,
            ':color' => $color,
            ':description' => $description,
            ':contact' => $contact
        ];

        $statement = $connection->prepare($query);
        $success = $statement->execute($params);

        if($success){
            $query = "UPDATE advertisements SET title=:title WHERE id=:id";
            $params = [
                ':title' => $title,
                ':id' => $id
            ];

            $statement = $connection->prepare($query);
            $success = $statement->execute($params);

            if($success){
                return true;
            }
            else return false;
        }
    }
}
?>