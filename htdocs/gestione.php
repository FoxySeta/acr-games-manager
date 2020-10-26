<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: index.php");
        exit;
    }
    require_once "scripts/php/configuration.php";
    $stm = $dbh->prepare("SELECT Nome, Caposquadra, Colore FROM Squadre WHERE ID = {$_SESSION["ID"]}");
    if (!$stm->execute())
        echo "Failure!";
    $squadra = $stm->fetch(PDO::FETCH_BOTH);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title data-rh="true">
        <?php echo $squadra["Nome"]; ?> | Giochi A.C.R.
    </title>
    <!-- Meta -->
    <meta content="text/html; charset=utf-8" http-equiv="content-type" />
    <meta content="La home del portale." name="description" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta property="og:title" content="<?php echo $squadra["Nome"]; ?> | Giochi A.C.R." />
    <meta property="og:description" content="Da qui gestisci la tua squadra." />
    <meta property="og:url" content="http://giochi-acr-sanfrancescodipaolalugo.rf.gd/gestione.php" />
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
    <link href="style/custom/<?php echo $squadra["Colore"]; ?>.css" rel="stylesheet" type="text/css" />
    <link href="style/fonts.css" rel="stylesheet" type="text/css" />
    <link href="style/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    include "scripts/php/gestione/header.php";
    include "scripts/php/gestione/nav.php";
    include "scripts/php/gestione/main.php";
    include "scripts/php/footer.php";
    ?>
</body>

</html>