<?php
session_start();
include("../db.php");
if (!isset($_SESSION['idSesion'])) {
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';

    try {
        $stmt = $dbh->prepare("SELECT * FROM Usuarios WHERE Nombre= :usuario");
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($clave, $user['Clave'])) {
            $_SESSION['idSesion']  = session_create_id();
            $_SESSION['usuario']   = $user['Nombre'];
            $_SESSION['contador']  = $user['Contador'] + 1; // lo mantenés también en $_SESSION

            // 🔹 Aumentar contador en la base de datos (solo al iniciar sesión)
            $upd = $dbh->prepare("UPDATE Usuarios SET Contador = Contador + 1 WHERE Nombre= :usuario");
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $upd->execute();

        } else {
            header("Location: login.html");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error de autenticación: " . $e->getMessage());
        exit();
    }
}
echo "<h3>Ingreso a la aplicación</h3>";

echo "<h2>Información de Sesión</h2>";
echo "<p><strong>Identificativo de sesión:</strong> " . $_SESSION['idSesion'] . "</p>";
echo "<p><strong>Login de usuario:</strong> " . $_SESSION['usuario'] . "</p>";
echo "<p><strong>Contador de sesión:</strong> " . $_SESSION['contador'] . "</p>";

echo "<button onclick=\"location.href='../../Php4/provincias_crud/index.php'\">Ingrese al módulo 1 de la app</button>";
echo "<button onclick=\"location.href='destruir_sesion.php'\">Terminar sesión</button>";
?>