<?php ?>  

<h3>Load XML Data.xml</h3>
<?php
//echo '<pre>';
//print_r((array)$xml["widgetTypes"]);
//
//echo '</pre>';
if ($xml) {
    if (array_key_exists("WidgetTypes", $xml)) {
        if ($xml["WidgetTypes"]) {
            ?>
            <h4>Widget Types</h4>
            <?php
            $Wtypes = $xml["WidgetTypes"];
            foreach ($Wtypes as $wtype) {
                echo $wtype["tech_name"] . '<br>';
            }
        }
    }
    if (array_key_exists("Widgets", $xml)) {
        if ($xml["Widgets"]) {
            ?>
            <h4>Widgets</h4>
            <?php
            $Widgets = $xml["Widgets"];
            foreach ($Widgets as $Widget) {
                echo $Widget["widget_type"] . ' - ' . $Widget["name"] . '<br>';
            }
        }
    }

    if (array_key_exists("Positions", $xml)) {
        if ($xml["Positions"]) {
            ?>
            <h4>Positions</h4>
            <?php
            $Positions = $xml["Positions"];
            foreach ($Positions as $Position) {
                echo $Position["tech_name"] . ' - ' . $Position["name"] . '<br>';
            }
        }
    }

    if (array_key_exists("Menu", $xml)) {
        ?>
        <h4>Menus</h4>
        <?php
        $Menu = $xml["Menu"];
        foreach ($Menu as $Item) {
            echo $Item["id"] . ' - ' .
            $Item["name"] . ' - ' .
            $Item["route"] . ' - ' .
            $Item["data"] . ' - ' .
            $Item["app"] . ' - ' .
            $Item["parent_id"] . ' - ' .
            $Item["depth"] .
            '<br>';
        }
    }

    if (array_key_exists("Layouts", $xml)) {
        if ($xml["Layouts"]) {
            ?>
            <h4>Layouts</h4>
            <?php
            $Layouts = $xml["Layouts"];
            foreach ($Layouts as $Layouts) {
                echo $Layouts["tech_name"] . ' - ' . $Layouts["name"] . '<br>';
            }
        }
    }
}