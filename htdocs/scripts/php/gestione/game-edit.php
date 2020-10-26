<?php
    require_once "../configuration.php";
    if ($_POST["Nome"] == $_POST["Nome_vecchio"]) {
        $query = "UPDATE Giochi SET Indoor = {$_POST["Indoor"]}, Note = '{$_POST["Note"]}' WHERE Nome = '{$_POST["Nome"]}'";
        if ($dbh->exec($query))
            $res = "Modifica senza rinominazione di {$_POST["Nome"]} riuscita.";
        else
            $res = "Modifica senza rinominazione di {$_POST["Nome"]} fallita.";
    } elseif (!$dbh->query("SELECT COUNT(*) FROM Giochi WHERE Nome = '{$_POST["Nome"]}'")->fetchColumn()) {
        $dbh->exec("DELETE FROM Giochi WHERE Nome = '{$_POST["Nome_vecchio"]}'");
        session_start();
        $query = "INSERT INTO Giochi VALUES ('{$_POST["Nome"]}', {$_SESSION["ID"]}, {$_POST["Indoor"]}, '{$_POST["Note"]}')";
        if ($dbh->exec($query))
            $res = "Modifica con rinominazione di {$_POST["Nome"]} riuscita.";
        else
            $res = "Modifica con rinominazione di {$_POST["Nome"]} fallita.";
    } else
        $res = "Esiste già un {$_POST["Nome"]} nell'elenco.";
    echo "$res";
?>