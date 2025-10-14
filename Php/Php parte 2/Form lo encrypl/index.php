<?php
if (isset($_POST['clave'])) {
    $clave = $_POST['clave'];

    $md5 = md5($clave);
    $sha1 = sha1($clave);

    echo "<h2>CLAVE: $clave</h2>";
    echo "<p>Clave encriptada con md5: $md5</p>";
    echo "<p>Clave encriptada con sha1: $sha1</p>";

    echo "<br><a href='formEncripta.php'>Volver</a>";
} else {
?>
    <html>
    <head>
        <title>Encriptar Clave</title>
    </head>
    <body>
        <h2>Formulario de Encriptación</h2>
       
        <form method="post">
            Ingrese la clave: 
            <input type="text" name="clave" required>
            <input type="submit" value="Enviar" id="e">
        </form>
         <script>
            document.getElementById("miFormulario").addEventListener("submit", function(event) {
                event.preventDefault();
                });
         </script>
    </body>
    </html>
<?php
}
?>
