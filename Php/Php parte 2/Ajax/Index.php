<?php
if (isset($_POST['clave'])) {

  
    sleep(3);

    $clave = $_POST['clave'];
    $md5 = md5($clave);
    $sha1 = sha1($clave);

    echo "Request_method: POST<br>";
    echo "Clave: $clave<br><br>";
    echo "<b>Clave encriptada en md5 (128 bits o 16 pares hexadecimales):</b><br>$md5<br><br>";
    echo "<b>Clave encriptada en sha1 (160 bits o 20 pares hexadecimales):</b><br>$sha1";

} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Encriptador AJAX</title>
<style>
  body { margin:0; font-family: Arial; font-weight: bold; }
  .contenedor {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-template-rows: 250px 200px;
    height: 100vh;
  }
  .entrada { background: gray; padding: 20px; }
  .boton { background: blue; color: white; text-align: center; padding-top: 100px; cursor: pointer; position: relative; }
  .resultado { background: yellow; padding: 20px; overflow-y: auto; }
  .estado { grid-column: 1 / 4; background: #222; color: lightgray; padding: 20px; }
  #estado span { color: white; background: blue; padding: 3px 5px; }
  #flecha { display: none; width: 80px; position: absolute; top: 80px; left: 40%; transition: transform 2s ease-in-out; }
  #flecha.mover { transform: translateX(200px); }
</style>
</head>
<body>

<div class="contenedor">
  <div class="entrada">
    <label>Ingrese dato de entrada:</label><br>
    <input type="text" id="clave" />
  </div>

  <div class="boton" id="encriptarBtn">
    Encriptar
    <img id="flecha" src="flecha.jpeg" alt="→">
  </div>

  <div class="resultado" id="resultado">
    <h3>Resultado:</h3>
  </div>

  <div class="estado" id="estado">
    Estado del requerimiento:
  </div>
</div>

<script>
const boton = document.getElementById('encriptarBtn');
const resultado = document.getElementById('resultado');
const estado = document.getElementById('estado');
const flecha = document.getElementById('flecha');

boton.addEventListener('click', () => {
  const clave = document.getElementById('clave').value.trim();
  if (!clave) { alert("Ingrese una clave"); return; }

  
  flecha.style.display = "block";
  flecha.classList.add('mover');

  
  resultado.innerHTML = "<h3>Resultado:</h3> Esperando respuesta...";
  estado.innerHTML = "Estado del requerimiento: <span>ESPERANDO RESPUESTA</span>";

  const data = new URLSearchParams();
  data.append('clave', clave);

  const options = {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: data
  };

  fetch('', options)
    .then(res => res.text())
    .then(texto => {
      flecha.style.display = "none";
      resultado.innerHTML = `<h3>Resultado:</h3>${texto}`;
      estado.innerHTML = "Estado del requerimiento: <span>CUMPLIDO</span>";
      flecha.classList.remove('mover');
    })
    .catch(() => {
      flecha.style.display = "none";
      resultado.innerHTML = "<h3>Resultado:</h3>Error en la comunicación.";
      estado.innerHTML = "Estado del requerimiento: <span>ERROR</span>";
      flecha.classList.remove('mover');
    });
});
</script>

</body>
</html>
<?php
}
?>
