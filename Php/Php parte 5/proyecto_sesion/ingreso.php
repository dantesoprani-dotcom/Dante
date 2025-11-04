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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenido</title>
  <style>
    body {
      background: #f1f5f9;
      font-family: "Segoe UI", sans-serif;
      text-align: center;
      padding-top: 60px;
    }
    h1 { color: #0077b6; }
    .box {
      background: #fff;
      display: inline-block;
      padding: 25px 40px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.15);
      margin-top: 20px;
    }
    button {
      padding: 10px 18px;
      margin: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
      color: #fff;
    }
    .btn-continue { background-color: #00b4d8; }
    .btn-exit { background-color: #ef476f; }
    button:hover { opacity: 0.85; }
  </style>
</head>
<body>
  <h1>¡Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h1>
  <div class="box">
    <p><strong>ID de Sesión:</strong> <?php echo $_SESSION['idSesion']; ?></p>
    <p><strong>Contador de sesión:</strong> <?php echo $_SESSION['contador']; ?></p>

    <button class="btn-continue" onclick="location.href='index.php'">Ir a la aplicación</button>
    <button class="btn-exit" onclick="location.href='destruir_sesion.php'">Cerrar sesión</button>
  </div>
</body>
</html>