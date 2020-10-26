<?php
    session_start();
    require_once "scripts/php/configuration.php";
    $stm = $dbh->prepare("SELECT Tema_nome FROM Annate WHERE Anno_inizio = {$_GET["annata"]}");
    if (!$stm->execute())
        echo "Failure!";
    $tema = $stm->fetch(PDO::FETCH_BOTH)["Tema_nome"];
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title data-rh="true">
        <?php echo $_GET["annata"] . "/" . ($_GET["annata"] + 1); ?> | Giochi A.C.R.
    </title>
    <!-- Meta -->
    <meta content="text/html; charset=utf-8" http-equiv="content-type" />
    <meta content="Da qui puoi ." name="description" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta property="og:title" content="<?php echo $_GET["annata"] . "/" . ($_GET["annata"] + 1); ?> | Giochi A.C.R." />
    <meta property="og:description" content="Da cui puoi controllare i risultati delle varie squadre." />
    <meta property="og:url" content="http://giochi-acr-sanfrancescodipaolalugo.rf.gd/consultazione.php?annata=<?php echo $_GET["annata"]; ?>" />
    <meta property="og:image" content="http://giochi-acr-sanfrancescodipaolalugo.rf.gd/img/favicons/128.png" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="it_IT" />
    <!-- Favicon -->
    <link href="img/favicons/16.png" rel="shortcut icon" type="image/png" sizes="16x16" />
    <link href="img/favicons/32.png" rel="shortcut icon" type="image/png" sizes="32x32" />
    <link href="img/favicons/64.png" rel="shortcut icon" type="image/png" sizes="64x64" />
    <link href="img/favicons/128.png" rel="shortcut icon" type="image/png" sizes="128x128" />
    <!-- Libraries: jQuery 3.4.1 - minified (jQuery CDN) -->
    <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        window.jQuery || document.write('<script type="text/javascript" src="scripts/js/lib/jquery-3.4.1.min.js"><\/script>');
    </script>
    <!-- Libraries: jQuery UI 1.12.1 - smoothness theme (jQuery CDN, no fallback to local stylesheet!) -->
    <link href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        window.jQuery || document.write('<script type="text/javascript" src="scripts/js/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js"><\/script>');
    </script>
    <!-- Default style sheets-->
    <link href="style/fonts.css" rel="stylesheet" type="text/css" />
    <link href="style/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    include "scripts/php/consultazione/header.php";
    include "scripts/php/consultazione/nav.php";
    include "scripts/php/consultazione/main.php";
    include "scripts/php/footer.php";
    ?>
</body>

</html>