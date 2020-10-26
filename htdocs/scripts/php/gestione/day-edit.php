<?php
    require_once "../configuration.php";
    if ($_POST["date_new"] == $_POST["date_old"] || !$dbh->query("SELECT COUNT(*) FROM Giochi WHERE Nome = '{$_POST["Nome"]}'")->fetchColumn()) {
        $query = "UPDATE Giornate SET Data = '{$_POST["date_new"]}', Note = '{$_POST["notes"]}' WHERE Data = '{$_POST["date_old"]}'";
        $dbh->exec($query);

        $dbh->exec("DELETE FROM Partite WHERE Giornata_Data = '{$_POST["date_old"]}'");
        $dbh->exec("DELETE FROM Prestazioni WHERE Giornata_Data = '{$_POST["date_old"]}'");

        $giochi = json_decode($_POST["games"]);
        $punteggi = json_decode($_POST["scores"]);

        if ($giochi) {
            $query = "INSERT INTO Partite VALUES";
            foreach ($giochi as $i => $gioco) {
                if ($i)
                    $query .= ",";
                $query .= " (0, '$gioco', '{$_POST["date_new"]}')";
            }
        }
        $dbh->exec($query);

        if ($punteggi) {
            $query = "INSERT INTO Prestazioni VALUES";
            foreach ($punteggi as $i => $punteggio) {
                if ($i)
                    $query .= ",";
                $query .= " (0, {$punteggio[0]}, '{$_POST["date_new"]}', {$punteggio[1]})";
            }
        }
        $dbh->exec($query);

        $res = "Modifica di {$_POST["date_new"]} riuscita.";
    } else
        $res = "La data selezionata ({$_POST["date_new"]} è già occupata. Ritentare con una libera.";
    echo "$res";
?>