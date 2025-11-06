<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../db.php"); // asegúrate de que defina $dbh

if (!isset($_SESSION['idSesion'])) {
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';

    try {
        $stmt = $dbh->prepare("SELECT id, nombre, clave, contador FROM Usuarios WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos si el usuario existe y la contraseña es correcta
        if ($user && password_verify($clave, $user['clave'])) {
            $_SESSION['idSesion']  = session_create_id();
            $_SESSION['usuario']   = $user['nombre'];
            $_SESSION['idUsuario'] = $user['id'];
            $_SESSION['contador']  = $user['contador'] + 1;

            // Aumentar contador solo al iniciar sesión
            $upd = $dbh->prepare("UPDATE Usuarios SET contador = contador + 1 WHERE id = :id");
            $upd->bindParam(':id', $user['id'], PDO::PARAM_INT);
            $upd->execute();
        } else {
            // Si no coincide, redirige
            header("Location: login.html");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // temporalmente visible
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ingreso a la aplicación</title>
<style>
  body { font-family: Arial, sans-serif; margin: 20px; }
  h2 { color: #000; }
  .info {
    border: 1px solid #000;
    padding: 15px;
    margin-bottom: 15px;
  }
  button {
    margin-right: 10px;
    padding: 5px 10px;
  }
</style>
</head>
<body>

<h3>Ingreso a la aplicación</h3>

<div class="info">
  <h2>Información de Sesión</h2>
  <p><strong>Identificativo de sesión:</strong> <?php echo $_SESSION['idSesion']; ?></p>
  <p><strong>Login de usuario:</strong> <?php echo $_SESSION['usuario']; ?></p>
  <p><strong>Contador de sesión:</strong> <?php echo $_SESSION['contador']; ?></p>
</div>

<form>
  <button type="button" onclick="location.href='../../Php4/provincias_crud/index.php'">Ingrese al módulo 1 de la app</button>
  <button type="button" onclick="location.href='destruir_sesion.php'">Terminar sesión</button>
</form>

</body>
</html>