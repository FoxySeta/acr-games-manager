<table class="report">
    <thead>
        <tr>
            <th>
                Nome
            </th>
            <th>
                Azioni
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            session_start();
            require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/php/configuration.php";
            $stm = $dbh->prepare("SELECT Giochi.Nome AS Gioco, Giochi.Indoor AS Indoor, Giochi.Note AS Note, Squadre.ID AS Squadra, Squadre.Caposquadra AS Autore FROM Giochi LEFT JOIN Squadre ON Giochi.Squadra_ID = Squadre.ID ORDER BY Giochi.Nome");
            if (!$stm->execute())
                echo "Failure!";
            while ($gioco = $stm->fetch(PDO::FETCH_BOTH)) {
                $gioco["Indoor"] = $gioco["Indoor"] ? "al chiuso" : "all'aperto";
                echo <<< EOT
                    <tr>
                        <td>
                            {$gioco["Gioco"]}
                        </td>
                        <td class="center-align">
                            <button class="game-info-button" value="{$gioco["Gioco"]}"></button>
                            <div class="game-info-dialog {$gioco["Gioco"]}" title="Info su {$gioco["Gioco"]}">
                                Proposto da: {$gioco["Autore"]}<br>
                                Da fare: {$gioco["Indoor"]}<hr>
                                {$gioco["Note"]}
                            </div>
                        </td>
                    </tr>
EOT;
            }
        ?>
        <script>
            $(".game-info-button").button({
                icon: "ui-icon-info"
            });
            $(".game-info-dialog").dialog({
                autoOpen: false,
                hide: "puff",
                modal: true,
                show: "puff"
            });
            $(document).off('click', ".game-info-button").on('click', ".game-info-button", function () {
                $(".game-info-dialog" + "." + $(this).attr("value")).dialog("open");
            });
        </script>
    </tbody>
    <tfooter>
        <tr>
            <th colspan="2">
                Altri giochi presto in arrivo!
            </th>
        </tr>
    </tfooter>
</table>