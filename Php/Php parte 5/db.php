<?php
// db.php - Ajusta estos valores según tu entorno XAMPP / MySQL
$DB_HOST = 'localhost';
$DB_NAME = 'u255134318_KpPDe';
$DB_USER = 'u255134318_593yR';
$DB_PASS = 'k9$Mhd1pJgl';

try {
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME";
    $dbh = new PDO($dsn, $DB_USER, $DB_PASS);
} catch (PDOException $e) {
    // Si falla la conexión, muestra un error genérico (no sensible)
    echo " Error al conectar a la base de datos. Intente más tarde.";
    error_log("DB_CONN_ERROR: " . $e->getMessage()); // Guarda el detalle en logs del servidor
    exit;
}
?>
