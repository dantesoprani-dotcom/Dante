<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: index.php");
  exit();
}
require_once '../../db.php';
$respuesta_estado = "Parte Modificacion simple de datos \n";

$codCliente  = isset($_POST['codCliente']) ? trim($_POST['codCliente']) : '';
$direccion   = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
$provincia   = isset($_POST['provincia']) ? intval($_POST['provincia']) : 0;
$fecha       = isset($_POST['fecha']) ? $_POST['fecha'] : null;
$hora        = isset($_POST['hora']) ? $_POST['hora'] : null;
$costo       = isset($_POST['costo']) ? floatval($_POST['costo']) : 0.0;

try {
    sleep(3);
    $sql = "UPDATE `Logísticos_Clientes`
        SET DirecciónEntrega = :direccion,
            ProvinciaEntrega = :provincia,
            FechaEntrega = :fecha,
            HorarioEntrega = :hora,
            CostoEstimadoTransporte = :costo
        WHERE Codcliente = :codCliente";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':codCliente', $codCliente);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':provincia', $provincia, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora', $hora);
    $stmt->bindParam(':costo', $costo);
    $stmt->execute();
    $respuesta_estado .= "\nModificacion simple exitosa para codCliente: " . $codCliente;
} catch (PDOException $e) {
    $respuesta_estado .= "\nError en modi: " . $e->getMessage();
    echo $respuesta_estado;
    $dbh = null;
    exit;
}

if(!isset($_FILES['fotoEntrega'])) {
    $respuesta_estado .= "\nNo se envió file (global \$_FILES no inicializado).";
} else 
    if (!empty($_FILES['fotoEntrega']['name'])) {
    // PASO 1: Leer archivo
    $contenidoPdf = file_get_contents($_FILES['fotoEntrega']['tmp_name']);
    // ↑ Variable: $contenidoPdf
    
    $sql2 = "UPDATE `Logísticos_Clientes`
             SET FotoEntrega = :foto
             WHERE Codcliente = :codCliente";
    
    $stmt2 = $dbh->prepare($sql2);
    
    // PASO 2: Usar LA MISMA VARIABLE
    $stmt2->bindParam(':foto', $contenidoPdf, PDO::PARAM_LOB);
    // ↑ CORRECTO: $contenidoPdf (mismo nombre)
    
    $stmt2->bindParam(':codCliente', $codCliente);
    $stmt2->execute();
}
