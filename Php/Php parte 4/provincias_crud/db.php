<?php
// db.php - Ajusta estos valores según tu entorno XAMPP / MySQL
$DB_HOST = '127.0.0.1';
$DB_NAME = 'tu_base_de_datos';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";
    $dbh = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    echo "DB_CONN_ERROR: " . $e->getMessage();
    exit;
}
