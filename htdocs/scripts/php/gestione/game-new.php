<?php
    require_once "../configuration.php";
    if (!$dbh->query("SELECT COUNT(*) FROM Giochi WHERE Nome = '{$_POST["Nome"]}'")->fetchColumn()) {
        session_start();
        $query = "INSERT INTO Giochi VALUES ('{$_POST["Nome"]}', {$_SESSION["ID"]}, {$_POST["Indoor"]}, '{$_POST["Note"]}')";
        if ($dbh->exec($query))
            $res = "Creazione di {$_POST["Nome"]} riuscita.";
        else
            $res = "Creazione di {$_POST["Nome"]} fallita.";
    } else
        $res = "Esiste già un {$_POST["Nome"]} nell\'elenco.";
    echo "$res";
?>