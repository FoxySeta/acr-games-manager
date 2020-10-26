<nav>
    <!-- Password change -->
    <button id="password-change-button" class="ui-button-text-icon-primary">
        <span class="ui-button-icon-primary ui-icon ui-icon-key"></span>
        <span class="ui-button-text">Cambia password</span>
    </button>
    <div id="password-change-dialog" title="Cambia password">
        <p>
            <label>
                <span class="ui-button-icon-primary ui-icon ui-icon-key"></span>
                Nuova password
            </label>
            <input type="password" id="new-password">
        </p>
        <p>
            <label>
                <span class="ui-button-icon-primary ui-icon ui-icon-key"></span>
                Conferma nuova password
            </label>
            <input type="password" id="new-password-2">
        </p>
    </div>
    <script>
        $("#password-change-dialog").dialog({
            autoOpen: false,
            buttons: [{
                text: "Ok",
                icon: "ui-icon-check",
                click: function() {
                    $("#new-password").val($("#new-password").val().trim());
                    $("#new-password-2").val($("#new-password-2").val().trim());
                    if ($("#new-password").val() == $("#new-password-2").val())
                        if ($("#new-password").val().length >= 8)
                            $.ajax({
                                type: "POST",
                                url: "/scripts/php/gestione/cambia_password.php",
                                data: {
                                    password: $("#new-password").val()
                                },
                                success: function(response) {
                                    alert(response);
                                    if (response == "Password modificata correttamente.")
                                        $("#password-change-dialog").dialog("close");
                                },
                                error: function(response) {
                                    alert("Modifica fallita. Contatta il supporto.");
                                }
                            });
                        else
                            alert("Le password non predefinite devono avere almeno 8 caratteri.");
                    else
                        alert("Le due password non sono uguali!");
                }
            }],
            hide: "puff",
            modal:false,
            resizable: false,
            show: "puff"
        });
        $(document).off('click', "#password-change-button").on('click', "#password-change-button", function() {
            $("#password-change-dialog").dialog("open");
        });
    </script>
    <!-- Logout -->
    <a href="scripts/php/logout.php" hreflang="it" type="text/html">
        <button class="ui-button-text-icon-primary">
            <span class="ui-button-icon-primary ui-icon ui-icon-locked"></span>
            <span class="ui-button-text">Logout</span>
        </button>
    </a>
</nav>