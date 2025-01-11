let ultimoNumeroIngresado = 0;
var rango = new Array(0, 2.9, 3.9, 4.5, 5.0); // Las notas validas estan entre 1.0 y 5.0
var escala = new Array("", "Bajo", "Basico", "Alto", "Superior");
var formData = new FormData();
formData.append("curso", "210A");
$(function () {
  $("#fecha").datepicker();
  $("input[type=button]").button();
  $("#mensaje").dialog({
    autoOpen: false,
    buttons: {
      Ok: function () {
        $(this).dialog("close");
      },
    },
  });
  var html = '<table id="tabla1" border="1" align="center">';
  html += "<tr><th>CODIGO</th><th>ALUMNO</th>";
  html += "</tr>";
  $.each(CodsAlum, function (idalu, codalu) {
    html +=
      '<tr><td align="center">' +
      codalu +
      "</td><td>" +
      Alumnos[codalu] +
      "</td>";
    html += "</tr>";
  });
  html += "</table>";
  $("#contenedor").html(html);
  $(document).on("change", ".entrada", function () {
    CambiarColor($(this).attr("id"), $(this).val());
  });
  $("#masCol").click(function () {
    AdicionarColumna();
  });
  $("#grabar").click(function () {
    GrabarNotas();
  });
});
function CambiarColor(id, nota) {
  var CDesemp = "W" + id.substr(1, 5);
  var CFinal = "X" + id.substr(1, 5);
  if (nota <= rango[4]) {
    formData.append(id, nota);
    $("#" + CDesemp).html(Desempeno(nota));
    $("#" + CFinal).val(nota);
  }
  if (nota <= rango[1]) $("#" + id).css("color", "red");
  else if (nota <= rango[2]) $("#" + id).css("color", "orange");
  else if (nota <= rango[3]) $("#" + id).css("color", "green");
  else if (nota <= rango[4]) $("#" + id).css("color", "blue");
  else $("#" + id).val("");
}
function Desempeno(nota) {
  if (nota == "") return "";
  if (nota <= rango[1]) return "Bajo";
  if (nota <= rango[2]) return "Básico";
  if (nota <= rango[3]) return "Alto";
  if (nota <= rango[4]) return "Superior";
}

function AdicionarColumna() {
  const cantidadNotas = parseInt(prompt("¿Cuántas notas desea agregar?"), 10);

  if (isNaN(cantidadNotas) || cantidadNotas <= 0) {
    alert("Por favor, ingrese un número válido mayor a 0.");
    return;
  }

  ultimoNumeroIngresado += cantidadNotas;

  const ColumnasActuales = $("#tabla1 tr:first th").length - 2;
  $("#tabla1 tr").each(function () {
    if ($(this).find("td, th").length < 4) return;
    $(this).find("td, th").slice(-2).remove();
  });
  $("#tabla1 tr").each(function (indice, columna) {
    if (indice === 0) {
      for (let i = 1; i <= cantidadNotas; i++) {
        $(columna).append(
          "<th>Nota " + (ultimoNumeroIngresado - cantidadNotas + i) + "</th>"
        );
      }

      $(columna).append("<th>Promedio</th>");
      $(columna).append("<th>Desempeño</th>");
    } else {
      const codalu = $(columna).find("td:first").text();

      const tdPromedio = $(columna).find("td.promedio");
      const tdDesempeno = $(columna).find("td div[id^='W']");

      for (let i = 1; i <= cantidadNotas; i++) {
        const nuevoCampo =
          '<td><input type="text" id="A' +
          codalu +
          "_" +
          (ultimoNumeroIngresado - cantidadNotas + i) +
          '" size="" class="entrada"></td>';

        if (tdPromedio.length) {
          $(nuevoCampo).insertBefore(tdPromedio);
        } else {
          $(columna).append(nuevoCampo);
        }
      }

      if (!$(columna).find("td input.promedio").length) {
        const campoPromedio =
          '<td><input type="text" id="X' +
          codalu +
          '" class="promedio" readonly></td>';
        $(columna).append(campoPromedio);
      }

      if (!$(columna).find("td div[id^='W']").length) {
        const campoDesempeno = '<td><div id="W' + codalu + '"></div></td>';
        $(columna).append(campoDesempeno);
      }
    }
  });

  $(document).on("change", ".entrada", function () {
    const fila = $(this).closest("tr");
    actualizarPromedioYDesempeno(fila);
  });
}

function actualizarPromedioYDesempeno(fila) {
  let suma = 0;
  let count = 0;

  $(fila)
    .find(".entrada")
    .each(function () {
      const valor = parseFloat($(this).val());
      if (!isNaN(valor) && valor >= 1.0 && valor <= 5.0) {
        suma += valor;
        count++;
      } else {
        alert("Ingrese un valor válido entre 1.0 y 5.0.");
        $(this).val("");
      }
    });

  const promedio = count > 0 ? (suma / count).toFixed(2) : "";

  const codalu = $(fila).find("td:first").text();
  const idPromedio = "X" + codalu;
  $("#" + idPromedio).val(promedio);

  const desempeno = Desempeno(promedio);
  const idDesempeno = "W" + codalu;
  $("#" + idDesempeno).html(desempeno);
}

function GrabarNotas() {
  alert("Implementar Obligario....");
}
