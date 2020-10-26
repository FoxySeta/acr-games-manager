<?php
    // infinityfree.net
    define("DSN", "mysql:dbname=epiz_24328203_san_francesco_di_paola_lugo;host=sql311.epizy.com;charset=utf8");
    define("UTENTE", "epiz_24328203");
    define("PASSWORD", "KCqvCEyApmu");
    // freemysqlhosting.net
    //define("DSN", "mysql:dbname=sql7302367;host=sql7.freemysqlhosting.net;charset=utf8");
    //define("UTENTE", "sql7302367");
    //define("PASSWORD", "IyZLPDVZqT");
    try {
        $dbh = new PDO(DSN, UTENTE, PASSWORD);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        echo <<< EOT
            <script type="text/javascript">
                alert("Connessione fallita: $message");
            </script>
EOT;
    }
?>