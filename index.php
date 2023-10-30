<head>
    <link rel="icon" href="icons/favicon.ico">
    <link rel="shortcut icon" href="icons/favicon.ico">
</head>

<?php
$user = $_POST['user'];
$pass = $_POST['pass'];

if (
    $user == "discoverer"
    && $pass == "DepotWynn123123"
) {
    session_start();
    $_SESSION["nID"] = session_id();
    include("./php/main.php");
} else {
    if (isset($_POST)) { ?>
        <form id="login" name="login" method="POST" action="index.php">
            User <input id="user" name="user" type="text"></input><br />
            Pass <input id="pass" type="password" name="pass"></input><br />
            <input type="submit" name="submit" value="Go"></input>
        </form>
        <?php
    }
}
?>