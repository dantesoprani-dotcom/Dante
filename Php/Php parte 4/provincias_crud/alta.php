<?php
// alta.php - inserta una nueva provincia (sin su binario) y luego si llega archivo lo actualiza.
require_once 'db.php';

$respuesta_estado = "Parte alta simple de datos\n";

$codProv = isset($_POST['codProv']) ? trim($_POST['codProv']) : '';
$nombreProv = isset($_POST['nombreProv']) ? trim($_POST['nombreProv']) : '';
$region = isset($_POST['region']) ? trim($_POST['region']) : null;
$fechaAlta = isset($_POST['fechaAlta']) ? $_POST['fechaAlta'] : null;
$poblacion = isset($_POST['poblacion']) ? intval($_POST['poblacion']) : 0;

try {
    $sql = "INSERT INTO provincias (codProv,nombreProv,region,fechaAlta,poblacion) VALUES (:codProv,:nombreProv,:region,:fechaAlta,:poblacion);";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':codProv', $codProv);
    $stmt->bindParam(':nombreProv', $nombreProv);
    $stmt->bindParam(':region', $region);
    $stmt->bindParam(':fechaAlta', $fechaAlta);
    $stmt->bindParam(':poblacion', $poblacion);
    $stmt->execute();
    $respuesta_estado .= "\nAlta exitosa para codProv: " . $codProv;
} catch (PDOException $e) {
    $respuesta_estado .= "\nError en alta: " . $e->getMessage();
    echo $respuesta_estado;
    $dbh = null;
    exit;
}

// Manejo del archivo binario (si existe)
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
            $respuesta_estado .= "\nArchivo guardado para codProv: " . $codProv;
        } catch (PDOException $e) {
            $respuesta_estado .= "\nError guardando file: " . $e->getMessage();
        }
    }
}

echo $respuesta_estado;
$dbh = null;
