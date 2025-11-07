<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: index.php");
  exit();
}
require_once '../../db.php';

$codCliente  = isset($_POST['codCliente']) ? trim($_POST['codCliente']) : '';
$direccion   = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
$provincia   = isset($_POST['provincia']) ? intval($_POST['provincia']) : 0;
$fecha       = isset($_POST['fecha']) ? $_POST['fecha'] : null;
$hora        = isset($_POST['hora']) ? $_POST['hora'] : null;
$costo       = isset($_POST['costo']) ? floatval($_POST['costo']) : 0.0;

$respuesta_estado = "";

try {
    // Inserta los datos principales (sin la foto)
    sleep(3);
    $sql = "INSERT INTO `Logísticos_Clientes`
            (Codcliente, DirecciónEntrega, ProvinciaEntrega, FechaEntrega, HorarioEntrega, CostoEstimadoTransporte)
            VALUES (:codCliente, :direccion, :provincia, :fecha, :hora, :costo)";
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':codCliente', $codCliente);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':provincia', $provincia, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora', $hora);
    $stmt->bindParam(':costo', $costo);
    $stmt->execute();

    $respuesta_estado .= "\nAlta exitosa para Codcliente: " . $codCliente;
} catch (PDOException $e) {
    $respuesta_estado .= "\nError en alta: " . $e->getMessage();
    echo $respuesta_estado;
    $dbh = null;
    exit;
}

if (!isset($_FILES['fotoEntrega'])) {
    $respuesta_estado .= "\nNo se envió ningún archivo (global \$_FILES no inicializado).";
} else {
    if (empty($_FILES['fotoEntrega']['name'])) {
        $respuesta_estado .= "\nNo se seleccionó ningún archivo para enviar.";
    } else {
        $contenidoFoto = file_get_contents($_FILES['fotoEntrega']['tmp_name']);
        try {
            $sql2 = "UPDATE `Logísticos_Clientes`
                     SET FotoEntrega = :foto
                     WHERE Codcliente = :codCliente";
            $stmt2 = $dbh->prepare($sql2);
            $stmt2->bindParam(':foto', $contenidoFoto, PDO::PARAM_LOB);
            $stmt2->bindParam(':codCliente', $codCliente);
            $stmt2->execute();
            $respuesta_estado .= "\nArchivo guardado correctamente para Codcliente: " . $codCliente;
        } catch (PDOException $e) {
            $respuesta_estado .= "\nError guardando el archivo: " . $e->getMessage();
        }
    }
}
$dbh = null;
echo nl2br($respuesta_estado);
