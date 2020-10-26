<nav>
    <ul id="menu">
        <li>
            <div><span class="ui-icon ui-icon-extlink"></span>Link utili</div>
            <ul>
                <li>
                    <div><span class="ui-icon ui-icon-extlink"></span><a href="http://www.sanfrancescodipaolalugo.it/" hreflang="it" rel="external" target="_blank" type="text/html">La nostra parrocchia</a></div>
                </li>
                <li>
                    <div><span class="ui-icon ui-icon-extlink"></span><a href="https://acr.azionecattolica.it/" hreflang="it" rel="external" target="_blank" type="text/html">Azione
                            Cattolica Ragazzi</a></div>
                </li>
            </ul>
        </li>
        <li>
            <div><span class="ui-icon ui-icon-info"></span>Contatti</div>
            <ul>
                <li>
                    <div><a id="map-link">
                            <span class=" ui-icon ui-icon-home"></span>Indirizzo
                        </a></div>
                    <div id="map" title="Dove siamo" class="ui-dialog-content ui-widget-content">
                        <p><span class=" ui-icon ui-icon-home"></span>Via Giulio Fermini Mancini, 37, 48022 Lugo RA
                        </p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d423.6352460627377!2d11.907145980999886!3d44.41537734701587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477e032a89e64229%3A0x78c2ea280e1f5fb7!2sChiesa+Cattolica+Parrocchiale+S.+Francesco+Di+Paola!5e0!3m2!1sen!2sit!4v1566052694448!5m2!1sen!2sit" frameborder="0" allowfullscreen></iframe>
                    </div>
                </li>
                <li>
                    <div><a id="hours-link"><span class=" ui-icon ui-icon-clock"></span>Orari</a></div>
                    <div id="hours" title="Orari" class="ui-dialog-content ui-widget-content">
                        <p><span class=" ui-icon ui-icon-clock"></span>Sabato, ore 14:30 - 16:00
                        </p>
                    </div>
                </li>
                <li>
                    <div><span class=" ui-icon ui-icon-mail-closed"></span><a href="mailto:volpe80stefano@gmail.com?subject=Portale%20Giochi%20ACR" rel="external">Email</a></div>
                </li>
            </ul>
        </li>
    </ul>
    <script type="text/javascript">
        $("#menu").menu({
            icons: {
                submenu: "ui-icon-caret-1-s"
            },
            position: {
                my: "left top",
                at: "left bottom"
            }
        });

        $("#map").dialog({
            autoOpen: false,
            resizable: false,
            hide: "puff",
            show: "puff",
            width: 350,
            height: 300
        });

        $("#map-link").click(function(event) {
            $("#map").dialog("open");
            event.preventDefault();
        });

        $("#hours").dialog({
            autoOpen: false,
            resizable: false,
            hide: "puff",
            show: "puff",
            width: 300,
            height: 150

        });

        $("#hours-link").click(function(event) {
            $("#hours").dialog("open");
            event.preventDefault();
        });
    </script>
</nav>