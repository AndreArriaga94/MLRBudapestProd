// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    "order": [[0,'asc']],
    language: {
      
      "decimal":        "",
      "emptyTable":     "No hay informacion disponible en la tabla",
      "info":           "Mostrando _START_ al _END_ de _TOTAL_ registros",
      "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
      "infoFiltered":   "(filtrando de _MAX_ registros totales)",
      "infoPostFix":    "",
      "thousands":      ",",
      "lengthMenu":     "Mostar _MENU_ registros",
      "loadingRecords": "Cargando...",
      "processing":     "Procesando...",
      "search":         "Buscar:",
      "zeroRecords":    "No se encontraron registros",
      "paginate": {
          "first":      "Primero",
          "last":       "Ultimo",
          "next":       "Siguiente",
          "previous":   "Anterior"
      }
    }
    
  });
});
