<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$database = Database::getInstance();

switch ($_POST["FUNCTION"]) {
    case "REFRESH_API":
        $json = file_get_contents("https://api.wynncraft.com/public_api.php?action=itemDB&category=all");
        $obj = json_decode($json);
        $items = $obj->items;

        header("Content-Type: application/json; charset=utf-8");

        foreach ($items as $item)
            $database->refresh_item($item->name, json_encode($item));

        break;
    case "UPLOAD_IMAGE":
        $database->set_image($_POST["name"], $_FILES["file"]["name"], $_FILES["file"]["tmp_name"]);
        break;
    case "REMOVE_IMAGE":
        $database->remove_image($_POST["itemName"]);
        break;
    case "SET_ACCOUNT":
        $database->set_items_account($_POST["account"], $_POST["name"]);
        break;
    case "SET_PERCENT":
        $database->set_item_percent($_POST["name"], $_POST["percent"]);
        break;
}

?>