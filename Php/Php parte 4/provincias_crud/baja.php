<?php
// baja.php - elimina la provincia por codProv
require_once 'db.php';
$codProv = isset($_POST['codProv']) ? trim($_POST['codProv']) : '';
$respuesta_estado = "Baja: ";
try {
    $sql = "DELETE FROM provincias WHERE codProv = :codProv;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':codProv', $codProv);
    $stmt->execute();
    $respuesta_estado .= "se elimino codProv: " . $codProv;
} catch (PDOException $e) {
    $respuesta_estado .= "Error en baja: " . $e->getMessage();
}
echo $respuesta_estado;
$dbh = null;
