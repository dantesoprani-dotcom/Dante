<?php
// modi.php - modifica campos simples y luego actualiza binario si llega.
require_once 'db.php';
$respuesta_estado = "Parte Modificacion simple de datos \n";

$codProv = isset($_POST['codProv']) ? trim($_POST['codProv']) : '';
$nombreProv = isset($_POST['nombreProv']) ? trim($_POST['nombreProv']) : '';
$region = isset($_POST['region']) ? trim($_POST['region']) : null;
$fechaAlta = isset($_POST['fechaAlta']) ? $_POST['fechaAlta'] : null;
$poblacion = isset($_POST['poblacion']) ? intval($_POST['poblacion']) : 0;

try {
    $sql = "UPDATE provincias SET nombreProv=:nombreProv, region=:region, fechaAlta=:fechaAlta, poblacion=:poblacion WHERE codProv=:codProv;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':nombreProv', $nombreProv);
    $stmt->bindParam(':region', $region);
    $stmt->bindParam(':fechaAlta', $fechaAlta);
    $stmt->bindParam(':poblacion', $poblacion);
    $stmt->bindParam(':codProv', $codProv);
    $stmt->execute();
    $respuesta_estado .= "\nModificacion simple exitosa para codProv: " . $codProv;
} catch (PDOException $e) {
    $respuesta_estado .= "\nError en modi: " . $e->getMessage();
    echo $respuesta_estado;
    $dbh = null;
    exit;
}

// Si llega archivo, actualizar el binario
if(!isset($_FILES['documentoPdf'])) {
    $respuesta_estado .= "\nNo se envió file (global \$_FILES no inicializado).";
} else {
    if (empty($_FILES['documentoPdf']['name'])) {
        $respuesta_estado .= "\nNo ha sido seleccionado ningun file para enviar!";
    } else {
        $contenidoPdf = file_get_contents($_FILES['documentoPdf']['tmp_name']);
        try {
            $sql2 = "UPDATE provincias SET documentoPdf = :contenidoPdf WHERE codProv = :codProv;";
            $stmt2 = $dbh->prepare($sql2);
            $stmt2->bindParam(':contenidoPdf', $contenidoPdf, PDO::PARAM_LOB);
            $stmt2->bindParam(':codProv', $codProv);
            $stmt2->execute();
            $respuesta_estado .= "\nArchivo actualizado para codProv: " . $codProv;
        } catch (PDOException $e) {
            $respuesta_estado .= "\nError guardando file: " . $e->getMessage();
        }
    }
}

echo $respuesta_estado;
$dbh = null;
