// Refreshers
function accordion_refresh() {
    $.ajax({
        type: "POST",
        url: "/scripts/php/gestione/accordion.php",
        success: function (response) {
            $("main").off('click', "**").html(response);
        },
        error: function (response) {
            alert("Aggiornamento fallito. (accordion.php)");
        }
    });
}

function page_refresh(message) {
    alert(message);
    location.reload();
}

$(document).ready(function () {
    // Info
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
    // Edit
    $(".game-edit-button").button({
        icon: "ui-icon-pencil"
    });
    $(".game-edit-dialog").dialog({
        autoOpen: false,
        hide: "puff",
        modal: true,
        show: "puff"
    });
    $(".game-edit-save").button({
        icon: "ui-icon-disk",
        label: "Salva"
    });
    $(document).off('click', ".game-edit-save").on('click', ".game-edit-save", function () {
        $.ajax({
            type: "POST",
            url: "/scripts/php/gestione/game-edit.php",
            data: {
                Nome_vecchio: $(".game-edit-Nome_vecchio." + $(this).attr("value")).val().replace(/ /g, "_"),
                Nome: $(".game-edit-Nome." + $(this).attr("value")).val(),
                Indoor: $(".game-edit-Indoor." + $(this).attr("value") + " option:selected").val(),
                Note: $(".game-edit-Note." + $(this).attr("value")).val()
            },
            success: function (response) {
                $(".game-edit-dialog." + $(this).attr("value")).dialog("close");
                page_refresh(response);
            },
            error: function (response) {
                alert("Modifica fallita. (game-edit.php)");
            }
        });
    });
    $(document).off('click', ".game-edit-button").on('click', ".game-edit-button", function () {
        $(".game-edit-dialog." + $(this).attr("value")).dialog("open");
    });
    // Delete
    $(".game-delete-button").button({
        icon: "ui-icon-trash"
    });
    $(".game-delete-dialog").dialog({
        autoOpen: false,
        hide: "puff",
        modal: true,
        show: "puff"
    });
    $(".game-delete-save").button({
        icon: "ui-icon-trash",
        label: "Elimina"
    });
    $(document).off('click', ".game-delete-save").on('click', ".game-delete-save", function () {
        $.ajax({
            type: "POST",
            url: "/scripts/php/gestione/game-delete.php",
            data: {
                Nome: $(this).attr("value")
            },
            success: function (response) {
                $(".game-delete-dialog").dialog("close");
                page_refresh(response);
            },
            error: function (response) {
                alert("Modifica fallita. (game-delete.php)");
            }
        });
    });
    $(document).off('click', ".game-delete-button").on('click', ".game-delete-button", function () {
        $(".game-delete-dialog." + $(this).attr("value")).dialog("open");
    });
    // New
    $("#game-new-button").button({
        icon: "ui-icon-plusthick"
    });
    $("#game-new-dialog").dialog({
        autoOpen: false,
        buttons: [{
            text: "Salva",
            icon: "ui-icon-disk",
            click: function () {
                $.ajax({
                    type: "POST",
                    url: "/scripts/php/gestione/game-new.php",
                    data: {
                        Nome: $("#game-new-Nome").val().replace(/ /g, "_"),
                        Indoor: $("#game-new-Indoor option:selected").val(),
                        Note: $("#game-new-Note").val()
                    },
                    success: function (response) {
                        $("#game-new-dialog").dialog("close");
                        page_refresh(response);
                    },
                    error: function (response) {
                        alert("Modifica fallita. (game-new.php)");
                    }
                });
            }
        }],
        hide: "puff",
        modal: true,
        show: "puff"
    });
    $(document).off('click', "#game-new-button").on('click', "#game-new-button", function () {
        $("#game-new-dialog").dialog("open");
    });
});