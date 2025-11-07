<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: index.php");
  exit();
}
require_once '../../db.php';
$codProv = isset($_POST['codProv']) ? trim($_POST['codProv']) : '';
$respuesta_estado = "";

try {
    sleep(3);
    $sql = "SELECT FotoEntrega FROM Logísticos_Clientes WHERE Codcliente = :codProv LIMIT 1;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':codProv', $codProv);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    $obj = new stdClass();
    if ($fila && isset($fila['FotoEntrega']) && $fila['FotoEntrega'] !== null && $fila['FotoEntrega'] !== '') {
        $obj->documentoPdf = base64_encode($fila['FotoEntrega']);
    } else {
        $obj->documentoPdf = '';
    }
    // JSON_SAFE: evitar problemas utf8
    echo json_encode($obj, JSON_INVALID_UTF8_SUBSTITUTE);
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
$dbh = null;
