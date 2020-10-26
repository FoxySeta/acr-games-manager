<script src="/scripts/js/gestione/risultati.js" type="text/javascript"></script>

<table class="report">
    <thead>
        <tr>
<?php
    session_start();
    require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/php/configuration.php";
    $stm = $dbh->prepare("SELECT * FROM Annate JOIN Squadre ON Annate.Anno_inizio = Squadre.Annata_Anno_inizio WHERE Squadre.ID = {$_SESSION["ID"]}");
    if (!$stm->execute())
        echo "Failure!";
    $annata = $stm->fetch(PDO::FETCH_BOTH);
    $anni = $annata["Anno_inizio"] . "/" . ($annata["Anno_inizio"] + 1);
EOT;
    $colonne = $dbh->query("SELECT COUNT(*) FROM Squadre WHERE Annata_Anno_Inizio = {$annata["Anno_inizio"]}")->fetchColumn() + 1;
    echo <<< EOT
                    <th colspan="$colonne" scope="colgroup">
                        <a href="{$annata["Tema_url"]}" hreflang="it" rel="external" target="_blank">
                            <span class=" ui-icon ui-icon-extlink"></span>
                            {$annata["Tema_nome"]} ($anni)<br>
                        </a>
                    </th>
                </tr>
EOT;
    $stm = $dbh->prepare("SELECT ID, Nome, Colore FROM Squadre WHERE Annata_Anno_Inizio = {$annata["Anno_inizio"]}");
    if (!$stm->execute())
        echo "Failure!";
    echo "<tr><th>Date</th>";
    $squadre = array();
    $totali = array();
    while ($squadra = $stm->fetch(PDO::FETCH_BOTH)) {
        array_push($squadre, $squadra);
        echo "<th style=\"color:{$squadra["Colore"]}\">{$squadra["Nome"]}</th>";
        $totali[$squadra["ID"]] = 0;
    }
?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
                echo "<td></td>";
                for ($i = 1; $i < $colonne; ++$i)
                    echo "<td class=\"right-align\">0</td>";
                $query = <<< EOT
                    SELECT Giornate.Data AS Data,
                        Giornate.Note AS Note,
                        Squadre.ID AS Autore_ID,
                        Squadre.Caposquadra AS Autore,
                        Prestazioni.Squadra_ID AS Squadra,
                        Prestazioni.Punteggio AS Punteggio
                    FROM Giornate
                    JOIN Squadre
                        ON Giornate.Squadra_ID = Squadre.ID
                    JOIN Prestazioni
                        ON Giornate.Data = Prestazioni.Giornata_Data
                    WHERE Squadre.Annata_Anno_inizio = {$annata["Anno_inizio"]}
