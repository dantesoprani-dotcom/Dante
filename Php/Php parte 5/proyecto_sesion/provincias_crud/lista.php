<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: index.php");
  exit();
}
require_once '../../db.php';
$clientes=[];
$orden  = isset($_POST['orden']) ? trim($_POST['orden']) : '';
$codCliente  = isset($_POST['codCliente']) ? trim($_POST['codCliente']) : '';
$direccion   = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
$provincia   = isset($_POST['provincia']) ? intval($_POST['provincia']) : 0;
$fecha       = isset($_POST['fecha']) ? $_POST['fecha'] : null;
$hora        = isset($_POST['hora']) ? $_POST['hora'] : null;
$costo       = isset($_POST['costo']) ? floatval($_POST['costo']) : 0.0;

$sql  = "SELECT * FROM Logísticos_Clientes WHERE ";
$sql .= "Codcliente LIKE CONCAT('%', :codCliente, '%') AND ";
$sql .= "DirecciónEntrega LIKE CONCAT('%', :direccion, '%') AND ";
$sql .= "ProvinciaEntrega LIKE CONCAT('%', :provincia, '%') AND ";
$sql .= "FechaEntrega LIKE CONCAT('%', :fecha, '%') AND ";
$sql .= "HorarioEntrega LIKE CONCAT('%', :hora, '%') AND ";
$sql .= "CostoEstimadoTransporte LIKE CONCAT('%', :costo, '%') ";
$sql .= "ORDER BY $orden";

try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':codCliente', $codCliente);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':provincia', $provincia, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora', $hora);
    $stmt->bindParam(':costo', $costo);
    $stmt->bindParam(':orden', $orden);
    $stmt->execute();
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $objCliente = new stdClass();
    $objCliente->Codcliente = $fila['Codcliente'];
    $objCliente->DireccionEntrega = $fila['DirecciónEntrega'];
    $objCliente->ProvinciaEntrega = $fila['ProvinciaEntrega'];
    $objCliente->FechaEntrega = $fila['FechaEntrega'];
    $objCliente->HorarioEntrega = $fila['HorarioEntrega'];
    $objCliente->CostoEstimadoTransporte = $fila['CostoEstimadoTransporte'];
        array_push($clientes, $objCliente);
    }
    $objClientes = new stdClass();
    $objClientes->clientes = $clientes;
    $objClientes->cuenta = count($clientes);
    $salidaJson = json_encode($objClientes);
    sleep(3);
    echo $salidaJson;
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
$dbh = null;
?>