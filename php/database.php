<?php

class Database
{

    private static $instance = null;
    private $sql;

    public function __construct()
    {
        $this->sql = mysqli_connect("localhost", "app_user", "Password123!", "wynn_depot");
        $this->sql->query("CREATE TABLE IF NOT EXISTS items (name varchar(255) NOT NULL, data JSON, account_name VARCHAR(24), percent DECIMAL(5,2), file_path VARCHAR(255), PRIMARY KEY (name))");
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new Database();

        return self::$instance;
    }

    public function get_table_data(): array
    {
        $table_query = $this->sql->query("SELECT name,data,account_name,percent,file_path FROM items");

        return $table_query->fetch_all(MYSQLI_ASSOC);
    }

    public function refresh_item(string $item_name, string $item_data): void
    {
        $statement = $this->sql->prepare("INSERT INTO items (name, data) VALUES (?, ?) ON DUPLICATE KEY UPDATE data=?;");
        $statement->bind_param("sss", $item_name, $item_data, $item_data);
        $statement->execute();
    }

    public function remove_image(string $item_name): void
    {
        $statement = $this->sql->prepare("UPDATE items SET file_path = NULL WHERE name LIKE ?");
        $statement->bind_param("s", $item_name);
        $statement->execute();
    }

    public function set_items_account(string $account_name, string $item_name): void
    {
        $statement = $this->sql->prepare("UPDATE items SET account_name = ? WHERE name LIKE ?");
        $statement->bind_param("ss", $account_name, $item_name);
        $statement->execute();
    }

    public function set_item_percent(string $item_name, string $item_percent): void
    {

        if ($item_percent != "") {
            $statement = $this->sql->prepare("UPDATE items SET percent = ? WHERE name LIKE ?");
            $statement->bind_param("ds", $_POST["percent"], $_POST["name"]);
        } else {
            $statement = $this->sql->prepare("UPDATE items SET percent = NULL WHERE name LIKE ?");
            $statement->bind_param("s", $_POST["name"]);
        }

        $statement->execute();
    }

    public function set_image(string $item_name, string $file_name, string $tmp_name)
    {
        $image_path = "../images/" . $file_name;

        if (move_uploaded_file($tmp_name, $image_path)) {
            $statement = $this->sql->prepare("UPDATE items SET file_path = ? WHERE name LIKE ?");
            $statement->bind_param("ss", $image_path, $item_name);
            $statement->execute();

            echo "Success";
        } else {
            echo "Failure";
        }
    }
}

?>