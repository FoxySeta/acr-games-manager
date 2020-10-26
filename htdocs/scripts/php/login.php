<?php
    // since this script calls header(), it has to be included first
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: ../../gestione.php");
        exit;
    }
    require_once "configuration.php";
    $password = $password_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["password"])))
            $password_err = "Manca la password!";
        else
            $password = trim($_POST["password"]);
        if(empty($password_err)){
            $sql = "SELECT ID, Password FROM Squadre WHERE ID = :id";
            if($stmt = $dbh->prepare($sql)){
                $stmt->bindParam(":id", $param_username, PDO::PARAM_STR);
                $param_username = $_POST["squadra"];
                if($stmt->execute())
                    if($stmt->rowCount() == 1){
                        if($row = $stmt->fetch())
                            $hashed_password = password_hash($row["Password"], PASSWORD_DEFAULT);
                            if(password_verify($password, $hashed_password)){
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["ID"] = $param_username;
                                header("location: ../../gestione.php");
                                exit;
                            } else
                                $password_err = "Hai sbagliato la password!";
                    } else
                        $password_err = "Account non riconosciuto!";
                else
                    $password_err = "Errore non identificato.";
            }
            unset($stmt);
        }
        unset($pdo);
    }
    if ($password_err)
        echo "<script type=\"text/javascript\">$(document).ready(function() {alert(\"{$password_err}\");});</script>";
?>