<?php
// lista.php - devuelve JSON con todas las provincias
require_once 'db.php';

$respuesta = new stdClass();
$respuesta->provincias = array();

$sql = "SELECT codProv,nombreProv,region,fechaAlta,poblacion, (documentoPdf IS NOT NULL AND documentoPdf <> '') as hasDocumento FROM provincias ORDER BY nombreProv;";
try {
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $respuesta->provincias[] = $fila;
    }
    echo json_encode($respuesta);
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
$dbh = null;
