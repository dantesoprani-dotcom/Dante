<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: ./provincias_crud/index.php");
  exit();
}
session_unset();
session_destroy();
header("Location: login.html");
exit();
?>