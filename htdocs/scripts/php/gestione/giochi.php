<script src="/scripts/js/gestione/giochi.js" type="text/javascript"></script>

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
EOT;
                if ($gioco["Squadra"] == $_SESSION["ID"]) {
                    echo <<< EOT
                        <button class="game-edit-button" value="{$gioco["Gioco"]}"></button>
                        <div class="game-edit-dialog {$gioco["Gioco"]}" title="Modifica {$gioco["Gioco"]}">
                            <input type="hidden" class="game-edit-Nome_vecchio {$gioco["Gioco"]}" name="Nome_vecchio" value="{$gioco["Gioco"]}" />
                            <input type="text" class="game-edit-Nome {$gioco["Gioco"]}" name="Nome" placeholder="Nome" value="{$gioco["Gioco"]}" maxlength="30" /><br>
                            Proposto da: {$gioco["Autore"]}<br>
                            Da fare:
                            <select class="game-edit-Indoor {$gioco["Gioco"]}">
                                <option value="0"
EOT;
                    if ($gioco["Indoor"] == "all'aperto")
                        echo " selected";
                    echo <<< EOT
                                >all'aperto</option>
                                <option value="1"
EOT;
                    if ($gioco["Indoor"] == "al chiuso")
                        echo " selected";
                    echo <<< EOT
                                >al chiuso</option>
                            </select><hr>
                            <textarea maxlength="5000" class="game-edit-Note {$gioco["Gioco"]}" placeholder="Note a piacere (massimo 5000 caratteri)">{$gioco["Note"]}</textarea><br>
                            <button class="game-edit-save" value="{$gioco["Gioco"]}"></button>
                        </div>
                        <button class="game-delete-button" value="{$gioco["Gioco"]}"></button>
                        <div class="game-delete-dialog {$gioco["Gioco"]}" title="Elimina {$gioco["Gioco"]}">
                            Eliminare il gioco <b>{$gioco["Gioco"]}</b>?<br>
                            <input type="hidden" class="game-delete-Nome {$gioco["Gioco"]}" value="{$gioco["Gioco"]}" />
                            <button class="game-delete-save" value="{$gioco["Gioco"]}"></button>
                        </div>
EOT;
                }
                echo <<< EOT
                        </td>
                    </tr>
EOT;
            }
        ?>
    </tbody>
    <tfooter>
        <tr>
            <th colspan="2">
                <button id="game-new-button"></button>
                <div id="game-new-dialog" title="Crea nuovo gioco">
                    <input type="text" id="game-new-Nome" name="Nome" placeholder="Nome" maxlength="30" /><br>
                    Da fare:
                    <select id="game-new-Indoor">
                        <option value="0" selected>all'aperto</option>
                        <option value="1">al chiuso</option>
                    </select><hr>
                    <textarea maxlength="5000" id="game-new-Note" placeholder="Note a piacere (massimo 5000 caratteri)"></textarea><br>
                </div>
            </th>
        </tr>
    </tfooter>
</table>