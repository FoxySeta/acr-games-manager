<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: ../../../index.php");
        exit;
    }
    require_once "../configuration.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
            $sql = "UPDATE Squadre SET Password = :Password WHERE ID = :ID";
            if($stmt = $dbh->prepare($sql)){
                $stmt->bindParam(":Password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":ID", $param_id, PDO::PARAM_INT);
                $param_password = $_POST["password"];
                $param_id = $_SESSION["ID"];
                if($stmt->execute()){
                    echo "Password modificata correttamente.";
                } else
                    echo "Errore non identificato.";
            }
            unset($stmt);
    }
?>