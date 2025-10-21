<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    sleep(3);

    $objRegistro = new stdClass();
    $objRegistro->codigoUsuario = $_POST['codigoUsuario'];
    $objRegistro->apellidoUsuario = $_POST['apellidoUsuario'];
    $objRegistro->nombreUsuario = $_POST['nombreUsuario'];

    $jsonRegistro = json_encode($objRegistro, JSON_UNESCAPED_UNICODE);

    echo $jsonRegistro;
} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Form to JSON con API Fetch</title>
<style>
  body { font-family: Arial, sans-serif; font-weight: bold; }
  label { display: block; margin-top: 8px; }
  input { margin-bottom: 10px; display: block; }
  #resultado { margin-top: 20px; background-color: #eef; padding: 10px; border-radius: 8px; }
</style>
</head>
<body>

<form id="formulario" method="post">
  <label for="codigoUsuario">Código Usuario</label>
  <input type="text" name="codigoUsuario" id="codigoUsuario" placeholder="Ej: 1234">

  <label for="apellidoUsuario">Apellido de Usuario</label>
  <input type="text" name="apellidoUsuario" id="apellidoUsuario" placeholder="Ej: Pérez">

  <label for="nombreUsuario">Nombre de Usuario</label>
  <input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Ej: Juan">

  <input type="submit" value="Enviar form de manera tradicional">
</form>

<button id="disparo" type="button">
  Disparar requerimiento asincrónico AJAX
</button>

<div id="resultado"></div>

<script>

const btn = document.getElementById('disparo');
const form = document.getElementById('formulario');
const resultado = document.getElementById('resultado');


btn.addEventListener('click', () => {
  resultado.innerHTML = "Esperando respuesta...";


  const datosFormulario = new FormData(form);

  const options = {
    method: 'POST',
    body: datosFormulario
  };

  
  fetch('', options)
    .then(res => res.text())
    .then(texto => {
      resultado.innerHTML = "<b>Respuesta del servidor (JSON):</b><br>" + texto;
    })
    .catch(error => {
      resultado.innerHTML = "Error: " + error;
    });
});
</script>

</body>
</html>
<?php
}
?>
