<nav>
    <?php
        require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/php/configuration.php";
        $stm = $dbh->prepare("SELECT Anno_inizio FROM Annate ORDER BY Anno_inizio ASC");
        if (!$stm->execute())
            echo "Failure!";
        $anni_inizio = array();
        while ($rows = $stm->fetch(PDO::FETCH_BOTH))
            array_push($anni_inizio, $rows[0]);
        if (!in_array($_GET["annata"], $anni_inizio))
            header("location: ../../../404.php");
        // Anno precedente
        $link = $_GET["annata"] - 1;
        if (in_array($link, $anni_inizio)) {
            $linkPlus1 = $link + 1;
            echo <<< EOT
                <a href="consultazione.php?annata=$link" hreflang="it" type="text/html">
                    <button class="ui-button-text-icon-primary">
                        <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-w"></span>
                        <span class="ui-button-text">$link/$linkPlus1</span>
                    </button>
                </a>
EOT;
        }
        echo $_GET["annata"] . "/" . ($_GET["annata"] + 1);
        // Anno successivo
        $link = $_GET["annata"] + 1;
        if (in_array($link, $anni_inizio)) {
            $linkPlus1 = $link + 1;
            echo <<< EOT
                <a href="consultazione.php?annata=$link" hreflang="it" type="text/html">
                    <button class="ui-button-text-icon-primary">
                        <span class="ui-button-text">$link/$linkPlus1</span>
                        <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-e"></span>
                    </button>
                </a>
EOT;
        }
    ?>
</nav>