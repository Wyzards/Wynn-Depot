<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

if (!isset($_SESSION['nID'])) {
    header("Location: ../index.php");
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/styles.css">
    <script type="text/javascript" src="../scripts/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="../scripts/javascript.js"></script>
    <title>WynnDepot Website</title>
</head>

<body class="theme">
    <div id="myModal" class="modal">
        <img id="modal-image" class="modal-content" src="" />
    </div>

    <div id="content">
        <h1>WynnDepot.</h1>
        <div class="topnav">
            <input id="searchbar" type="text" onkeyup="applySearchFilter()" placeholder="Search for items...">
            <select id="misc-filter" class="filter" multiple onchange="applySearchFilter()">
                <option value="owned">Owned</option>
                <option value="not-owned">Not Owned</option>
                <option value="untradable">Untradeable</option>
                <option value="quest">Quest Item</option>
            </select>
            <select id="type-filter" class="filter" multiple onchange="applySearchFilter()">
                <option value="helmet">Helmets</option>
                <option value="chestplate">Chestplates</option>
                <option value="leggings">Leggings</option>
                <option value="boots">Boots</option>
                <option value="spear">Spears</option>
                <option value="wand">Wands</option>
                <option value="relik">Reliks</option>
                <option value="bow">Bows</option>
                <option value="dagger">Daggers</option>
                <option value="necklace">Necklaces</option>
                <option value="bracelet">Bracelets</option>
                <option value="ring">Rings</option>
            </select>
            <select id="rarity-filter" class="filter" multiple onchange="applySearchFilter()">
                <option value="mythic">Mythic</option>
                <option value="fabled">Fabled</option>
                <option value="legendary">Legendary</option>
                <option value="rare">Rare</option>
                <option value="unique">Unique</option>
                <option value="set">Set</option>
                <option value="normal">Normal</option>
            </select>
            <select id="level-filter" class="filter" multiple onchange="applySearchFilter()">
                <option value="1-10">Lvl. 1-10</option>
                <option value="11-20">Lvl. 11-20</option>
                <option value="21-30">Lvl. 21-30</option>
                <option value="31-40">Lvl. 31-40</option>
                <option value="41-50">Lvl. 41-50</option>
                <option value="51-60">Lvl. 51-60</option>
                <option value="61-70">Lvl. 61-70</option>
                <option value="71-80">Lvl. 71-80</option>
                <option value="81-90">Lvl. 81-90</option>
                <option value="91-200">Lvl. 91-100+</option>
            </select>
            <button type="button" id="refreshapi">Refresh API</button>
        </div>
        <br>

        <table id="my-table">
            <tr>
                <th>Item Name</th>
                <th hidden>Data</th>
                <th>Lvl</th>
                <th>Account Name</th>
                <th>Percent</th>
                <th>Image</th>
            </tr>

            <?php
            function get_identification_range($id_base_value): string
            {
                $min_value = $id_base_value;
                $max_value = $id_base_value;

                if ($id_base_value > 0) {
                    $min_value = max(1, round($id_base_value * 0.3));
                    $max_value = max(1, round($id_base_value * 1.3));
                }
                if ($id_base_value < 0) {
                    $min_value = min(-1, round($id_base_value * 1.3));
                    $max_value = min(-1, round($id_base_value * 0.7));
                }

                return $min_value . "-" . $max_value;
            }

            function prep_item_data($json_string)
            {
                $keypairs = array();
                $identifications = array("healthRegen", "manaRegen", "spellDamage", "damageBonus", "lifeSteal", "manaSteal", "xpBonus", "lootBonus", "reflection", "thorns", "exploding", "speed", "attackSpeedBonus", "poison", "healthBonus", "soulPoints", "emeraldStealing", "healthRegenRaw", "spellDamageRaw", "damageBonusRaw", "bonusFireDamage", "bonusWaterDamage", "bonusAirDamage", "bonusThunderDamage", "bonusEarthDamage", "bonusFireDefense", "bonusWaterDefense", "bonusAirDefense", "bonusThunderDefense", "bonusEarthDefense");
                $json = json_decode($json_string, true);

                foreach ($json as $key => $value) {
                    if ($value == 0 || $value == "0-0")
                        unset($json[$key]);

                    if (isset($json[$key])) {
                        if (in_array($key, $identifications))
                            $json[$key] = get_identification_range($value);

                        array_push($keypairs, $key . ": " . str_replace("\"", "", json_encode($json[$key])));
                    }
                }

                return implode("<br>", $keypairs);
            }

            foreach (Database::getInstance()->get_table_data() as $table_row):
                $json_data = json_decode($table_row["data"], true);
                ?>
                <tr>
                    <td>
                        <?= "<p data-tier='" . $json_data["tier"] . "'>" . htmlspecialchars($table_row["name"]) . "</p>" ?>
                    </td>

                    <td hidden>
                        <?= prep_item_data($table_row["data"]); ?>
                    </td>

                    <td>
                        <?= $json_data["level"] ?>
                    </td>

                    <td>
                        <?php
                        echo strtr("<p data-item-name='@item-name' contenteditable='true' oninput='setAccountName(this)'>@account-name</p>", ["@item-name" => htmlspecialchars($table_row["name"]), "@account-name" => htmlspecialchars($table_row["account_name"])]);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo strtr("<p data-item-name='@item-name' contenteditable='true' oninput='setPercent(this)'>@percent</p>", ["@item-name" => htmlspecialchars($table_row["name"]), "@percent" => htmlspecialchars($table_row["percent"])]);
                        ?>
                    </td>
                    <td>
                        <?php
                        $item_name = htmlspecialchars($table_row["name"]);
                        $item_id = str_replace(" ", "", strtolower($item_name));
                        $file_path = htmlspecialchars($table_row["file_path"]);

                        // If no image...
                        if ($file_path === "") {
                            echo strtr('<button style="display:none" class="show-image" data-item-id="@item-id" onClick="showImage(\'@item-id\')">Show Image</button>', ["@item-id" => $item_id]);
                            echo strtr('<input data-item-id="@item-id" data-item-name="@item-name" type="file" onchange="uploadImage(this)"/>', ["@item-id" => $item_id, "@item-name" => $item_name]);
                            echo strtr('<button style="display:none" class="remove-image" data-item-id="@item-id" data-item-name="@item-name" onclick="removeItemImage(this)">Remove Image</button>', ["@item-id" => $item_id, "@item-name" => $item_name]);
                        }
                        // If image
                        else {
                            echo strtr('<button style="display:\'\'" class="show-image" data-item-id="@item-id" onClick="showImage(\'@item-id\')">Show Image</button>', ["@item-id" => $item_id]);
                            echo strtr('<input style="display:none" data-item-id="@item-id" data-item-name="@item-name" type="file" onchange="uploadImage(this)"/>', ["@item-id" => $item_id, "@item-name" => $item_name]);
                            echo strtr('<button class="remove-image" data-item-id="@item-id" data-item-name="@item-name" onclick="removeItemImage(this)">Remove Image</button>', ["@item-id" => $item_id, "@item-name" => $item_name]);
                        }

                        echo strtr('<img style="display:none" class="item-image" data-item-id="@item-id" src="@image-path" />', ["@item-id" => $item_id, "@image-path" => $file_path]);
                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>

</html>