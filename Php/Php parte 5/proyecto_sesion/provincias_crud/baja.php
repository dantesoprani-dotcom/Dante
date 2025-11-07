<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: index.php");
  exit();
}
require_once '../../db.php';
$codCliente  = isset($_POST['codCliente']) ? trim($_POST['codCliente']) : '';
$respuesta_estado = "Baja: ";
try {
  sleep(3);
    $sql = "DELETE FROM `Logísticos_Clientes` WHERE Codcliente = :codCliente;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':codCliente', $codCliente);
    $stmt->execute();
    $respuesta_estado .= "se elimino codCliente: " . $codCliente;
} catch (PDOException $e) {
    $respuesta_estado .= "Error en baja: " . $e->getMessage();
}
echo $respuesta_estado;
$dbh = null;