EOT;
                $stm = $dbh->prepare($query);
                if (!$stm->execute())
                    echo "Failure!";
                $data = "";
                $stm3 = $dbh->prepare("SELECT Nome FROM Giochi");
                if (!$stm3->execute())
                    echo "Failure!";
                $giochi = array();
                while ($gioco = $stm3->fetch(PDO::FETCH_BOTH))
                    array_push($giochi, $gioco["Nome"]);
                while ($record = $stm->fetch(PDO::FETCH_BOTH)) {
                    if ($record["Data"] != $data) {
                        $data = $record["Data"];
                        echo "</tr><div class=\"info_giornata $data\" title=\"Info sulla giornata ("
                             . date_format(date_create($data), "d/m")
                             . ")\">Registrata da: {$record["Autore"]}<br>Giochi svolti:<br><ul>";
                        $stm2 = $dbh->prepare("SELECT Gioco_Nome FROM Partite WHERE Giornata_Data = '$data'");
                        if (!$stm2->execute())
                            echo "Failure!";
                        $empty_list = true;
                        $giochi_fatti = array();
                        while ($gioco = $stm2->fetch(PDO::FETCH_BOTH)["Gioco_Nome"]) {
                            echo "<li>$gioco</li>";
                            array_push($giochi_fatti, $gioco);
                            $empty_list = false;
                        }
                        if ($empty_list)
                            echo "nessuno";
                        echo "</ul><hr>{$record["Note"]}";
                        if ($record["Autore_ID"] === $_SESSION["ID"]) {
                            echo <<< EOT
                                <hr><button class="giornata_pulsante_edit ui-button ui-corner-all ui-widget" value="$data">
                                    <span class="ui-icon ui-icon-pencil"></span>Modifica
                                </button>
                                <div class="edit_giornata $data" title="Modifica giornata (
EOT;
                            echo date_format(date_create($data), "d/m");
                            echo <<< EOT
)">
                                <input type="date" name="data" value="$data"/><br>
                                Registrata da: {$record["Autore"]}<br>
                                Giochi svolti:
                                <select multiple name="giochi">
EOT;
                            foreach ($giochi as $gioco) {
                                echo "<option";
                                if (in_array($gioco, $giochi_fatti))
                                    echo " selected";
                                echo ">$gioco</option>";
                            }
                            echo "</select><br>";
                            foreach ($squadre as $squadra)
                                echo <<< EOT
                                    <span style="color:{$squadra["Colore"]}">
                                        {$squadra["Nome"]}
                                    </span>
                                    <input type="hidden" name="squadra" value="{$squadra["ID"]}"/>
                                    <input type="number" name="punteggio" value="0"/><br>
EOT;
                            echo <<< EOT
                                    <hr>
                                    <textarea maxlength="5000" name="note" placeholder="Note a piacere (massimo 5000 caratteri)">{$record["Note"]}</textarea><br>
                                    <hr><button class="salva ui-button ui-corner-all ui-widget" value="{$data}">
                                            <span class="ui-icon ui-icon-disk"></span>Salva
                                        </button>
                                </div>
                                <button class="giornata_pulsante_delete ui-button ui-corner-all ui-widget" value="$data">
                                    <span class="ui-icon ui-icon-trash"></span>Elimina
                                </button>
                                <div class="delete_giornata $data" title="Elimina giornata (
EOT;
                                echo date_format(date_create($data), "d/m");
                                echo <<< EOT
)">
                                    Eliminare questa giornata?<br>
                                    <button class="elimina ui-button ui-corner-all ui-widget" value="{$data}">
                                        <span class="ui-icon ui-icon-trash"></span>Elimina
                                    </button>
                                </div>
EOT;
                        }
                        echo "</div><tr><td><button class=\"giornata_pulsante_info ui-button ui-corner-all ui-widget\" value=\"$data\">"
                             . date_format(date_create($data), "d/m")
                             . "</button></td>";
                    }
                    $totali[$record["Squadra"]] += $record["Punteggio"];
                    echo "<td class=\"right-align\">(+{$record["Punteggio"]})<br>{$totali[$record["Squadra"]]}</td>";
                }
            ?>
        </tr>
    </tbody>
    <tfooter>
        <tr>
            <th colspan="<?php echo $colonne; ?>">
                <button id="day-new-button"></button>
                <div id="day-new-dialog" title="Registra nuova giornata">
                    <input type="date" id="day-new-date" value="<?php echo date("Y-m-d"); ?>" /><br>
                    Giochi svolti:
                    <select multiple id="day-new-games">
                        <?php
                            foreach ($giochi as $gioco)
                                echo "<option>$gioco</option>";
                        ?>
                    </select><br />
                    <?php
                        foreach ($squadre as $squadra)
                        echo <<< EOT
                            <span style="color:{$squadra["Colore"]}">
                                {$squadra["Nome"]}
                            </span>
                            <input type="hidden" name="squadra" value="{$squadra["ID"]}"/>
                            <input type="number" name="punteggio" value="0"/><br />
EOT;
                    ?><hr />
                    <textarea maxlength="5000" id="day-new-notes" placeholder="Note a piacere (massimo 5000 caratteri)"></textarea><hr />
                </div>
            </th>
        </tr>
    </tfooter>
</table>