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

    function Valid_LicensePlate($string){
        $pattern = "/[epvz]-[\d]{5}$|[a-zA-Z]{3}-[\d]{3}$|[a-zA-Z]{4}-[\d]{2}$|[a-zA-Z]{5}-[\d]{1}$|[mM][\d]{2} [\d]{4}$|(ck|dt|hc|cd|hx|ma|ot|rx|rr) [\d]{2}-[\d]{2}$|(c-x|x-a|x-b|x-c) [\d]{4}$/";
        return preg_match($pattern, $string, $matches) === 1 && $matches[0] === $string;
    }

?>