<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// parametri di connessione a mysql
$username = $_ENV["USER"];
$password = $_ENV["PASSWORD"];
$host = "mysql:host=" . $_ENV["HOST"] . ";dbname=" . $_ENV["DATABASE"];

$options = [
    PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
];

try {
    $pdo = new PDO($host, $username, $password, $options);
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Something weird happened ' . $e->getMessage()); //something a user can understand
}

$stmt = $pdo->prepare("SELECT * FROM contatto");
$stmt->execute();
//echo $stmt->rowCount();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $arr[] = $row;
}


//var_dump($arr);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Rubrica Contatti Personali</title>
</head>
<body>
<h1>Rubrica Contatti Personali</h1>

<table border="1">
    <thead>
        <th>ID</th>
        <th>NOME</th>
        <th>COGNOME</th>
        <th>TELEFONO</th>
        <th>EMAIL</th>
    </thead>
    <tbody>
    <?php


    foreach ($arr as $value) {

        echo "<tr><td>" . $value["id"] . "</td>";
        echo "<td>" . $value["nome"] . "</td>";
        echo "<td>" . $value["cognome"] . "</td>";
        echo "<td>" . $value["telefono"] . "</td>";
        echo "<td>" . $value["email"] . "</td></tr>";

    }

    ?>
    </tbody>
</table>
</body>
</html>