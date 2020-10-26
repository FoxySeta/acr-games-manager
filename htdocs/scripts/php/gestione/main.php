<main>
    <div id="accordion">
        <h3><span class="ui-icon ui-icon-calendar"></span>Risultati</h3>
            <div id="risultati">
                <?php
                include "risultati.php";
                ?>
            </div>
        <h3><span class="ui-icon ui-icon-heart"></span>Giochi</h3>
            <div id="giochi">
                <?php
                include "giochi.php";
                ?>
            </div>
    </div>
    <script>
        $(function() {
            $("#accordion").accordion({
                active: false,
                collapsible: true,
                heightStyle: "fill"
            });
        });
    </script>
</main>