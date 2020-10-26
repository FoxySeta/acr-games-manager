<?php
    require_once "../configuration.php";
    if ($dbh->exec("DELETE FROM Giochi WHERE Nome = '{$_POST["Nome"]}'"))
        $res = "Eliminazione riuscita.";
    else
        $res = "Eliminazione di {$_POST["Nome"]} fallita.";
    echo "$res";
?>