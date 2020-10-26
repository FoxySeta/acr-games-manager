<?php
    require_once "../configuration.php";
    $dbh->exec("DELETE FROM Partite WHERE Giornata_Data = '{$_POST["date"]}'");
    $dbh->exec("DELETE FROM Prestazioni WHERE Giornata_Data = '{$_POST["date"]}'");
    if ($dbh->exec("DELETE FROM Giornate WHERE Data = '{$_POST["date"]}'"))
        $res = "Eliminazione della giornata {$_POST["date"]} riuscita.";
    else
        $res = "Eliminazione della giornata {$_POST["date"]} fallita.";
    echo "$res";
?>