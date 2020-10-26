// Helpers
function get_games_edit(date) {
    var res = [];
    $(".edit_giornata." + date + " [name=giochi] :selected").each(function () {
        res.push($(this).val());
    });
    return res;
}

function get_scores_edit(date) {
    var res0 = [];
    $(".edit_giornata." + date + " [name=squadra]").each(function () {
        res0.push($(this).val());
    });
    var res1 = [];
    $(".edit_giornata." + date + " [name=punteggio]").each(function () {
        res1.push($(this).val());
    });
    var res = [];
    for (var i = 0; i < res0.length; ++i)
        res.push([res0[i], res1[i]]);
    return res;
}

function get_games_new() {
    var res = [];
    $("#day-new-dialog #day-new-games :selected").each(function () {
        res.push($(this).val());
    });
    return res;
}

function get_scores_new() {
    var res0 = [];
    $("#day-new-dialog [name=squadra]").each(function () {
        res0.push($(this).val());
    });
    var res1 = [];
    $("#day-new-dialog [name=punteggio]").each(function () {
        res1.push($(this).val());
    });
    var res = [];
    for (var i = 0; i < res0.length; ++i)
        res.push([res0[i], res1[i]]);
    return res;
}

function page_refresh(message) {
    alert(message);
    location.reload();
}

// when the doc is ready

$(document).ready(function () {
    // Dialogues
    $(".info_giornata,.edit_giornata,.delete_giornata").dialog({
        autoOpen: false,
        hide: "puff",
        modal: true,
        show: "puff"
    });

    // Info
    $(document).off('click', ".giornata_pulsante_info").on('click', ".giornata_pulsante_info", function () {
        $(".info_giornata." + $(this).val()).dialog("open");
    });

    // Edit
    $(document).off('click', ".giornata_pulsante_edit").on('click', ".giornata_pulsante_edit", function () {
        $(".edit_giornata." + $(this).val()).dialog("open");
    });

    $(document).off('click', ".edit_giornata .salva").on('click', ".edit_giornata .salva", function () {
        $.ajax({
            type: "POST",
            url: "/scripts/php/gestione/day-edit.php",
            data: {
                date_old: $(this).val(),
                date_new: $(".edit_giornata." + $(this).val() + " input[name=data]").val(),
                games: JSON.stringify(get_games_edit($(this).val())),
                scores: JSON.stringify(get_scores_edit($(this).val())),
                notes: $(".edit_giornata." + $(this).val() + " [name=note]").val()
            },
            success: function (response) {
                page_refresh(response);
            },
            error: function (response) {
                alert("Modifica fallita. (day-edit.php)");
            }
        });
    });

    // Delete
    $(document).off('click', ".giornata_pulsante_delete").on('click', ".giornata_pulsante_delete", function () {
        $(".delete_giornata." + $(this).val()).dialog("open");
    });

    $(document).off('click', ".delete_giornata .elimina").on('click', ".delete_giornata .elimina", function () {
        $.ajax({
            type: "POST",
            url: "/scripts/php/gestione/day-delete.php",
            data: {
                date: $(this).val()
            },
            success: function (response) {
                page_refresh(response);
            },
            error: function (response) {
                alert("Modifica fallita. (day-delete.php)");
            }
        });
    });

    // New
    $("#day-new-button").button({
        icon: "ui-icon-plusthick"
    });
    $("#day-new-dialog").dialog({
        autoOpen: false,
        buttons: [{
            text: "Salva",
            icon: "ui-icon-disk",
            click: function () {
                $.ajax({
                    type: "POST",
                    url: "/scripts/php/gestione/day-new.php",
                    data: {
                        date: $("#day-new-date").val(),
                        games: JSON.stringify(get_games_new()),
                        scores: JSON.stringify(get_scores_new()),
                        notes: $("#day-new-notes").val()
                    },
                    success: function (response) {
                        $("#day-new-dialog").dialog("close");
                        page_refresh(response);
                    },
                    error: function (response) {
                        alert("Modifica fallita. (day-new.php)");
                    }
                });
            }
        }],
        hide: "puff",
        modal: true,
        show: "puff"
    });
    $(document).off('click', "#day-new-button").on('click', "#day-new-button", function () {
        $("#day-new-dialog").dialog("open");
    });
});