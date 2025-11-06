<?php
session_start();
if (!isset($_SESSION['idSesion'])) {
  header("Location: ../login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Datos Logísticos de Provincias</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Segoe UI", Arial, sans-serif; }
    body { background-color: #f2f4f8; color: #333; }
    header, footer {
      position: fixed; left: 0; width: 100%;
      background-color: #0056b3; color: white; z-index: 10;
    }
    header {
      top: 0; height: 70px;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }
    footer {
      bottom: 0; height: 50px; text-align: center; line-height: 50px;
      font-weight: 600; box-shadow: 0 -2px 6px rgba(0,0,0,0.3);
    }
    .table-container { position: absolute; top: 70px; bottom: 50px; left: 0; right: 0; overflow: hidden; padding: 20px; }
    .botones { display: flex; gap: 10px; }
    button {
      background-color: white; border: 2px solid #0056b3; color: #0056b3;
      padding: 8px 14px; border-radius: 6px; font-weight: bold;
      cursor: pointer; transition: all 0.2s ease-in-out;
    }
    button:hover { background-color: #0056b3; color: white; }
    table {
      width: 100%; border-collapse: collapse; background-color: white;
      border-radius: 10px; overflow: hidden; box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      overflow-y: auto;
    }
    thead, tfoot { background-color: #0077cc; color: white; }
    thead th, tfoot th { padding: 12px; text-align: left; position: sticky; z-index: 5; }
    thead th { top: 0; }
    tfoot th { bottom: 0; background-color: orange; color: #000; }
    tbody { display: block; height: calc(100vh - 220px); overflow-y: auto; width: 100%; }
    thead, tfoot, tbody tr { display: table; width: 100%; table-layout: fixed; }
    th { background-color: #0077cc; color: white; padding: 12px; text-align: left; position: sticky; top: 0; z-index: 5; }
    td { padding: 10px; border-bottom: 1px solid #ddd; }
    tr:nth-child(even) { background-color: #f0f6ff; }
    tfoot th { background-color: orange; color: #000; padding: 12px; font-weight: bold; position: sticky; bottom: 0; z-index: 4; }
    .modal { display: none; position: fixed; z-index: 100; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.75); justify-content: center; align-items: center; backdrop-filter: blur(3px); }
    .modal-content {
      background-color: #fff; width: 90%; max-width: 900px; border-radius: 10px;
      padding: 20px; overflow-y: auto; max-height: 90%;
      box-shadow: 0 0 20px rgba(0,0,0,0.4); animation: aparecer 0.22s ease-in-out;
    }
    @keyframes aparecer { from { transform: scale(0.98); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .close { float: right; font-size: 22px; font-weight: bold; color: red; cursor: pointer; }
    body.modal-open { overflow: hidden; pointer-events: none; }
    body.modal-open #modalForm, body.modal-open #modalFormModif { pointer-events: auto; }
    #formulario header, #formulario footer, #formularioModif header, #formularioModif footer {
      background-color: rgb(0, 4, 255); color: white; text-align: center; padding: 10px;
    }
    #formulario main, #formularioModif main { background-color: silver; padding: 10px; margin-top: 10px; }
    form { width: 100%; overflow: hidden; }
    label { display: block; margin-left: 15px; margin-bottom: 8px; }
    input, select { display: block; width: 320px; height: 50px; margin-left: 15px; margin-bottom: 18px; padding: 0.4em 0.5em; font-size: 1rem; }
    .form-box { width: 45%; float: left; padding: 10px; margin: 0.5%; }
    .botonesForm { clear: both; width: 100%; text-align: center; padding: 10px; margin-top: 20px; }
    .botonesForm button {
      padding: 10px 20px; margin: 10px; font-size: 1rem; width: 33%;
      border-radius: 8px; border: none; background-color: rgb(0, 4, 255); color: white; cursor: pointer;
    }
    @media (max-width: 900px) { th.ocultar-columna, td.ocultar-columna { display: none; } }
  </style>
</head>
<body>
  <header>
    <h2>Datos Logísticos de Clientes</h2>
    <div class="botones">
      <button id="cargar">Cargar datos</button>
      <button id="vaciar">Vaciar datos</button>
      <button id="abrirForm">Cargar form</button>
      <button id="altaRegistro">Alta registro</button>
      <button id="limpiarFiltros">Limpiar filtros</button>
    </div>
  </header>

  <div class="table-container">
    <table id="tablaProvincias">
      <thead>
        <tr>
          <th>Código de Provincia</th>
          <th>Descripción</th>
          <th>Código Cliente</th>
          <th class="ocultar-columna">Dirección de Entrega</th>
          <th>Fecha</th>
          <th>Horario</th>
          <th>Costo Estimado</th>
          <th>PDF</th>
          <th>Modif.</th>
          <th>Baja</th>
        </tr>
      </thead>
      <tbody id="datos"></tbody>
    </table>
  </div>

  <footer>Hecho por Dante Soprani.</footer>

  <!-- Modal Alta -->
  <div id="modalForm" class="modal">
    <div class="modal-content">
      <span class="close" id="cerrarModal">&times;</span>
      <header><h1>Formulario para Alta</h1></header>
      <main>
        <form id="formProvincias">
          <div class="form-box">
            <label for="CodProv">Código de provincia:</label>
            <input type="text" id="CodProv" required>
            <label for="Descripcion">Descripción:</label>
            <input type="text" id="Descripcion" required>
            <label for="DireccionEntrega">Dirección de entrega:</label>
            <input type="text" id="DireccionEntrega" required>
          </div>
          <div class="form-box">
            <label for="FechaEntrega">Fecha:</label>
            <input type="date" id="FechaEntrega" required>
            <label for="HorarioEntrega">Horario:</label>
            <input type="time" id="HorarioEntrega" required>
            <label for="CostoEstimadoTransporte">Costo estimado transporte:</label>
            <input type="number" id="CostoEstimadoTransporte" required>
          </div>
          <div class="botonesForm"><button type="submit">Guardar</button></div>
        </form>
      </main>
    </div>
  </div>

  <!-- Modal Modificación -->
  <div id="modalFormModif" class="modal">
    <div class="modal-content">
      <span class="close" id="cerrarModalModif">&times;</span>
      <header><h1>Formulario de Modificación</h1></header>
      <main>
        <form id="formModif">
          <div class="form-box">
            <label for="CodProvModif">Código de provincia:</label>
            <input type="text" id="CodProvModif" required>
            <label for="DescripcionModif">Descripción:</label>
            <input type="text" id="DescripcionModif" required>
            <label for="DireccionModif">Dirección de entrega:</label>
            <input type="text" id="DireccionModif" required>
          </div>
          <div class="form-box">
            <label for="FechaModif">Fecha:</label>
            <input type="date" id="FechaModif" required>
            <label for="HorarioModif">Horario:</label>
            <input type="time" id="HorarioModif" required>
            <label for="CostoModif">Costo estimado transporte:</label>
            <input type="number" id="CostoModif" required>
          </div>
          <div class="botonesForm"><button type="submit">Guardar Cambios</button></div>
        </form>
      </main>
    </div>
  </div>

  <script>
    // === CARGA INICIAL (desde localStorage o JSON por defecto) ===
    const datosGuardados = localStorage.getItem("provincias");
    let objProvincias = datosGuardados
      ? JSON.parse(datosGuardados)
      : {
          provincias: [
            { codProv: "CBA", Descripcion: "Córdoba", Codcliente: "001", DireccionEntrega: "Plaza San Martín", FechaEntrega: "2025-10-20", HorarioEntrega: "10:00", CostoEstimadoTransporte: 3500 }
          ]
        };

    const tbody = document.getElementById("datos");

    // === GUARDAR EN LOCALSTORAGE ===
    function guardarLocal() {
      localStorage.setItem("provincias", JSON.stringify(objProvincias));
    }

    // === MOSTRAR DATOS EN TABLA ===
    function mostrarProvincias() {
      tbody.innerHTML = "";
      objProvincias.provincias.forEach((p, index) => {
        const fila = document.createElement("tr");
        fila.innerHTML = `
          <td>${p.codProv}</td>
          <td>${p.Descripcion}</td>
          <td>${p.Codcliente}</td>
          <td class="ocultar-columna">${p.DireccionEntrega}</td>
          <td>${p.FechaEntrega}</td>
          <td>${p.HorarioEntrega}</td>
          <td>$${p.CostoEstimadoTransporte.toLocaleString()}</td>
          <td><button class="pdfBtn">PDF</button></td>
          <td><button class="modiBtn">Modif.</button></td>
          <td><button class="bajaBtn">Borrar</button></td>`;
        tbody.appendChild(fila);

        fila.querySelector(".modiBtn").addEventListener("click", () => abrirFormularioModif(p, index));
        fila.querySelector(".bajaBtn").addEventListener("click", () => {
          if (confirm(`¿Seguro que querés borrar ${p.codProv}?`)) {
            objProvincias.provincias.splice(index, 1);
            guardarLocal();
            mostrarProvincias();
          }
        });
      });
    }

    // === BOTONES PRINCIPALES ===
    document.getElementById("cargar").addEventListener("click", mostrarProvincias);
    document.getElementById("vaciar").addEventListener("click", () => tbody.innerHTML = "");

    // === MODAL ALTA ===
    const modalAlta = document.getElementById("modalForm");
    document.getElementById("abrirForm").addEventListener("click", () => modalAlta.style.display = "flex");
    document.getElementById("cerrarModal").addEventListener("click", () => modalAlta.style.display = "none");

    document.getElementById("formProvincias").addEventListener("submit", (e) => {
      e.preventDefault();
      const nuevaProv = {
        codProv: document.getElementById("CodProv").value,
        Descripcion: document.getElementById("Descripcion").value,
        Codcliente: (objProvincias.provincias.length + 1).toString().padStart(3, "0"),
        DireccionEntrega: document.getElementById("DireccionEntrega").value,
        FechaEntrega: document.getElementById("FechaEntrega").value,
        HorarioEntrega: document.getElementById("HorarioEntrega").value,
        CostoEstimadoTransporte: parseFloat(document.getElementById("CostoEstimadoTransporte").value)
      };
      objProvincias.provincias.push(nuevaProv);
      guardarLocal();
      modalAlta.style.display = "none";
      mostrarProvincias();
    });

    // === MODAL MODIFICACIÓN ===
    const modalModif = document.getElementById("modalFormModif");
    document.getElementById("cerrarModalModif").addEventListener("click", () => modalModif.style.display = "none");

    function abrirFormularioModif(p, index) {
      modalModif.style.display = "flex";
      document.getElementById("CodProvModif").value = p.codProv;
      document.getElementById("DescripcionModif").value = p.Descripcion;
      document.getElementById("DireccionModif").value = p.DireccionEntrega;
      document.getElementById("FechaModif").value = p.FechaEntrega;
      document.getElementById("HorarioModif").value = p.HorarioEntrega;
      document.getElementById("CostoModif").value = p.CostoEstimadoTransporte;

      document.getElementById("formModif").onsubmit = (e) => {
        e.preventDefault();
        p.codProv = document.getElementById("CodProvModif").value;
        p.Descripcion = document.getElementById("DescripcionModif").value;
        p.DireccionEntrega = document.getElementById("DireccionModif").value;
        p.FechaEntrega = document.getElementById("FechaModif").value;
        p.HorarioEntrega = document.getElementById("HorarioModif").value;
        p.CostoEstimadoTransporte = parseFloat(document.getElementById("CostoModif").value);
        guardarLocal();
        modalModif.style.display = "none";
        mostrarProvincias();
      };
    }

    // Mostrar datos guardados al cargar
    mostrarProvincias();
  </script>
</body>
</html>
