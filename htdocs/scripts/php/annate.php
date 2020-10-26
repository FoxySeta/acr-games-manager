<main>
    <div id="annate">
        <?php
        require_once "configuration.php";
        $stm = $dbh->prepare("SELECT Anno_inizio FROM Annate");
        if (!$stm->execute())
            echo "Failure!";
        $anni_inizio = array();
        while ($row = $stm->fetch(PDO::FETCH_BOTH))
            array_push($anni_inizio, $row[0]);
        echo "<ul>";
        foreach ($anni_inizio as $anno_inizio)
            echo "<li><a href=\"#$anno_inizio\"><img src=\"img/annate/{$anno_inizio}_logo.png\" alt=\"$anno_inizio\" title=\"$anno_inizio\" /></a></li>";
        echo "</ul>";
        foreach ($anni_inizio as $anno_inizio) {
            echo <<< EOT
                <div id="$anno_inizio">
                    <img src="img/annate/{$anno_inizio}_bg.png" alt="$anno_inizio" title="$anno_inizio" />
                    <fieldset>
                    <legend>Sono un:</legend>
                        <p>
                            <a href="consultazione.php?annata={$anno_inizio}" hreflang="it" type="text/html">
                                <button class="ui-button-text-icon-primary">
                                    <span class="ui-button-icon-primary ui-icon ui-icon-person"></span>
                                    <span class="ui-button-text">Visitatore</span>
                                </button>
                            </a>
                        </p>
                        <p>
                            <button id="{$anno_inizio}" class="login-button ui-button-text-icon-primary">
                                <span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span>
                                <span class="ui-button-text">Caposquadra</span>
                            </button>
                            <div id="{$anno_inizio}" class="login-dialog" title="Login">
                                <form action="../../index.php" method="post">
                                    <p>
                                        <label for="squadra">Account</label>
                                        <select class="squadra" name="squadra" required>
EOT;
            $stm = $dbh->prepare("SELECT ID, Nome, Caposquadra FROM Squadre WHERE Annata_Anno_Inizio = {$anno_inizio}");
            if (!$stm->execute())
                echo "Failure!";
            while ($row = $stm->fetch(PDO::FETCH_BOTH))
                echo <<< EOT
                    <option label="{$row["Nome"]} ({$row["Caposquadra"]})" value="{$row["ID"]}">{$row["Nome"]} ({$row["Caposquadra"]})
                    </option>
EOT;
            echo <<< EOT
                                        </select>
                                    </p>
                                    <p>
                                        <input type="password" name="password" maxlength="30" placeholder="Password" required />
                                    </p>
                                    <p>
                                        <button type="submit" class="ui-button-text-icon-primary">
                                            <span class="ui-button-icon-primary ui-icon ui-icon-unlocked"></span>
                                            <span class="ui-button-text">Accedi</span>
                                        </button> $password_err
                                    </p>
                                </form>
                            </div>
                        </p>
                    </fieldset>
                </div>
EOT;
        }
        ?>
    </div>
    <script type="text/javascript">
        $("#annate").tabs({
            active: -1,
            heightStyle: "fill",
            hide: {
                effect: "slide",
                direction: "up"
            },
            show: {
                effect: "slide",
                direction: "up"
            }
        });
        $(".login-dialog").dialog({
            autoOpen: false,
            hide: "puff",
            rezisable: false,
            show: "puff"
        });
        $(document).off('click', ".login-button").on('click', ".login-button", function() {
            $("#" + $(this).attr("id") + ".login-dialog").dialog("open");
        });
    </script>
</main>