<?php
// traeBinario.php - retorna JSON con el documentoPdf codificado en base64 para un codProv
require_once 'db.php';
$codProv = isset($_POST['codProv']) ? trim($_POST['codProv']) : '';
$respuesta_estado = "";

try {
    $sql = "SELECT documentoPdf FROM provincias WHERE codProv = :codProv LIMIT 1;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':codProv', $codProv);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    $obj = new stdClass();
    if ($fila && isset($fila['documentoPdf']) && $fila['documentoPdf'] !== null && $fila['documentoPdf'] !== '') {
        $obj->documentoPdf = base64_encode($fila['documentoPdf']);
    } else {
        $obj->documentoPdf = '';
    }
    // JSON_SAFE: evitar problemas utf8
    echo json_encode($obj, JSON_INVALID_UTF8_SUBSTITUTE);
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
$dbh = null;
