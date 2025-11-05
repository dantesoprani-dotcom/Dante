<?php
// db.php - Ajusta estos valores según tu entorno XAMPP / MySQL
$DB_HOST = 'srv1548.hstgr.io';
$DB_NAME = 'u255134318_KpPDe';
$DB_USER = 'u255134318_593yR';
$DB_PASS = 'k9$Mhd1pJgl';

try {
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";
    $dbh = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza errores claros
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve arrays asociativos
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa consultas preparadas reales
    ]);
} catch (PDOException $e) {
    // Si falla la conexión, muestra un error genérico (no sensible)
    echo " Error al conectar a la base de datos. Intente más tarde.";
    error_log("DB_CONN_ERROR: " . $e->getMessage()); // Guarda el detalle en logs del servidor
    exit;
}
?>