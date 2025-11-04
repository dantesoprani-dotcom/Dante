<?php
session_start();

if (!isset($_SESSION['idSesion'])) {
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';

    $usuario_valido = 'admin';
    $clave_valida = 'clave987';

    if ($usuario === $usuario_valido && $clave === $clave_valida) {
        $_SESSION['idSesion'] = session_create_id();
        $_SESSION['usuario'] = "Dante Soprani";
        $_SESSION['contador'] = ($_SESSION['contador'] ?? 0) + 1;
    } else {
        header("Location: login.html");
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
  <button type="button" onclick="location.href='index.php'">Ingrese al módulo 1 de la app</button>
  <button type="button" onclick="location.href='destruir_sesion.php'">Terminar sesión</button>
</form>

</body>
</html>