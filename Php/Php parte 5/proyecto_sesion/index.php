<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplicación</title>
  <style>
    body { background: #e0fbfc; font-family: "Segoe UI", sans-serif; text-align: center; padding-top: 80px; }
    h2 { color: #023e8a; }
    .card {
      background: #fff;
      margin: auto;
      width: 400px;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }
    button {
      padding: 10px 16px;
      background: #0077b6;
      color: #fff;
      border: none;
      border-radius: 6px;
      margin-top: 20px;
      cursor: pointer;
    }
    button:hover { background: #023e8a; }
  </style>
</head>
<body>
  <div class="card">
    <h2>Hola <?php echo $_SESSION['usuario']; ?> 👋</h2>
    <p>Estás dentro de la aplicación protegida por sesión.</p>
    <p><strong>Sesión activa:</strong> <?php echo $_SESSION['idSesion']; ?></p>
    <p><strong>Contador:</strong> <?php echo $_SESSION['contador']; ?></p>
    <button onclick="location.href='destruir_sesion.php'">Cerrar Sesión</button>
  </div>
</body>
</html>