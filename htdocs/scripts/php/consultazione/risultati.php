<table class="report">
    <thead>
        <tr>
<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/php/configuration.php";
    $stm = $dbh->prepare("SELECT * FROM Annate WHERE Anno_Inizio = {$_GET["annata"]}");
    if (!$stm->execute())
        echo "Failure!";
    $annata = $stm->fetch(PDO::FETCH_BOTH);
    $anni = $annata["Anno_inizio"] . "/" . ($annata["Anno_inizio"] + 1);
EOT;
    $colonne = $dbh->query("SELECT COUNT(*) FROM Squadre WHERE Annata_Anno_Inizio = {$_GET["annata"]}")->fetchColumn() + 1;
    echo <<< EOT
                    <th colspan="$colonne" scope="colgroup">
                        <a href="{$annata["Tema_url"]}" hreflang="it" rel="external" target="_blank">
                            <span class=" ui-icon ui-icon-extlink"></span>
                            {$annata["Tema_nome"]} ($anni)<br>
                        </a>
                    </th>
                </tr>
EOT;
    $stm = $dbh->prepare("SELECT ID, Nome, Colore FROM Squadre WHERE Annata_Anno_Inizio = {$_GET["annata"]}");
    if (!$stm->execute())
        echo "Failure!";
    echo "<tr><th>Date</th>";
    $totali = array();
    while ($squadra = $stm->fetch(PDO::FETCH_BOTH)) {
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
                        Squadre.Caposquadra AS Autore,
                        Prestazioni.Squadra_ID AS Squadra,
                        Prestazioni.Punteggio AS Punteggio
                    FROM Giornate
                    JOIN Squadre
                        ON Giornate.Squadra_ID = Squadre.ID
                    JOIN Prestazioni
                        ON Giornate.Data = Prestazioni.Giornata_Data
                    WHERE Squadre.Annata_Anno_inizio = {$_GET["annata"]}
EOT;
                $stm = $dbh->prepare($query);
                if (!$stm->execute())
                    echo "Failure!";
                $data = "";
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
                        while ($gioco = $stm2->fetch(PDO::FETCH_BOTH)["Gioco_Nome"]) {
                            echo "<li>$gioco</li>";
                            $empty_list = false;
                        }
                        if ($empty_list)
                            echo "nessuno";
                        echo "</ul><hr>{$record["Note"]}</div><tr><td>"
                             . "<button class=\"giornata_pulsante_info ui-button ui-corner-all ui-widget\" value=\"$data\">"
                             . date_format(date_create($data), "d/m")
                             . "</button></td>";
                    }
                    $totali[$record["Squadra"]] += $record["Punteggio"];
                    echo "<td class=\"right-align\">(+{$record["Punteggio"]})<br>{$totali[$record["Squadra"]]}</td>";
                }
            ?>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
    $(".info_giornata").dialog({
        autoOpen: false,
        hide: "puff",
        modal: true,
        show: "puff"
    });
    $(document).off('click', ".giornata_pulsante_info").on('click', ".giornata_pulsante_info", function () {
        $(".info_giornata." + $(this).val()).dialog("open");
    });
</script>