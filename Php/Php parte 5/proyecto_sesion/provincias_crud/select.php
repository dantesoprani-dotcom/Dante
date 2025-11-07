<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: index.php");
  exit();
}
require_once '../../db.php';
$provincias=[];
$sql  = "SELECT * FROM Provincias";

try {
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $objProv = new stdClass();
        $objProv->codProv = $fila['codProv'];
        $objProv->Descripcion = $fila['Descripcion'];
        array_push($provincias, $objProv);
    }
    $objProvs = new stdClass();
    $objProvs->provincias = $provincias;
    $salidaJson = json_encode($objProvs);
    sleep(3);
    echo $salidaJson;
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
$dbh = null;
?>