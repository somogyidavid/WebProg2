<?php
    function DisplayError($key){
        global $errors;

        $result = "";

        if(isset($errors[$key])){
            foreach($errors[$key] as $error_message){
                $result .= $error_message."<br>";
            }
        }

        return $result;
    }

    function DisplaySuccess($message){
        echo "<div class='alert alert-success'>"."Sikeres ".$message."</div>";
    }
?>