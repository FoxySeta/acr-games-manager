<?php
    require_once "../configuration.php";
    if (!$dbh->query("SELECT COUNT(*) FROM Giornate WHERE Data = '{$_POST["date"]}'")->fetchColumn()) {
        session_start();
        $query = "INSERT INTO Giornate VALUES ('{$_POST["date"]}', {$_SESSION["ID"]}, '{$_POST["notes"]}')";
        if ($dbh->exec($query)) {
            $res = "Creazione della giornata {$_POST["date"]} riuscita.";
            
            $giochi = json_decode($_POST["games"]);
            $punteggi = json_decode($_POST["scores"]);
    
            if ($giochi) {
                $query = "INSERT INTO Partite VALUES";
                foreach ($giochi as $i => $gioco) {
                    if ($i)
                        $query .= ",";
                    $query .= " (0, '$gioco', '{$_POST["date"]}')";
                }
            }
            $dbh->exec($query);
    
            if ($punteggi) {
                $query = "INSERT INTO Prestazioni VALUES";
                foreach ($punteggi as $i => $punteggio) {
                    if ($i)
                        $query .= ",";
                    $query .= " (0, {$punteggio[0]}, '{$_POST["date"]}', {$punteggio[1]})";
                }
            }
            $dbh->exec($query);
        } else
            $res = "Creazione della giornata {$_POST["date"]} fallita.";
    } else
        $res = "Esiste già una giornata {$_POST["date"]} nell'elenco.";
    echo "$res";
?>